<?php

namespace App\Observers;

use App\Models\WorkOrder;
use Illuminate\Support\Str;
use App\Events\WorkOrderCreated;
use App\Events\WorkOrderUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NuevaOrdenAsignada;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class WorkOrderObserver
{
    public function creating(WorkOrder $workOrder): void
    {

        // Generar UUID
        $workOrder->uuid = Str::uuid();

        // Asignar usuario creador si no está definido
        if (!$workOrder->created_by) {
            $workOrder->created_by = Auth::user()->id;
        }

        // Asignar empresa si no está definida
        if (!$workOrder->empresa_id) {
            $workOrder->empresa_id = session('empresa');
        }
    }

    public function created(WorkOrder $workOrder): void
    {


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

        // Enviar notificación al técnico asignado
        if ($workOrder->tecnico) {
            try {
                $workOrder->tecnico->notify(new NuevaOrdenAsignada($workOrder));
            } catch (\Exception $e) {
                Log::error('Error enviando notificación FCM de nueva orden', [
                    'work_order_id' => $workOrder->id,
                    'tecnico_id' => $workOrder->tecnico_id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Disparar evento de broadcasting
        broadcast(new WorkOrderCreated($workOrder))->toOthers();
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
        // Detectar cambios importantes
        $changes = [];

        if ($workOrder->wasChanged('estado')) {
            $changes['estado'] = [
                'anterior' => $workOrder->getOriginal('estado'),
                'nuevo' => $workOrder->estado,
            ];
        }

        if ($workOrder->wasChanged('tecnico_id')) {
            $changes['tecnico'] = [
                'anterior' => $workOrder->getOriginal('tecnico_id'),
                'nuevo' => $workOrder->tecnico_id,
            ];
        }

        // Disparar evento de actualización si hubo cambios relevantes
        if (!empty($changes)) {
            broadcast(new WorkOrderUpdated($workOrder, $changes))->toOthers();
        }
    }

    public function deleted(WorkOrder $workOrder): void
    {
        // Eliminar archivos asociados si es necesario
    }
}
