<?php

namespace App\Http\Controllers\Api;

use App\Models\WorkOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicWorkOrderController extends Controller
{
    /**
     * GET /api/public/work-orders/{hash}
     * Devuelve los datos públicos de la orden para que el cliente la pueda revisar.
     */
    public function show(string $hash): JsonResponse
    {
        $orden = WorkOrder::withoutGlobalScopes()
            ->where('verification_hash', $hash)
            ->with(['tipo:id,nombre', 'vehiculo:id,placa,marca,modelo', 'cliente:id,razon_social', 'tecnico:id,name'])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => [
                'id'                  => $orden->id,
                'hash'                => $orden->verification_hash,
                'tipo'                => $orden->tipo?->nombre,
                'vehiculo'            => $orden->vehiculo
                    ? "{$orden->vehiculo->placa} — {$orden->vehiculo->marca} {$orden->vehiculo->modelo}"
                    : null,
                'cliente'             => $orden->cliente?->razon_social,
                'tecnico'             => $orden->tecnico?->name,
                'fecha_programada'    => $orden->fecha_programada?->format('d/m/Y H:i'),
                'fecha_finalizacion'  => $orden->fecha_finalizacion?->format('d/m/Y H:i'),
                'estado'              => $orden->estado?->value,
                'observaciones_final' => $orden->observaciones_final,
                'imei'                => $orden->imei,
                'modelo_dispositivo'  => $orden->modelo_dispositivo,
                'verification_status' => $orden->verification_status,
                'verified_at'         => $orden->verified_at?->format('d/m/Y H:i'),
                'verification_notes'  => $orden->verification_notes,
            ],
        ]);
    }

    /**
     * POST /api/public/work-orders/{hash}/verify
     * El cliente confirma o rechaza la orden desde la web pública.
     * Body: { action: 'verified'|'rejected', notes?: string }
     */
    public function verify(Request $request, string $hash): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:verified,rejected',
            'notes'  => 'nullable|string|max:500',
        ]);

        $orden = WorkOrder::withoutGlobalScopes()
            ->where('verification_hash', $hash)
            ->firstOrFail();

        if ($orden->verification_status === 'verified') {
            return response()->json([
                'success' => false,
                'message' => 'Esta orden ya fue verificada anteriormente.',
            ], 409);
        }

        $orden->update([
            'verification_status' => $request->action,
            'verified_at'         => now(),
            'verification_notes'  => $request->notes,
        ]);

        $message = $request->action === 'verified'
            ? 'Orden verificada correctamente. Gracias por su confirmación.'
            : 'Orden marcada como rechazada. Nos pondremos en contacto con usted.';

        return response()->json(['success' => true, 'message' => $message]);
    }
}
