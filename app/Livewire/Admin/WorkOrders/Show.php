<?php

namespace App\Livewire\Admin\WorkOrders;

use App\Models\WorkOrder;
use Livewire\Component;

class Show extends Component
{
    public WorkOrder $workOrder;

    protected $listeners = [
        'work-order-updated' => 'refreshWorkOrder',
    ];

    public function mount(WorkOrder $workOrder)
    {
        $this->workOrder = $workOrder->load([
            'tipo',
            'vehiculo.cliente',
            'cliente',
            'tecnico',
            'creador',
            'deviceHistory.dispositivo',
            'deviceHistory.simCard',
            'checklists.template',
            'checklists.photos',
            'photos',
            'signatures',
            'accessories.producto'
        ]);
    }

    public function refreshWorkOrder()
    {
        $this->workOrder->refresh();
        $this->workOrder->load([
            'tipo',
            'vehiculo.cliente',
            'cliente',
            'tecnico',
            'creador',
            'deviceHistory.dispositivo',
            'deviceHistory.simCard',
            'checklists.template',
            'checklists.photos',
            'photos',
            'signatures',
            'accessories.producto'
        ]);
    }

    public function iniciar()
    {
        try {
            $this->workOrder->iniciar();
            $this->refreshWorkOrder();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'ORDEN INICIADA',
                mensaje: "Orden {$this->workOrder->codigo} iniciada correctamente"
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: $e->getMessage()
            );
        }
    }

    public function finalizar($observaciones = null)
    {
        try {
            if ($observaciones) {
                $this->workOrder->observaciones_final = $observaciones;
                $this->workOrder->save();
            }

            $this->workOrder->finalizar();
            $this->refreshWorkOrder();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'ORDEN FINALIZADA',
                mensaje: "Orden {$this->workOrder->codigo} finalizada correctamente"
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: $e->getMessage()
            );
        }
    }

    public function cerrar()
    {
        try {
            $this->workOrder->cerrar();
            $this->refreshWorkOrder();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'ORDEN CERRADA',
                mensaje: "Orden {$this->workOrder->codigo} cerrada y bloqueada"
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: $e->getMessage()
            );
        }
    }

    public function cancelar($motivo)
    {
        try {
            $this->workOrder->cancelar($motivo);
            $this->refreshWorkOrder();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'ORDEN CANCELADA',
                mensaje: "Orden {$this->workOrder->codigo} cancelada correctamente"
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: $e->getMessage()
            );
        }
    }

    public function verChecklist(string $fase)
    {
        $this->redirect(route('admin.work-orders.checklist', [
            'workOrder' => $this->workOrder,
            'fase' => $fase
        ]));
    }

    public function descargarPDF()
    {
        // TODO: Implementar generación de PDF
        $this->dispatch(
            'notify-toast',
            icon: 'info',
            title: 'GENERANDO PDF',
            mensaje: 'El PDF está siendo generado...'
        );
    }

    public function render()
    {
        // Construir timeline
        $timeline = collect();

        // Creación
        $timeline->push([
            'tipo' => 'creacion',
            'titulo' => 'Orden Creada',
            'descripcion' => 'Por ' . ($this->workOrder->creador->name ?? 'Sistema'),
            'fecha' => $this->workOrder->created_at,
            'icono' => 'plus-circle',
            'color' => 'blue',
        ]);

        // Inicio
        if ($this->workOrder->fecha_inicio) {
            $timeline->push([
                'tipo' => 'inicio',
                'titulo' => 'Trabajo Iniciado',
                'descripcion' => 'Técnico comenzó el trabajo',
                'fecha' => $this->workOrder->fecha_inicio,
                'icono' => 'play',
                'color' => 'green',
            ]);
        }

        // Checklist BEFORE
        $checklistBefore = $this->workOrder->checklists->where('fase', 'before');
        if ($checklistBefore->isNotEmpty()) {
            $timeline->push([
                'tipo' => 'checklist_before',
                'titulo' => 'Checklist Inicial Completado',
                'descripcion' => $checklistBefore->count() . ' ítems verificados',
                'fecha' => $checklistBefore->max('created_at'),
                'icono' => 'clipboard-document-check',
                'color' => 'purple',
            ]);
        }

        // Fotos subidas
        foreach ($this->workOrder->photos as $photo) {
            $timeline->push([
                'tipo' => 'foto',
                'titulo' => 'Evidencia Fotográfica',
                'descripcion' => $photo->descripcion ?? 'Foto subida',
                'fecha' => $photo->created_at,
                'icono' => 'camera',
                'color' => 'yellow',
                'data' => $photo,
            ]);
        }

        // Checklist AFTER
        $checklistAfter = $this->workOrder->checklists->where('fase', 'after');
        if ($checklistAfter->isNotEmpty()) {
            $timeline->push([
                'tipo' => 'checklist_after',
                'titulo' => 'Checklist Final Completado',
                'descripcion' => $checklistAfter->count() . ' ítems verificados',
                'fecha' => $checklistAfter->max('created_at'),
                'icono' => 'clipboard-document-check',
                'color' => 'purple',
            ]);
        }

        // Firmas
        foreach ($this->workOrder->signatures as $signature) {
            $timeline->push([
                'tipo' => 'firma',
                'titulo' => 'Firma ' . ucfirst($signature->tipo),
                'descripcion' => 'Por ' . $signature->nombre_firmante,
                'fecha' => $signature->created_at,
                'icono' => 'pencil-square',
                'color' => 'indigo',
                'data' => $signature,
            ]);
        }

        // Finalización
        if ($this->workOrder->fecha_finalizado) {
            $timeline->push([
                'tipo' => 'finalizacion',
                'titulo' => 'Trabajo Finalizado',
                'descripcion' => 'Trabajo completado exitosamente',
                'fecha' => $this->workOrder->fecha_finalizado,
                'icono' => 'check-circle',
                'color' => 'green',
            ]);
        }

        // Cierre
        if ($this->workOrder->bloqueado) {
            $timeline->push([
                'tipo' => 'cierre',
                'titulo' => 'Orden Cerrada',
                'descripcion' => 'Orden bloqueada para edición',
                'fecha' => $this->workOrder->updated_at,
                'icono' => 'lock-closed',
                'color' => 'gray',
            ]);
        }

        // Ordenar por fecha
        $timeline = $timeline->sortBy('fecha');

        return view('livewire.admin.work-orders.show', [
            'timeline' => $timeline,
        ]);
    }
}
