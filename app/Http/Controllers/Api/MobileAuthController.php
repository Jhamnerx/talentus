<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MobileAuthController extends Controller
{
    /**
     * Login para la aplicación móvil de técnicos.
     * Devuelve un token Sanctum de larga duración.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'       => 'required|email',
            'password'    => 'required|string',
            'device_name' => 'nullable|string|max:100',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas',
            ], 401);
        }

        if (!$user->hasRole('tecnico')) {
            return response()->json([
                'success' => false,
                'message' => 'Acceso restringido: solo técnicos pueden usar la aplicación móvil',
            ], 403);
        }

        // Revocar tokens previos del mismo dispositivo para evitar acumulación
        $deviceName = $request->device_name ?? 'mobile-app';
        $user->tokens()->where('name', $deviceName)->delete();

        $token = $user->createToken($deviceName)->plainTextToken;

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => [
                'id'                => $user->id,
                'name'              => $user->name,
                'email'             => $user->email,
                'numero_documento'  => $user->numero_documento,
                'telefono'          => $user->telefonos,
                'ciudad_id'         => $user->ciudad_id,
                'profile_photo_url' => $user->profile_photo_url,
            ],
        ]);
    }

    /**
     * Logout: revoca el token actual del dispositivo.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente',
        ]);
    }

    /**
     * Devuelve el perfil del técnico autenticado.
     */
    public function me(Request $request)
    {
        $user = $request->user()->load('ciudad');

        return response()->json([
            'success' => true,
            'data'    => [
                'id'                => $user->id,
                'name'              => $user->name,
                'email'             => $user->email,
                'numero_documento'  => $user->numero_documento,
                'telefono'          => $user->telefonos,
                'ciudad'            => $user->ciudad?->nombre,
                'ciudad_id'         => $user->ciudad_id,
                'wa_group_id'       => $user->wa_group_id,
                'profile_photo_url' => $user->profile_photo_url,
                'roles'             => $user->getRoleNames(),
                'permisos'          => $user->getAllPermissions()->pluck('name'),
            ],
        ]);
    }
}
