<?php

namespace App\Listeners;

use App\Events\WorkOrderCerrada;
use App\Jobs\EnviarMensajeClienteJob;
use App\Models\WhatsFleep\Device;
use App\Models\WorkOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class EnviarMensajePostventaListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(WorkOrderCerrada $event): void
    {
        $workOrder = WorkOrder::withoutGlobalScopes()->find($event->workOrderId);

        if (!$workOrder) {
            Log::warning('EnviarMensajePostventaListener: work order no encontrada', [
                'work_order_id' => $event->workOrderId,
            ]);
            return;
        }

        $device = Device::whereHas('user', function ($query) use ($event) {
            $query->where('empresa_id', $event->empresaId);
        })->where('es_postventa', true)->first();

        if (!$device) {
            Log::warning('EnviarMensajePostventaListener: no hay device es_postventa activo', [
                'work_order_id' => $event->workOrderId,
                'empresa_id'    => $event->empresaId,
            ]);
            return;
        }

        EnviarMensajeClienteJob::dispatch($workOrder->id, $device->id);
    }
}
