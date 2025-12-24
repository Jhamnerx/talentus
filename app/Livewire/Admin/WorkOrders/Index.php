<?php

namespace App\Livewire\Admin\WorkOrders;

use App\Models\WorkOrder;
use App\Models\WorkOrderType;
use App\Enums\WorkOrderStatus;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $estado_filter = '';
    public $tecnico_filter = '';
    public $fecha_desde = '';
    public $fecha_hasta = '';
    public $perPage = 10;

    // Propiedades para Tipos de Órdenes
    public $showTipoModal = false;
    public $editingTipoId = null;
    public $tipoNombre = '';
    public $tipoDescripcion = '';
    public $tipoCostoBase = 0;
    public $tipoRequiereImei = false;
    public $tipoRequiereSim = false;
    public $tipoRequiereAccesorios = false;
    public $tipoRequiereChecklist = true;
    public $tipoIsActive = true;

    #[On('work-order-created')]
    public function refresh()
    {
        // Refresh automático después de crear
    }

    #[On('work-order-updated')]
    public function refreshUpdated()
    {
        // Refresh automático después de actualizar
    }

    public function render()
    {
        $stats = [
            'pendientes' => WorkOrder::estado(WorkOrderStatus::PENDIENTE)->count(),
            'en_proceso' => WorkOrder::estado(WorkOrderStatus::EN_PROCESO)->count(),
            'finalizadas' => WorkOrder::estado(WorkOrderStatus::FINALIZADO)->count(),
            'canceladas' => WorkOrder::estado(WorkOrderStatus::CANCELADO)->count(),
        ];

        $ordenes = WorkOrder::query()
            ->with(['tipo', 'vehiculo', 'cliente', 'tecnico'])
            ->when($this->search, function ($query) {
                $query->where('codigo', 'like', "%{$this->search}%")
                    ->orWhereHas('vehiculo', function ($q) {
                        $q->where('placa', 'like', "%{$this->search}%");
                    })
                    ->orWhereHas('cliente', function ($q) {
                        $q->where('razon_social', 'like', "%{$this->search}%");
                    });
            })
            ->when($this->estado_filter, fn($q) => $q->estado($this->estado_filter))
            ->when($this->tecnico_filter, fn($q) => $q->tecnico($this->tecnico_filter))
            ->when($this->fecha_desde, fn($q) => $q->whereDate('fecha_programada', '>=', $this->fecha_desde))
            ->when($this->fecha_hasta, fn($q) => $q->whereDate('fecha_programada', '<=', $this->fecha_hasta))
            ->latest('fecha_programada')
            ->paginate($this->perPage);

        // Cargar tipos de órdenes
        $tipos = WorkOrderType::withCount('workOrders')->orderBy('nombre')->get();

        return view('livewire.admin.work-orders.index', compact('stats', 'ordenes', 'tipos'));
    }

    public function openCreateModal()
    {
        $this->dispatch('open-create-modal');
    }

    public function verDetalle(WorkOrder $orden)
    {
        return redirect()->route('admin.work-orders.show', $orden);
    }

    public function editarOrden(WorkOrder $orden)
    {
        $this->dispatch('open-edit-modal', workOrderId: $orden->id);
    }

    public function iniciarOrden(WorkOrder $orden)
    {
        try {
            $orden->iniciar();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'ORDEN INICIADA',
                mensaje: "Orden {$orden->codigo} iniciada correctamente"
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

    public function finalizarOrden($ordenId, $observaciones = null)
    {
        try {
            $orden = WorkOrder::findOrFail($ordenId);

            if ($observaciones) {
                $orden->observaciones_final = $observaciones;
                $orden->save();
            }

            $orden->finalizar();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'ORDEN FINALIZADA',
                mensaje: "Orden {$orden->codigo} finalizada correctamente"
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

    public function cerrarOrden(WorkOrder $orden)
    {
        try {
            $orden->cerrar();

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'ORDEN CERRADA',
                mensaje: "Orden {$orden->codigo} cerrada y bloqueada"
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

    public function cancelarOrden($ordenId, $motivo)
    {
        try {
            $orden = WorkOrder::findOrFail($ordenId);
            $orden->cancelar($motivo);

            $this->dispatch(
                'notify-toast',
                icon: 'success',
                title: 'ORDEN CANCELADA',
                mensaje: "Orden {$orden->codigo} cancelada correctamente"
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset(['search', 'estado_filter', 'tecnico_filter', 'fecha_desde', 'fecha_hasta']);
    }

    // ========== MÉTODOS PARA TIPOS DE ÓRDENES ==========

    public function crearTipo()
    {
        $this->reset([
            'editingTipoId',
            'tipoNombre',
            'tipoDescripcion',
            'tipoCostoBase',
            'tipoRequiereImei',
            'tipoRequiereSim',
            'tipoRequiereAccesorios',
            'tipoRequiereChecklist',
            'tipoIsActive'
        ]);
        $this->tipoRequiereChecklist = true;
        $this->tipoIsActive = true;
        $this->showTipoModal = true;
    }

    public function editarTipo(WorkOrderType $tipo)
    {
        $this->editingTipoId = $tipo->id;
        $this->tipoNombre = $tipo->nombre;
        $this->tipoDescripcion = $tipo->descripcion;
        $this->tipoCostoBase = $tipo->costo_base;
        $this->tipoRequiereImei = $tipo->requiere_imei;
        $this->tipoRequiereSim = $tipo->requiere_sim;
        $this->tipoRequiereAccesorios = $tipo->requiere_accesorios;
        $this->tipoRequiereChecklist = $tipo->requiere_checklist;
        $this->tipoIsActive = $tipo->is_active;
        $this->showTipoModal = true;
    }

    public function guardarTipo()
    {
        $validated = $this->validate([
            'tipoNombre' => 'required|string|max:100',
            'tipoDescripcion' => 'nullable|string|max:500',
            'tipoCostoBase' => 'nullable|numeric|min:0',
            'tipoRequiereImei' => 'boolean',
            'tipoRequiereSim' => 'boolean',
            'tipoRequiereAccesorios' => 'boolean',
            'tipoRequiereChecklist' => 'boolean',
            'tipoIsActive' => 'boolean',
        ]);

        $data = [
            'nombre' => $this->tipoNombre,
            'descripcion' => $this->tipoDescripcion,
            'costo_base' => $this->tipoCostoBase ?? 0,
            'requiere_imei' => $this->tipoRequiereImei,
            'requiere_sim' => $this->tipoRequiereSim,
            'requiere_accesorios' => $this->tipoRequiereAccesorios,
            'requiere_checklist' => $this->tipoRequiereChecklist,
            'is_active' => $this->tipoIsActive,
            'empresa_id' => session('empresa'),
        ];

        if ($this->editingTipoId) {
            $tipo = WorkOrderType::findOrFail($this->editingTipoId);
            $tipo->update($data);
            $mensaje = 'Tipo de orden actualizado correctamente';
        } else {
            WorkOrderType::create($data);
            $mensaje = 'Tipo de orden creado correctamente';
        }

        $this->showTipoModal = false;
        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'ÉXITO',
            mensaje: $mensaje
        );
    }

    public function toggleActivoTipo(WorkOrderType $tipo)
    {
        $tipo->update(['is_active' => !$tipo->is_active]);

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'ACTUALIZADO',
            mensaje: "Tipo '{$tipo->nombre}' " . ($tipo->is_active ? 'activado' : 'desactivado')
        );
    }

    public function eliminarTipo(WorkOrderType $tipo)
    {
        if ($tipo->workOrders()->exists()) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'No se puede eliminar un tipo con órdenes asociadas'
            );
            return;
        }

        $tipo->delete();

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'ELIMINADO',
            mensaje: "Tipo '{$tipo->nombre}' eliminado correctamente"
        );
    }
}
