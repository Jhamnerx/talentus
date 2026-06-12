<?php

namespace App\Observers;

use App\Models\User;
use App\Models\WorkOrder;
use App\Enums\WorkOrderStatus;
use Illuminate\Support\Str;
use App\Events\WorkOrderCreated;
use App\Events\WorkOrderUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NuevaOrdenAsignada;
use App\Notifications\OrdenCambioEstado;
use App\Notifications\OrdenEventoTecnico;
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
            $tipo = $workOrder->tipo;
            $costoResuelto = $tipo->costoResuelto($workOrder->tecnico_id);

            $workOrder->tipo_data = [
                'id'                          => $tipo->id,
                'nombre'                      => $tipo->nombre,
                'descripcion'                 => $tipo->descripcion,
                'costo'                       => $costoResuelto,
                'costo_base'                  => (float) $tipo->costo_base,
                'costo_personalizado'         => $tipo->costoParaTecnico($workOrder->tecnico_id) !== null,
                'requiere_imei'               => $tipo->requiere_imei,
                'requiere_sim'                => $tipo->requiere_sim,
                'requiere_accesorios'         => $tipo->requiere_accesorios,
                'requiere_checklist'          => $tipo->requiere_checklist,
                'muestra_sector'              => $tipo->muestra_sector,
                'muestra_plan'                => $tipo->muestra_plan,
                'muestra_accesorios_instalar' => $tipo->muestra_accesorios_instalar,
                'es_mantenimiento_programado' => $tipo->es_mantenimiento_programado,
                'snapshot_at'                 => now()->toDateTimeString(),
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

        if ($workOrder->wasChanged('fecha_programada')) {
            $changes['fecha_programada'] = [
                'anterior' => $workOrder->getOriginal('fecha_programada'),
                'nuevo'    => $workOrder->fecha_programada,
            ];
        }

        // Disparar evento de actualización (broadcasting web) si hubo cambios relevantes
        if (!empty($changes)) {
            broadcast(new WorkOrderUpdated($workOrder, $changes))->toOthers();
        }

        // Notificaciones push (FCM) al app del técnico / creador
        $this->notificarCambios($workOrder);
    }

    public function deleted(WorkOrder $workOrder): void
    {
        // Avisar al técnico asignado que la orden fue eliminada
        if ($workOrder->tecnico_id) {
            $tecnico = User::find($workOrder->tecnico_id);
            $this->notificarSeguro(
                $tecnico,
                new OrdenEventoTecnico(OrdenEventoTecnico::ELIMINADA, $this->ordenSnapshot($workOrder))
            );
        }
    }

    /**
     * Despacha las notificaciones FCM según el tipo de cambio detectado.
     */
    protected function notificarCambios(WorkOrder $workOrder): void
    {
        $tecnicoCambio = $workOrder->wasChanged('tecnico_id');
        $estadoCambio  = $workOrder->wasChanged('estado');
        $fechaCambio   = $workOrder->wasChanged('fecha_programada');

        // ── Reasignación: avisar al nuevo y al técnico anterior ──────────────
        if ($tecnicoCambio) {
            if ($workOrder->tecnico) {
                $this->notificarSeguro($workOrder->tecnico, new NuevaOrdenAsignada($workOrder));
            }

            $anteriorId = $workOrder->getOriginal('tecnico_id');
            if ($anteriorId && $anteriorId !== $workOrder->tecnico_id) {
                $anterior = User::find($anteriorId);
                $this->notificarSeguro(
                    $anterior,
                    new OrdenEventoTecnico(OrdenEventoTecnico::RETIRADA, $this->ordenSnapshot($workOrder))
                );
            }
        }

        // ── Cambio de estado: cancelada → técnico; iniciada/finalizada → creador ──
        if ($estadoCambio) {
            $anterior = $this->estadoAnterior($workOrder);

            switch ($workOrder->estado) {
                case WorkOrderStatus::CANCELADO:
                    $this->notificarSeguro($workOrder->tecnico, new OrdenCambioEstado($workOrder, $anterior));
                    break;

                case WorkOrderStatus::FINALIZADO:
                case WorkOrderStatus::EN_PROCESO:
                    $this->notificarSeguro($workOrder->creador, new OrdenCambioEstado($workOrder, $anterior));
                    break;
            }
        }

        // ── Reprogramación: avisar al técnico (solo si no cambió de técnico, para no duplicar) ──
        if ($fechaCambio && !$tecnicoCambio && !$estadoCambio) {
            $this->notificarSeguro(
                $workOrder->tecnico,
                new OrdenEventoTecnico(OrdenEventoTecnico::REPROGRAMADA, $this->ordenSnapshot($workOrder))
            );
        }
    }

    /**
     * Snapshot escalar de la orden (queue-safe, no depende de re-hidratar el modelo).
     *
     * @return array<string, mixed>
     */
    protected function ordenSnapshot(WorkOrder $workOrder): array
    {
        return [
            'id'      => $workOrder->id,
            'codigo'  => $workOrder->codigo,
            'tipo'    => $workOrder->tipo->nombre ?? null,
            'placa'   => $workOrder->vehiculo->placa ?? null,
            'cliente' => $workOrder->cliente->razon_social
                ?? $workOrder->vehiculo->cliente->razon_social
                ?? null,
            'fecha'   => $workOrder->fecha_programada?->format('Y-m-d H:i'),
            'motivo'  => $workOrder->motivo_cancelacion ?? null,
            'url'     => route('admin.work-orders.show', $workOrder),
        ];
    }

    protected function estadoAnterior(WorkOrder $workOrder): WorkOrderStatus
    {
        $raw = $workOrder->getOriginal('estado');

        return $raw instanceof WorkOrderStatus ? $raw : WorkOrderStatus::from($raw);
    }

    /**
     * Notifica capturando cualquier error para que un fallo de FCM no rompa la operación.
     */
    protected function notificarSeguro(?User $usuario, $notification): void
    {
        if (!$usuario) {
            return;
        }

        try {
            $usuario->notify($notification);
        } catch (\Throwable $e) {
            Log::error('Error enviando notificación de orden de trabajo', [
                'usuario_id'   => $usuario->id,
                'notification' => get_class($notification),
                'error'        => $e->getMessage(),
            ]);
        }
    }
}
