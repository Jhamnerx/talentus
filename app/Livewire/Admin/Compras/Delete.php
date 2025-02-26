<?php

namespace App\Livewire\Admin\Compras;

use App\Models\Compras;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\On;
use Livewire\Component;
use Exception;

class Delete extends Component
{

    public Compras $compra;
    public $modalDelete;


    public function delete()
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

    #[On('open-modal-delete')]
    public function openModalDelete(Compras $compra)
    {
        $this->modalDelete = true;
        $this->compra = $compra;
    }


    public function render()
    {
        return view('livewire.admin.compras.delete');
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
            title: 'COMPRA ELIMINADA',
            mensaje: 'se elimino correctamente la compra'
        );

        $this->dispatch('update-table');
    }
}
