<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceMaintenance;
use App\Models\Vehiculos;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeviceMaintenanceController extends Controller
{
    /**
     * Recibe un registro de mantenimiento/suspensiÃ³n/reactivaciÃ³n enviado
     * en tiempo real por talentus-pro-tracking (push).
     *
     * POST /api/tracking/device-maintenances/sync
     * Solo acepta peticiones desde la IP configurada en TRACKING_ALLOWED_IP.
     *
     * Body (JSON):
     * {
     *   "action": "upsert" | "delete",
     *   "empresa_id": 1,
     *   "item": {
     *     "id": 42,
     *     "device_imei": "...",
     *     "device_name": "...",
     *     "tipo": "mantenimiento|suspension|reactivacion",
     *     "fecha": "2025-01-15",
     *     "motivo": "...",
     *     "notas": "...",
     *     "created_at": "2025-01-15T10:00:00Z"
     *   }
     * }
     */
    public function sync(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'action'               => 'required|in:upsert,delete',
            'empresa_id'           => 'required|integer|exists:empresas,id',
            'item'                 => 'required|array',
            'item.id'              => 'required|integer',
            'item.device_id'       => 'nullable|integer',
            'item.device_imei'     => 'nullable|string|max:50',
            'item.device_name'     => 'nullable|string|max:255',
            'item.tipo'            => 'required|in:mantenimiento,suspension,reactivacion',
            'item.fecha'           => 'required|date',
            'item.motivo'          => 'nullable|string|max:500',
            'item.notas'           => 'nullable|string|max:2000',
        ]);

        $empresaId = $validated['empresa_id'];
        $item      = $validated['item'];
        $action    = $validated['action'];

        if ($action === 'delete') {
            DeviceMaintenance::withoutGlobalScopes()
                ->where('empresa_id', $empresaId)
                ->where('tracking_device_id', $item['device_imei'] ?? null)
                ->where('fecha', $item['fecha'])
                ->where('tipo', $item['tipo'])
                ->where('source', DeviceMaintenance::SOURCE_TRACKING)
                ->delete();

            return response()->json(['status' => 1, 'action' => 'deleted']);
        }

        // upsert â€” busca por IMEI + fecha + tipo para no duplicar
        $vehiculoId = null;
        if (! empty($item['device_imei'])) {
            $vehiculoId = Vehiculos::withoutGlobalScopes()
                ->where('empresa_id', $empresaId)
                ->whereHas('dispositivosAsignados', fn($q) => $q->where('dispositivos.imei', $item['device_imei']))
                ->value('id');
        }

        DeviceMaintenance::withoutGlobalScopes()->updateOrCreate(
            [
                'empresa_id'         => $empresaId,
                'tracking_device_id' => $item['device_imei'] ?? null,
                'fecha'              => $item['fecha'],
                'tipo'               => $item['tipo'],
                'source'             => DeviceMaintenance::SOURCE_TRACKING,
            ],
            [
                'vehiculo_id'          => $vehiculoId,
                'device_id_plattform'  => $item['device_id'] ?? null,
                'tracking_device_name' => $item['device_name'] ?? null,
                'motivo'               => $item['motivo'] ?? null,
                'notas'                => $item['notas'] ?? null,
            ]
        );

        return response()->json(['status' => 1, 'action' => 'upserted']);
    }

    /**
     * Lista paginada de mantenimientos (uso interno protegido por Sanctum).
     *
     * GET /api/tracking/device-maintenances
     */
    public function index(Request $request): JsonResponse
    {
        $query = DeviceMaintenance::with('vehiculo:id,placa')
            ->when($request->filled('vehiculo_id'), fn($q) => $q->where('vehiculo_id', $request->vehiculo_id))
            ->when($request->filled('tipo'), fn($q) => $q->where('tipo', $request->tipo))
            ->orderByDesc('fecha');

        return response()->json($query->paginate(50));
    }
}
