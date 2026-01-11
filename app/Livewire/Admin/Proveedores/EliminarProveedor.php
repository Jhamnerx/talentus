<?php

namespace App\Livewire\Admin\Proveedores;

use Livewire\Component;
use App\Models\Proveedores;
use Livewire\Attributes\On;

class EliminarProveedor extends Component
{
    public Proveedores $proveedor;
    public $mostrarModal = false;

    #[On('open-modal-delete')]
    public function abrirModal(Proveedores $proveedor)
    {
        $this->proveedor = $proveedor;
        $this->mostrarModal = true;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function eliminar()
    {
        try {
            $this->proveedor->delete();
            $this->afterDelete();
        } catch (\Throwable $th) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR:',
                mensaje: $th->getMessage(),
            );
        }
    }

    public function afterDelete()
    {
        $this->cerrarModal();
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'PROVEEDOR ELIMINADO',
            mensaje: 'se elimino correctamente el proveedor'
        );
        $this->dispatch('update-table');
    }

    public function render()
    {
        return view('livewire.admin.proveedores.eliminar-proveedor');
    }
}
