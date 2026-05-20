<?php

namespace App\Livewire\Admin\Ajustes\Operadores;

use App\Models\Operador;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Delete extends Component
{
    use WireUiActions;
    public ?Operador $operador = null;
    public bool $openModalDelete = false;

    protected $listeners = ['openModalDelete'];

    public function openModalDelete(Operador $operador): void
    {
        $this->openModalDelete = true;
        $this->operador        = $operador;
    }

    public function delete(): void
    {
        $nombre = $this->operador->name;
        $this->operador->delete();

        $this->notification()->error('OPERADOR ELIMINADO', 'Se eliminó: ' . $nombre);
        $this->dispatch('update-table');
        $this->openModalDelete = false;
        $this->operador        = null;
    }

    public function render()
    {
        return view('livewire.admin.ajustes.operadores.delete');
    }
}
