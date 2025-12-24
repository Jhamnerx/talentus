<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    /**
     * Guardar o actualizar el token FCM del usuario autenticado
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        auth()->user()->update([
            'fcm_token' => $request->token,
        ]);

        return response()->json([
            'message' => 'Token FCM guardado correctamente',
            'success' => true,
        ]);
    }

    /**
     * Eliminar el token FCM del usuario (al cerrar sesión)
     */
    public function destroy()
    {
        auth()->user()->update([
            'fcm_token' => null,
        ]);

        return response()->json([
            'message' => 'Token FCM eliminado correctamente',
            'success' => true,
        ]);
    }
}
