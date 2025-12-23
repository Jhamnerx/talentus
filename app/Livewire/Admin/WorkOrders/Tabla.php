<?php

namespace App\Livewire\Admin\WorkOrders;

use App\Models\WorkOrder;
use App\Enums\WorkOrderStatus;
use Livewire\Component;
use Livewire\WithPagination;

class Tabla extends Component
{
    use WithPagination;

    public $search = '';
    public $estado_filter = '';
    public $tecnico_filter = '';
    public $fecha_desde = '';
    public $fecha_hasta = '';
    public $perPage = 10;

    protected $listeners = [
        'work-order-created' => '$refresh',
        'work-order-updated' => '$refresh',
    ];

    public function render()
    {
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

        return view('livewire.admin.work-orders.tabla', compact('ordenes'));
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function limpiarFiltros()
    {
        $this->reset(['search', 'estado_filter', 'tecnico_filter', 'fecha_desde', 'fecha_hasta']);
    }
}
