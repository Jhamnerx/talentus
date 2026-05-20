<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WorkOrderTrackingController extends Controller
{
    /**
     * POST /api/work-orders/{workOrder}/tracking
     * El técnico envía su posición GPS cada ~1 min.
     */
    public function update(Request $request, WorkOrder $workOrder): JsonResponse
    {
        // Solo el técnico asignado puede actualizar su posición
        abort_if(
            $request->user()->id !== $workOrder->user_id,
            403,
            'No tienes permiso para actualizar esta orden.'
        );

        $data = $request->validate([
            'lat'      => ['required', 'numeric', 'between:-90,90'],
            'lng'      => ['required', 'numeric', 'between:-180,180'],
            'accuracy' => ['nullable', 'numeric'],
            'speed'    => ['nullable', 'numeric'],
        ]);

        $workOrder->updateQuietly([
            'tecnico_lat'       => $data['lat'],
            'tecnico_lng'       => $data['lng'],
            'tecnico_last_seen' => now(),
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * PATCH /api/work-orders/{workOrder}/ubicacion
     * El administrador establece la ubicación del servicio.
     */
    public function setUbicacion(Request $request, WorkOrder $workOrder): JsonResponse
    {
        Gate::authorize('update', $workOrder);

        $data = $request->validate([
            'lat'       => ['required', 'numeric', 'between:-90,90'],
            'lng'       => ['required', 'numeric', 'between:-180,180'],
            'direccion' => ['nullable', 'string', 'max:500'],
        ]);

        $workOrder->update([
            'ubicacion_lat'       => $data['lat'],
            'ubicacion_lng'       => $data['lng'],
            'ubicacion_direccion' => $data['direccion'] ?? null,
        ]);

        return response()->json(['success' => true, 'data' => $workOrder->only([
            'id',
            'ubicacion_lat',
            'ubicacion_lng',
            'ubicacion_direccion',
        ])]);
    }
}
