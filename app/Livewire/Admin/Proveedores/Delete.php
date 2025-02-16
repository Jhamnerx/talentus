<?php

namespace App\Livewire\Admin\Proveedores;

use Livewire\Component;
use App\Models\Proveedores;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Model;

class Delete extends Component
{
    public Proveedores $proveedor;
    public $modalDelete = false;

    #[On('open-modal-delete')]
    public function openModal(Proveedores $proveedor)
    {
        $this->proveedor = $proveedor;
        $this->modalDelete = true;
    }


    public function delete()
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
    public function closeModal()
    {

        $this->modalDelete = false;
    }

    public function render()
    {
        return view('livewire.admin.proveedores.delete');
    }

    public function afterDelete()
    {
        $this->closeModal();
        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'CLIENTES ELIMINADO',
            mensaje: 'se elimino correctamente el cliente'
        );
        $this->dispatch('update-table');
    }
}
