<?php

namespace App\Livewire\Admin\Ajustes\Sectores;

use App\Models\Sector;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public string $search = '';

    protected $listeners = ['render', 'update-table' => 'render'];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $sectores = Sector::withoutGlobalScopes()
            ->where('empresa_id', session('empresa'))
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('orden')
            ->orderBy('nombre')
            ->paginate(10);

        return view('livewire.admin.ajustes.sectores.show', compact('sectores'));
    }

    public function openModalSave(): void
    {
        $this->dispatch('openModalSaveSector');
    }

    public function openModalEdit(Sector $sector): void
    {
        $this->dispatch('openModalEditSector', sector: $sector);
    }

    public function openModalDelete(Sector $sector): void
    {
        $this->dispatch('openModalDeleteSector', sector: $sector);
    }
}
