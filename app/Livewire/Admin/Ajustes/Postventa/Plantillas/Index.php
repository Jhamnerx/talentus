<?php

namespace App\Livewire\Admin\Ajustes\Postventa\Plantillas;

use App\Models\PostventaPlantilla;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    protected $listeners = ['render', 'update-table' => 'render'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function toggleActivo(int $id): void
    {
        $plantilla = PostventaPlantilla::findOrFail($id);
        $plantilla->update(['activo' => !$plantilla->activo]);

        $this->dispatch('notify-toast',
            icon: 'success',
            title: 'PLANTILLA ' . ($plantilla->activo ? 'ACTIVADA' : 'DESACTIVADA'),
            mensaje: 'El estado de la plantilla fue actualizado.'
        );
    }

    public function openModalSave(): void
    {
        $this->dispatch('openModalSavePlantilla');
    }

    public function openModalEdit(int $id): void
    {
        $this->dispatch('openModalEditPlantilla', id: $id);
    }

    public function openModalDelete(int $id): void
    {
        $this->dispatch('openModalDeletePlantilla', id: $id);
    }

    public function render()
    {
        $plantillas = PostventaPlantilla::with('sector')
            ->when($this->search, function ($q) {
                $q->where('cuerpo', 'like', '%' . $this->search . '%')
                  ->orWhereHas('sector', fn ($sq) => $sq->where('nombre', 'like', '%' . $this->search . '%'));
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.ajustes.postventa.plantillas.index', compact('plantillas'));
    }
}
