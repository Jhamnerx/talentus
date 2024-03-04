<?php

namespace App\Livewire\Admin\Ventas\Contratos;

use App\Models\Contratos;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public Contratos $contrato;

    public $openModalDelete = false;

    public function delete()
    {

        $this->contrato->delete();

        $this->dispatch(
            'notify-toast',
            icon: 'success',
            title: 'CONTRATO ELIMINADO',
            mensaje: 'Eliminaste el # contrato',
        );

        $this->dispatch('update-table');

        $this->openModalDelete = false;
    }


    #[On('open-modal-delete')]
    public function openModalDelete(Contratos $contrato)
    {

        $this->openModalDelete = true;
        $this->contrato = $contrato;
    }

    public function render()
    {
        return view('livewire.admin.ventas.contratos.delete');
    }
}
