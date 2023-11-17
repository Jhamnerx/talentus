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
        $this->producto->delete();
        $this->afterDelete();
    }

    public function afterDelete()
    {
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            tittle: 'PRODUCTO ELIMINADO',
            mensaje: 'se elimino correctamente el producto'
        );

        $this->closeModal();
        $this->dispatch('update-table');
    }
}
