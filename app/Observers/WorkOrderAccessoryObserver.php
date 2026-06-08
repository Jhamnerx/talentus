<?php

namespace App\Observers;

use App\Models\Productos;
use App\Models\WorkOrderAccessory;
use App\Scopes\EmpresaScope;
use Illuminate\Support\Facades\Log;

class WorkOrderAccessoryObserver
{
    public function created(WorkOrderAccessory $accessory): void
    {
        if (!$accessory->producto_id) {
            return;
        }

        $empresaId = $accessory->workOrder->empresa_id;

        if (in_array($accessory->accion, ['instalado', 'reemplazado'])) {
            Productos::withoutGlobalScope(EmpresaScope::class)
                ->where('id', $accessory->producto_id)
                ->where('empresa_id', $empresaId)
                ->where('tipo', 'producto')
                ->decrement('stock', $accessory->cantidad);

            Log::info("[Stock] WO #{$accessory->work_order_id} | Técnico #{$accessory->workOrder->tecnico_id} | Salida: -{$accessory->cantidad} de producto #{$accessory->producto_id} ({$accessory->accion})");
        } elseif ($accessory->accion === 'retirado') {
            Productos::withoutGlobalScope(EmpresaScope::class)
                ->where('id', $accessory->producto_id)
                ->where('empresa_id', $empresaId)
                ->where('tipo', 'producto')
                ->increment('stock', $accessory->cantidad);

            Log::info("[Stock] WO #{$accessory->work_order_id} | Técnico #{$accessory->workOrder->tecnico_id} | Entrada: +{$accessory->cantidad} de producto #{$accessory->producto_id} (retirado)");
        }
    }

    public function deleted(WorkOrderAccessory $accessory): void
    {
        if (!$accessory->producto_id) {
            return;
        }

        $empresaId = $accessory->workOrder->empresa_id;

        if (in_array($accessory->accion, ['instalado', 'reemplazado'])) {
            Productos::withoutGlobalScope(EmpresaScope::class)
                ->where('id', $accessory->producto_id)
                ->where('empresa_id', $empresaId)
                ->where('tipo', 'producto')
                ->increment('stock', $accessory->cantidad);

            Log::info("[Stock] WO #{$accessory->work_order_id} | Revertido: +{$accessory->cantidad} de producto #{$accessory->producto_id} (accesorio eliminado)");
        } elseif ($accessory->accion === 'retirado') {
            Productos::withoutGlobalScope(EmpresaScope::class)
                ->where('id', $accessory->producto_id)
                ->where('empresa_id', $empresaId)
                ->where('tipo', 'producto')
                ->decrement('stock', $accessory->cantidad);
        }
    }
}
