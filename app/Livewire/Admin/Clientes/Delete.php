<?php

namespace App\Livewire\Admin\Clientes;

use Livewire\Component;
use App\Models\Clientes;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Model;

class Delete extends Component
{
    public $modalDelete = false;
    public  $cliente = 0;


    public function delete()
    {
        try {
            if (!$this->cliente) {
                throw new \Exception('No se ha seleccionado ningún cliente');
            }

            //$this->cliente->delete();
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

    #[On('open-modal-delete')]
    public function openModal(Clientes $cliente)
    {
        $this->cliente = $cliente;
        $this->modalDelete = true;
    }

    public function closeModal()
    {
        $this->modalDelete = false;
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

    public function render()
    {
        return view('livewire.admin.clientes.delete');
    }
}
