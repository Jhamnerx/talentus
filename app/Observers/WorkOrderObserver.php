<?php

namespace App\Observers;

use App\Models\WorkOrder;
use Illuminate\Support\Str;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class WorkOrderObserver
{
    public function creating(WorkOrder $workOrder): void
    {

        // Generar UUID
        $workOrder->uuid = Str::uuid();

        // Asignar usuario creador si no está definido
        if (!$workOrder->created_by) {
            $workOrder->created_by = auth()->id();
        }

        // Asignar empresa si no está definida
        if (!$workOrder->empresa_id) {
            $workOrder->empresa_id = session('empresa');
        }
    }

    public function created(WorkOrder $workOrder): void
    {
        // Generar código basado en el ID: OT25-000001
        $codigo = 'OT' . date('y') . '-' . str_pad($workOrder->id, 6, '0', STR_PAD_LEFT);
        $workOrder->codigo = $codigo;

        // Guardar snapshot del tipo de orden (preservar costos y configuración)
        if ($workOrder->tipo && !$workOrder->tipo_data) {
            $workOrder->tipo_data = [
                'nombre' => $workOrder->tipo->nombre,
                'descripcion' => $workOrder->tipo->descripcion,
                'costo_base' => $workOrder->tipo->costo_base,
                'requiere_imei' => $workOrder->tipo->requiere_imei,
                'requiere_sim' => $workOrder->tipo->requiere_sim,
                'requiere_accesorios' => $workOrder->tipo->requiere_accesorios,
                'requiere_checklist' => $workOrder->tipo->requiere_checklist,
            ];
        }

        $workOrder->saveQuietly(); // Evita disparar eventos nuevamente

        // Aquí puedes enviar notificaciones al técnico
        // $workOrder->tecnico->notify(new NuevaOrdenTrabajo($workOrder));
    }

    public function updating(WorkOrder $workOrder): void
    {
        // No permitir edición si está bloqueado
        if ($workOrder->isDirty() && $workOrder->getOriginal('bloqueado')) {
            throw new \Exception('No se puede editar una orden de trabajo bloqueada');
        }
    }

    public function updated(WorkOrder $workOrder): void
    {
        // Registrar cambios importantes en activity log
    }

    public function deleted(WorkOrder $workOrder): void
    {
        // Eliminar archivos asociados si es necesario
    }
}
