<?php

namespace App\Livewire\Admin\Clientes\Contactos;

use Livewire\Component;
use App\Models\Contactos;
use Livewire\Attributes\On;

class EliminarContacto extends Component
{
    public Contactos $contacto;
    public $mostrarModal = false;
    public $modo = false;

    #[On('open-modal-delete')]
    public function abrirModal(Contactos $contacto)
    {
        $this->mostrarModal = true;
        $this->contacto = $contacto;
    }

    public function cerrarModal()
    {
        $this->mostrarModal = false;
    }

    public function eliminar()
    {
        if ($this->modo == false) {
            $this->contacto->delete();
        } else {
            $this->contacto->forceDelete();
        }
        $this->afterDelete();
    }

    public function afterDelete()
    {
        $this->cerrarModal();
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

    public function render()
    {
        return view('livewire.admin.clientes.contactos.eliminar-contacto');
    }
}
