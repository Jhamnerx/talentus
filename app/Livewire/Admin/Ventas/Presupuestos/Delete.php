<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use App\Models\Presupuestos;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;

class Delete extends Component
{
    public Presupuestos $presupuesto;
    public $openModalDelete = false;

    public function delete()
    {
        $this->presupuesto->delete();

        $this->afterDelete();
    }


    #[On('open-modal-delete')]
    public function openModalDelete(Presupuestos $presupuesto)
    {
        $this->openModalDelete = true;
        $this->presupuesto = $presupuesto;
    }

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.delete');
    }

    public function afterDelete()
    {


        $this->dispatch(
            'notify-toast',
            icon: 'error',
            tittle: 'PRESUPUESTO ELIMINADO',
            mensaje: 'Se elimino el presupuesto: ' . $this->presupuesto->serie_correlativo . "."
        );

        $this->dispatch('render');
    }
}
