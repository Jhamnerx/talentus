<?php

namespace App\Jobs;

use App\Models\PostventaPlantilla;
use App\Models\Sector;
use App\Models\WorkOrder;
use App\Models\WhatsFleep\Device;
use App\Services\WhatsFleep\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EnviarMensajeClienteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [30, 60, 120];

    public function __construct(
        public int $workOrderId,
        public int $deviceId
    ) {}

    public function handle(WhatsappService $whatsapp): void
    {
        $workOrder = WorkOrder::withoutGlobalScopes()
            ->with(['cliente.contactos', 'vehiculo'])
            ->find($this->workOrderId);

        if (!$workOrder) {
            Log::warning('EnviarMensajeClienteJob: work order no encontrada', [
                'work_order_id' => $this->workOrderId,
            ]);
            return;
        }

        $device = Device::find($this->deviceId);

        if (!$device) {
            Log::warning('EnviarMensajeClienteJob: device no encontrado', [
                'device_id' => $this->deviceId,
            ]);
            return;
        }

        // 1. Resolve recipient numbers
        $numeros = $workOrder->cliente?->contactos()
            ->where('is_gerente', true)
            ->pluck('telefono')
            ->filter()
            ->values()
            ->toArray();

        if (empty($numeros)) {
            $fallback = $workOrder->cliente?->telefono;
            if (!$fallback) {
                Log::warning('EnviarMensajeClienteJob: cliente sin contacto gerente ni teléfono', [
                    'work_order_id' => $workOrder->id,
                ]);
                return;
            }
            $numeros = [$fallback];
        }

        // 2. Resolve template — match by sector name, fallback to default (sector_id = null)
        $plantilla = $this->resolverPlantilla($workOrder);

        if (!$plantilla) {
            Log::warning('EnviarMensajeClienteJob: no hay plantilla para la OT', [
                'work_order_id' => $workOrder->id,
                'sector'        => $workOrder->sector,
            ]);
            return;
        }

        // 3. Replace variables
        $cuerpo = $this->reemplazarVariables($plantilla->cuerpo, $workOrder);

        // 4. Send to each recipient
        foreach ($numeros as $numero) {
            if ($plantilla->archivo_url) {
                $whatsapp->sendMedia(
                    $device->body,
                    $numero,
                    $plantilla->archivo_tipo,
                    url($plantilla->archivo_url),
                    $cuerpo
                );
            } else {
                $whatsapp->sendText($device->body, $numero, $cuerpo);
            }
        }
    }

    private function resolverPlantilla(WorkOrder $workOrder): ?PostventaPlantilla
    {
        $empresaId = $workOrder->empresa_id;
        $sectorId  = null;

        if ($workOrder->sector) {
            $nombre   = trim(explode(',', $workOrder->sector)[0]);
            $sectorId = Sector::withoutGlobalScopes()
                ->where('empresa_id', $empresaId)
                ->where('nombre', $nombre)
                ->value('id');
        }

        if ($sectorId) {
            $plantilla = PostventaPlantilla::withoutGlobalScopes()
                ->where('empresa_id', $empresaId)
                ->where('sector_id', $sectorId)
                ->where('activo', true)
                ->first();

            if ($plantilla) {
                return $plantilla;
            }
        }

        return PostventaPlantilla::withoutGlobalScopes()
            ->where('empresa_id', $empresaId)
            ->whereNull('sector_id')
            ->where('activo', true)
            ->first();
    }

    private function reemplazarVariables(string $cuerpo, WorkOrder $workOrder): string
    {
        return str_replace(
            ['{placa}', '{cliente}', '{fecha_instalacion}', '{fecha_cierre}'],
            [
                $workOrder->vehiculo?->placa ?? '',
                $workOrder->cliente?->razon_social ?? '',
                $workOrder->fecha_inicio?->format('d/m/Y') ?? '',
                $workOrder->fecha_cerrado?->format('d/m/Y') ?? '',
            ],
            $cuerpo
        );
    }
}
