<?php

namespace App\Listeners;

use App\Events\WorkOrderCerrada;
use App\Jobs\EnviarMensajeClienteJob;
use App\Models\WhatsFleep\Device;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class EnviarMensajePostventaListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(WorkOrderCerrada $event): void
    {
        $workOrder = $event->workOrder;

        $device = Device::whereHas('user', function ($query) use ($workOrder) {
            $query->where('empresa_id', $workOrder->empresa_id);
        })->where('es_postventa', true)->first();

        if (!$device) {
            Log::warning('EnviarMensajePostventaListener: no hay device es_postventa activo', [
                'work_order_id' => $workOrder->id,
                'empresa_id'    => $workOrder->empresa_id,
            ]);
            return;
        }

        EnviarMensajeClienteJob::dispatch($workOrder, $device);
    }
}
