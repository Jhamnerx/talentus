<?php

namespace App\Livewire\Admin\Contactos;

use App\Models\Contacto;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Delete extends Component
{
    use WireUiActions;

    public $contactoId;
    public $showModal = false;

    protected $listeners = ['deleteContacto'];

    public function deleteContacto($contactoId)
    {
        $this->contactoId = $contactoId;
        $this->showModal = true;
    }

    public function confirmarEliminacion()
    {
        $contacto = Contacto::find($this->contactoId);

        if ($contacto) {
            $contacto->delete();
            $this->notification()->success('Contacto eliminado correctamente');
            $this->dispatch('updateTable');
            $this->closeModal();
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->contactoId = null;
    }

    public function render()
    {
        return view('livewire.admin.contactos.delete');
    }
}
