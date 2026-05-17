<?php

namespace App\Livewire\Admin\Ajustes\Operadores;

use App\Models\Operador;
use Livewire\Component;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;

    public string $search = '';

    protected $listeners = ['render', 'update-table' => '$refresh'];

    public function render()
    {
        $operadores = Operador::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.ajustes.operadores.show', compact('operadores'));
    }

    public function openModalSave(): void
    {
        $this->dispatch('openModalSave');
    }

    public function openModalEdit(Operador $operador): void
    {
        $this->dispatch('openModalEdit', $operador);
    }

    public function openModalDelete(Operador $operador): void
    {
        $this->dispatch('openModalDelete', $operador);
    }
}
