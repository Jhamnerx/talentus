<?php

namespace App\Livewire\Admin\Clientes;

use Livewire\Component;

class ButtonOpenModal extends Component
{
    public function render()
    {
        return view('livewire.admin.clientes.button-open-modal');
    }

    public function OpenModalCliente()
    {
        $this->dispatch('openModalSaveCliente');
    }
}
