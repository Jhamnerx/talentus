<?php

namespace App\Livewire\Admin\Vehiculos\Mantenimiento;

use DateTime;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Mantenimiento;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    public function render(): \Illuminate\View\View
    {
        $query = Mantenimiento::with(['vehiculo.cliente', 'user', 'workOrderActivo'])
            ->where(function ($q) {
                $q->whereHas('vehiculo', function ($vehiculo) {
                    $vehiculo->where('placa', 'LIKE', '%' . $this->search . '%')
                        ->orWhereHas('cliente', function ($query) {
                            $query->where('razon_social', 'LIKE', '%' . $this->search . '%');
                        });
                })
                ->orWhere('numero', 'LIKE', '%' . $this->search . '%')
                ->orWhere('detalle_trabajo', 'LIKE', '%' . $this->search . '%')
                ->orWhereDate('fecha_hora_mantenimiento', $this->validateDate($this->search) ? Carbon::createFromFormat('d-m-Y', $this->search)->format('Y-m-d') : '');
            })
            ->when($this->statusFilter, fn($q) => $q->where('estado', $this->statusFilter))
            ->orderBy('id', 'desc');

        $mantenimientos = $query->paginate(12);

        $counts = [
            'todos'      => Mantenimiento::count(),
            'PENDIENTE'  => Mantenimiento::where('estado', 'PENDIENTE')->count(),
            'COMPLETADA' => Mantenimiento::where('estado', 'COMPLETADA')->count(),
            'CANCELADO'  => Mantenimiento::where('estado', 'CANCELADO')->count(),
        ];

        return view('livewire.admin.vehiculos.mantenimiento.index', compact('mantenimientos', 'counts'));
    }

    #[On('update-table')]
    public function updateTable(): void
    {
        // triggers re-render
    }

    public function setStatusFilter(string $value): void
    {
        $this->statusFilter = $value;
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    private function validateDate(string $date, string $format = 'd-m-Y'): bool
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    public function openModalSave(): void
    {
        $this->dispatch('open-modal-save-mantenimiento', 'index');
    }

    public function createTask(Mantenimiento $mantenimiento): void
    {
        $this->dispatch('openModalCreateTask', mantenimiento: $mantenimiento);
    }

    public function openModalEdit(Mantenimiento $mantenimiento): void
    {
        $this->dispatch('open-modal-edit-mantenimiento', mantenimiento: $mantenimiento);
    }

    public function createWorkOrder(Mantenimiento $mantenimiento): void
    {
        $this->dispatch('open-create-modal-from-mantenimiento', mantenimientoId: $mantenimiento->id);
    }

    public function markAs(Mantenimiento $mantenimiento, string $value): void
    {
        if ($mantenimiento->estado->name === $value) {
            return;
        }

        $mantenimiento->estado = $value;
        $mantenimiento->save();

        if ($value === 'COMPLETADA') {
            if ($mantenimiento->tarea) {
                $mantenimiento->tarea->estado = 'COMPLETE';
                $mantenimiento->tarea->fecha_termino = Carbon::now();
                $mantenimiento->tarea->save();
            }

            $this->dispatch('open-siguiente-mantenimiento', mantenimientoId: $mantenimiento->id);
        }
    }

    public function openModalDelete(Mantenimiento $mantenimiento): void
    {
        $this->dispatch('EliminarMantenimiento', $mantenimiento);
    }

    public function openModalExport(): void
    {
        $this->dispatch('openModalExport');
    }
}
