<?php

namespace App\Livewire\Admin\Ajustes\Rubros;

use App\Models\RubroCliente;
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
        $rubros = RubroCliente::withoutGlobalScopes()
            ->where('empresa_id', session('empresa'))
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('nombre')
            ->paginate(10);

        return view('livewire.admin.ajustes.rubros.show', compact('rubros'));
    }

    public function openModalSave(): void
    {
        $this->dispatch('openModalSaveRubro');
    }

    public function openModalEdit(RubroCliente $rubro): void
    {
        $this->dispatch('openModalEditRubro', rubro: $rubro);
    }

    public function openModalDelete(RubroCliente $rubro): void
    {
        $this->dispatch('openModalDeleteRubro', rubro: $rubro);
    }
}
