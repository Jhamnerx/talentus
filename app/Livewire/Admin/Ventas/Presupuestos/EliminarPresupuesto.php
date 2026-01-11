<?php

namespace App\Livewire\Admin\Ventas\Presupuestos;

use App\Models\Presupuestos;
use Livewire\Attributes\On;
use Livewire\Component;

class EliminarPresupuesto extends Component
{
    public Presupuestos $presupuesto;
    public $mostrarModal = false;

    #[On('open-modal-delete')]
    public function abrirModal(Presupuestos $presupuesto)
    {
        $this->mostrarModal = true;
        $this->presupuesto = $presupuesto;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function eliminar()
    {
        $this->presupuesto->delete();
        $this->afterDelete();
    }

    public function afterDelete()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'PRESUPUESTO ELIMINADO',
            mensaje: 'Se elimino el presupuesto: ' . $this->presupuesto->serie_correlativo . "."
        );
        $this->dispatch('render');
    }

    public function render()
    {
        return view('livewire.admin.ventas.presupuestos.eliminar-presupuesto');
    }
}
