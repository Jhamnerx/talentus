<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas\Modales;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTecnicos extends Component
{

    use WithPagination;
    public $openModal = false;
    protected $listeners = [
        'openModalTecnicos' => 'openModal',
    ];

    public function render()
    {

        $usuarios = User::role('tecnico')->paginate(5);
        return view('livewire.admin.tecnico.tareas.modales.show-tecnicos', compact('usuarios'));
    }

    public function openModal()
    {
        $this->openModal = true;
    }

    public function closeModal()
    {
        $this->openModal = false;
    }
}
