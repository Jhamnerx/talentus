<?php

namespace App\Livewire\Admin\Tecnico;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $tecnicos = User::where('name', 'like', '%' . $this->search . '%')->role('tecnico')->paginate(5);

        return view('livewire.admin.tecnico.index', compact('tecnicos'));
    }

    public function toggleStatus(User $tecnico)
    {
        $tecnico->is_active = !$tecnico->is_active; // Cambia el estado del toggle
        $tecnico->save(); // Guarda el cambio en el modelo
    }

    public function openModalDevices(User $user)
    {
        $this->dispatch('open-modal-devices', user: $user);
    }

    public function openModalSim(User $user)
    {

        $this->dispatch('open-modal-sim', user: $user);
    }
}
