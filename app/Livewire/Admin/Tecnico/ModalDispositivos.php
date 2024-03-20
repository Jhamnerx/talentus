<?php

namespace App\Livewire\Admin\Tecnico;

use App\Models\Dispositivos;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalDispositivos extends Component
{
    public $openModal = false;

    public $user;

    public function render()
    {
        if ($this->user) {
            $dispositivos = $this->user->dispositivos()->paginate(5, pageName: 'dispositivo-page');
        } else {

            $dispositivos = [];
        }
        return view('livewire.admin.tecnico.modal-dispositivos', compact('dispositivos'));
    }

    #[On('open-modal-devices')]
    public function openModal(User $user)
    {
        $this->openModal = true;
        $this->user = $user;
        // $this->dispositivos = $user->dispositivos;
    }

    public function toggleStatus(Dispositivos $dispositivo)
    {
        $dispositivo->selled = !$dispositivo->selled; // Cambia el estado del toggle
        $dispositivo->save(); // Guarda el cambio en el modelo
    }
}
