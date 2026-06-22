<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\ForgotPasswordPortalRequest;
use App\Http\Requests\Portal\LoginPortalRequest;
use App\Http\Requests\Portal\RegisterPortalRequest;
use App\Http\Requests\Portal\ResetPasswordPortalRequest;
use App\Http\Requests\Portal\UpdatePortalProfileRequest;
use App\Models\ClienteUser;
use App\Models\Clientes;
use App\Scopes\EmpresaScope;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PortalAuthController extends Controller
{
    /**
     * Registro de acceso al portal. El RUC debe existir como cliente.
     *
     * - RUC no existe                  -> rechaza (no es cliente).
     * - RUC existe CON correo          -> no revela; envía instrucciones al correo registrado (enmascarado).
     * - RUC existe SIN correo          -> crea la cuenta de portal y envía verificación.
     */
    public function register(RegisterPortalRequest $request): JsonResponse
    {
        $cliente = Clientes::withoutGlobalScope(EmpresaScope::class)
            ->where('numero_documento', $request->ruc)
            ->where('is_active', true)
            ->first();

        if (! $cliente) {
            return response()->json([
                'success' => false,
                'message' => 'No encontramos ese RUC como cliente. Contáctanos para habilitar tu acceso.',
            ], 404);
        }

        if (! empty($cliente->email)) {
            // El cliente ya tiene un correo registrado: no se revela, se notifica a ese correo.
            return response()->json([
                'success' => true,
                'message' => 'Este RUC ya tiene un correo registrado. Te enviamos instrucciones a tu correo.',
                'email_hint' => mask_email($cliente->email),
            ]);
        }

        if (ClienteUser::where('email', $request->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Ya existe una cuenta con este correo.',
            ]);
        }

        $esTitular = ! $cliente->clienteUsers()->exists();

        $clienteUser = ClienteUser::create([
            'cliente_id' => $cliente->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'rol' => $esTitular ? 'titular' : 'colaborador',
            'estado' => 'pendiente',
        ]);

        $clienteUser->sendEmailVerificationNotification();

        return response()->json([
            'success' => true,
            'message' => 'Registro recibido. Revisa tu correo para verificar tu cuenta.',
        ], 201);
    }

    /**
     * Verificación de correo (enlace firmado abierto desde el email).
     */
    public function verify(Request $request, int $id, string $hash): RedirectResponse
    {
        $clienteUser = ClienteUser::findOrFail($id);

        if (! hash_equals(sha1($clienteUser->email), $hash)) {
            abort(403, 'Enlace de verificación inválido.');
        }

        if (! $clienteUser->email_verified_at) {
            $clienteUser->forceFill(['email_verified_at' => now()])->save();
        }

        return redirect(rtrim(config('portal.url'), '/') . '/email-verificado');
    }

    /**
     * Reenvía el correo de verificación. Respuesta neutra (anti-enumeración).
     */
    public function resendVerification(Request $request): JsonResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $clienteUser = ClienteUser::where('email', $request->email)->first();

        if ($clienteUser && ! $clienteUser->email_verified_at) {
            $clienteUser->sendEmailVerificationNotification();
        }

        return response()->json([
            'success' => true,
            'message' => 'Si el correo está registrado y sin verificar, te enviamos un nuevo enlace.',
        ]);
    }

    /**
     * Login: emite token Sanctum con ability "portal".
     */
    public function login(LoginPortalRequest $request): JsonResponse
    {
        $clienteUser = ClienteUser::where('email', $request->email)->first();

        if (! $clienteUser || ! Hash::check($request->password, $clienteUser->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas.',
            ], 401);
        }

        if (! $clienteUser->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Verifica tu correo para activar tu cuenta.',
            ], 403);
        }

        if ($clienteUser->estado !== 'aprobado') {
            return response()->json([
                'success' => false,
                'message' => $this->mensajeEstado($clienteUser->estado),
                'estado' => $clienteUser->estado,
            ], 403);
        }

        $deviceName = $request->device_name ?? 'portal-web';
        $clienteUser->tokens()->where('name', $deviceName)->delete();

        $token = $clienteUser->createToken($deviceName, ['portal'])->plainTextToken;

        $clienteUser->forceFill(['last_login_at' => now()])->save();

        return response()->json([
            'success' => true,
            'token' => $token,
            'cliente_user' => $this->perfil($clienteUser),
            'cliente' => $this->cliente($clienteUser),
        ]);
    }

    /**
     * Logout: revoca el token actual.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }

    /**
     * Perfil del cliente autenticado.
     */
    public function me(Request $request): JsonResponse
    {
        $clienteUser = $request->user();

        return response()->json([
            'success' => true,
            'cliente_user' => $this->perfil($clienteUser),
            'cliente' => $this->cliente($clienteUser),
        ]);
    }

    /**
     * Actualiza datos básicos y, opcionalmente, la contraseña.
     */
    public function updateProfile(UpdatePortalProfileRequest $request): JsonResponse
    {
        $clienteUser = $request->user();

        $data = [
            'name' => $request->name,
            'telefono' => $request->telefono,
        ];

        if ($request->filled('password')) {
            if (! Hash::check($request->current_password, $clienteUser->password)) {
                throw ValidationException::withMessages([
                    'current_password' => 'La contraseña actual no es correcta.',
                ]);
            }

            $data['password'] = $request->password;
        }

        $clienteUser->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Perfil actualizado.',
            'cliente_user' => $this->perfil($clienteUser->fresh()),
        ]);
    }

    /**
     * Envía el enlace de recuperación. Respuesta neutra siempre.
     */
    public function forgotPassword(ForgotPasswordPortalRequest $request): JsonResponse
    {
        Password::broker('cliente_users')->sendResetLink(
            $request->only('email')
        );

        return response()->json([
            'success' => true,
            'message' => 'Si el correo está registrado, te enviamos instrucciones para restablecer tu contraseña.',
        ]);
    }

    /**
     * Restablece la contraseña y revoca todos los tokens activos.
     */
    public function resetPassword(ResetPasswordPortalRequest $request): JsonResponse
    {
        $status = Password::broker('cliente_users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (ClienteUser $clienteUser, string $password): void {
                $clienteUser->forceFill(['password' => Hash::make($password)])->save();
                $clienteUser->tokens()->delete();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return response()->json([
                'success' => false,
                'message' => __($status),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Contraseña restablecida. Inicia sesión con tu nueva contraseña.',
        ]);
    }

    protected function mensajeEstado(string $estado): string
    {
        return match ($estado) {
            'pendiente' => 'Tu cuenta está en revisión. Te avisaremos cuando sea aprobada.',
            'rechazado' => 'Tu solicitud de acceso fue rechazada. Contáctanos para más información.',
            'suspendido' => 'Tu acceso está suspendido. Contáctanos para reactivarlo.',
            default => 'Tu cuenta no está habilitada.',
        };
    }

    /**
     * @return array<string, mixed>
     */
    protected function perfil(ClienteUser $clienteUser): array
    {
        return [
            'id' => $clienteUser->id,
            'name' => $clienteUser->name,
            'email' => $clienteUser->email,
            'telefono' => $clienteUser->telefono,
            'rol' => $clienteUser->rol,
            'estado' => $clienteUser->estado,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function cliente(ClienteUser $clienteUser): array
    {
        $cliente = $clienteUser->cliente;

        return [
            'id' => $cliente->id,
            'razon_social' => $cliente->razon_social,
            'ruc' => $cliente->numero_documento,
        ];
    }
}
