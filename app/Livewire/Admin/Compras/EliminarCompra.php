<?php

namespace App\Livewire\Admin\Compras;

use App\Models\Compras;
use Livewire\Attributes\On;
use Livewire\Component;
use Exception;

class EliminarCompra extends Component
{
    public Compras $compra;
    public $mostrarModal = false;

    #[On('open-modal-delete')]
    public function abrirModal(Compras $compra)
    {
        $this->mostrarModal = true;
        $this->compra = $compra;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function eliminar()
    {
        try {
            $this->compra->delete();
            $this->afterDelete();
        } catch (Exception $th) {
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
            title: 'COMPRA ELIMINADA',
            mensaje: 'se elimino correctamente la compra'
        );
        $this->dispatch('update-table');
    }

    public function render()
    {
        return view('livewire.admin.compras.eliminar-compra');
    }
}
