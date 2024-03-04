<?php

namespace App\Livewire\Admin\Dispositivos;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ModelosDispositivo;

class DeleteModelo extends Component
{
    public ModelosDispositivo $modelo;

    public $modalDelete = false;

    public function delete()
    {
        $this->modelo->delete();
        $this->afterDelete();
    }

    #[On('open-modal-delete')]
    public function openModal(ModelosDispositivo $modelo)
    {
        $this->modelo = $modelo;
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
            title: 'MODELO ELIMINADO',
            mensaje: 'se elimino correctamente'
        );
        $this->dispatch('update-table');
    }

    public function render()
    {
        return view('livewire.admin.dispositivos.delete-modelo');
    }
}
