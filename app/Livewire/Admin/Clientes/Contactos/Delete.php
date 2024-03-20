<?php

namespace App\Livewire\Admin\Clientes\Contactos;

use Livewire\Component;
use App\Models\Contactos;
use Livewire\Attributes\On;

class Delete extends Component
{

    public Contactos $contacto;
    public $modalDelete = false;

    public $modo = false;

    public function delete()
    {

        if ($this->modo == false) {

            $this->contacto->delete();
        } else {

            $this->contacto->forceDelete();
        }

        $this->afterDelete();
    }

    #[On('open-modal-delete')]
    public function openModalDelete(Contactos $contacto)
    {
        $this->modalDelete = true;
        $this->contacto = $contacto;
    }

    public function render()
    {

        return view('livewire.admin.clientes.contactos.delete');
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
            title: 'CONTACTO ELIMINADO',
            mensaje: 'se elimino correctamente el contacto'
        );
        $this->dispatch('update-table');
        $this->reset('modo');
        $this->render();
    }
}
