<?php

namespace App\Livewire\Admin\Productos;

use Livewire\Component;
use App\Models\Productos;
use Livewire\Attributes\On;

class Delete extends Component
{
    public $modalDelete = false;

    public Productos $producto;


    protected $listeners = [
        'openModalDelete' => 'openModal',
    ];


    public function render()
    {
        return view('livewire.admin.productos.delete');
    }

    #[On('open-modal-delete')]
    public function openModal(Productos $producto)
    {
        $this->modalDelete = true;
        $this->producto = $producto;
    }


    public function closeModal()
    {
        $this->modalDelete = false;
    }

    public function delete()
    {
        try {
            if ($this->producto->detalle_facturas()->exists()) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'warning',
                    title: 'NO SE PUEDE ELIMINAR',
                    mensaje: 'El producto tiene relaciones con ventas u otros modelos'
                );
                return;
            }

            $this->producto->delete();
            $this->afterDelete();
        } catch (\Exception $e) {
            $this->dispatch(
                'notify-toast',
                icon: 'error',
                title: 'ERROR',
                mensaje: 'Ocurrió un error al intentar eliminar el producto'
            );
        }
    }

    public function afterDelete()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'PRODUCTO ELIMINADO',
            mensaje: 'se elimino correctamente el producto'
        );

        $this->closeModal();
        $this->dispatch('pg:eventRefresh-TablaProductos');
    }
}
