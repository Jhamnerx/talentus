<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Vehiculos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeviceMaintenance;
use App\Models\Vehiculos;
use Livewire\Attributes\Url;

class HistorialMantenimientos extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $tipo = '';

    #[Url]
    public string $desde = '';

    #[Url]
    public string $hasta = '';

    public ?int $vehiculo_id = null;

    protected $listeners = [
        'update-historial' => '$refresh',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingTipo(): void
    {
        $this->resetPage();
    }

    public function updatingDesde(): void
    {
        $this->resetPage();
    }

    public function updatingHasta(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search    = '';
        $this->tipo      = '';
        $this->desde     = '';
        $this->hasta     = '';
        $this->vehiculo_id = null;
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        $record = DeviceMaintenance::findOrFail($id);
        $record->delete();
        $this->dispatch('notify', title: 'Eliminado', message: 'Registro eliminado correctamente.', icon: 'success');
    }

    public function render()
    {
        $registros = DeviceMaintenance::query()
            ->with(['vehiculo:id,placa,marca,modelo', 'user:id,name'])
            ->when($this->vehiculo_id, fn($q) => $q->where('vehiculo_id', $this->vehiculo_id))
            ->when($this->tipo, fn($q) => $q->where('tipo', $this->tipo))
            ->when($this->desde, fn($q) => $q->whereDate('fecha', '>=', $this->desde))
            ->when($this->hasta, fn($q) => $q->whereDate('fecha', '<=', $this->hasta))
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->where('motivo', 'like', "%{$this->search}%")
                        ->orWhere('tracking_device_name', 'like', "%{$this->search}%")
                        ->orWhereHas('vehiculo', fn($v) => $v->where('placa', 'like', "%{$this->search}%"));
                });
            })
            ->orderByDesc('fecha')
            ->orderByDesc('created_at')
            ->paginate(25);

        $vehiculos = Vehiculos::orderBy('placa')->get(['id', 'placa', 'marca', 'modelo']);

        return view('livewire.admin.vehiculos.historial-mantenimientos', [
            'registros' => $registros,
            'vehiculos' => $vehiculos,
        ])->title('Historial de Mantenimientos');
    }
}
