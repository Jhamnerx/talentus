<?php

namespace App\Livewire\Admin\Cobros;

use App\Models\Cobros;
use Livewire\Component;

class EliminarCobro extends Component
{
    public Cobros $cobro;
    public $mostrarModal = false;

    protected $listeners = [
        'openModalDelete' => 'abrirModal'
    ];

    public function abrirModal(Cobros $cobro)
    {
        $this->mostrarModal = true;
        $this->cobro = $cobro;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function eliminar()
    {
        $this->cobro->delete();
        $this->afterDelete();
    }

    public function afterDelete()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'COBRO ELIMINADO',
            mensaje: 'Se elimino el cobro'
        );
        $this->dispatch('render');
    }

    public function render()
    {
        return view('livewire.admin.cobros.eliminar-cobro');
    }
}
