<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\Cobros;
use Livewire\Component;

class Delete extends Component
{
    public Cobros $cobro;
    public $openModalDelete = false;

    protected $listeners = [
        'openModalDelete'
    ];

    public function delete()
    {
        $this->cobro->delete();

        $this->afterDelete();
    }

    public function openModalDelete(Cobros $cobro)
    {

        $this->openModalDelete = true;
        $this->cobro = $cobro;
    }

    public function afterDelete()
    {

        $this->dispatch(
            'notify-toast',
            icon: 'error',
            tittle: 'COBRO ELIMINADO',
            mensaje: 'Se elimino el cobro'
        );

        $this->dispatch('render');
    }
    public function render()
    {
        return view('livewire.admin.cobros.delete');
    }
}
