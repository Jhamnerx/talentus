<?php

namespace App\Http\Controllers\Api\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\StorePortalUsuarioRequest;
use App\Http\Requests\Portal\UpdatePortalUsuarioRequest;
use App\Models\ClienteUser;
use App\Notifications\Portal\InvitacionPortalNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Gestión de los usuarios del portal de una cuenta de cliente.
 * Solo el titular puede administrar a los colaboradores de su mismo cliente.
 */
class PortalUsuarioController extends Controller
{
    /**
     * Lista los usuarios del cliente (titular + colaboradores).
     */
    public function index(Request $request): JsonResponse
    {
        $titular = $this->soloTitular($request);

        $usuarios = ClienteUser::where('cliente_id', $titular->cliente_id)
            ->orderByRaw("FIELD(rol, 'titular', 'colaborador')")
            ->orderBy('name')
            ->get()
            ->map(fn (ClienteUser $usuario) => $this->perfil($usuario));

        return response()->json([
            'success' => true,
            'data' => $usuarios,
        ]);
    }

    /**
     * El titular invita a un colaborador: se crea aprobado y verificado, y se le
     * envía un enlace para que él mismo establezca su contraseña.
     */
    public function store(StorePortalUsuarioRequest $request): JsonResponse
    {
        $titular = $request->user();

        $colaborador = ClienteUser::create([
            'cliente_id' => $titular->cliente_id,
            'name' => $request->name,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Str::random(40), // temporal; el colaborador la define vía el enlace
            'rol' => 'colaborador',
            'estado' => 'aprobado',
        ]);

        $colaborador->forceFill(['email_verified_at' => now()])->save();

        // Invitación con enlace para que el colaborador establezca su contraseña.
        $token = Password::broker('cliente_users')->getRepository()->create($colaborador);
        $colaborador->notify(new InvitacionPortalNotification($token, $titular->cliente?->razon_social));

        return response()->json([
            'success' => true,
            'message' => 'Invitación enviada. El colaborador recibirá un correo para establecer su contraseña.',
            'data' => $this->perfil($colaborador),
        ], 201);
    }

    /**
     * Suspende o reactiva a un colaborador.
     */
    public function update(UpdatePortalUsuarioRequest $request, int $id): JsonResponse
    {
        $colaborador = $this->colaborador($request->user(), $id);

        $colaborador->update(['estado' => $request->estado]);

        if ($request->estado === 'suspendido') {
            $colaborador->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => $request->estado === 'suspendido'
                ? 'Colaborador suspendido.'
                : 'Colaborador reactivado.',
            'data' => $this->perfil($colaborador->fresh()),
        ]);
    }

    /**
     * Quita (elimina) a un colaborador y revoca sus tokens.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $colaborador = $this->colaborador($this->soloTitular($request), $id);

        $colaborador->tokens()->delete();
        $colaborador->delete();

        return response()->json([
            'success' => true,
            'message' => 'Colaborador eliminado.',
        ]);
    }

    protected function soloTitular(Request $request): ClienteUser
    {
        $usuario = $request->user();
        abort_unless(
            $usuario->esTitular(),
            403,
            'Solo el titular puede gestionar los usuarios de la cuenta.'
        );

        return $usuario;
    }

    /**
     * Resuelve un colaborador del mismo cliente. Nunca el propio titular ni otro titular.
     */
    protected function colaborador(ClienteUser $titular, int $id): ClienteUser
    {
        $colaborador = ClienteUser::where('cliente_id', $titular->cliente_id)
            ->where('id', $id)
            ->first();

        abort_if($colaborador === null, 404, 'Usuario no encontrado.');
        abort_if(
            $colaborador->id === $titular->id || $colaborador->rol === 'titular',
            403,
            'No puedes modificar al titular.'
        );

        return $colaborador;
    }

    /**
     * @return array<string, mixed>
     */
    protected function perfil(ClienteUser $usuario): array
    {
        return [
            'id' => $usuario->id,
            'name' => $usuario->name,
            'email' => $usuario->email,
            'telefono' => $usuario->telefono,
            'rol' => $usuario->rol,
            'estado' => $usuario->estado,
            'last_login_at' => optional($usuario->last_login_at)->toIso8601String(),
        ];
    }
}
