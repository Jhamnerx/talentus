<?php

namespace App\Livewire\Admin\Tecnico\Tareas\Modales;

use App\Models\Tareas;
use Livewire\Attributes\On;
use Livewire\Component;

class Iframe extends Component
{
    public $modalFrame = false;

    public $tarea;

    public function render()
    {
        return view('livewire.admin.tecnico.tareas.modales.iframe');
    }

    #[On('open-modal-imagen')]
    public function openModal(Tareas $tarea)
    {
        $this->modalFrame = true;
        $this->tarea = $tarea;
    }

    public function close()
    {
        $this->modalFrame = false;
    }
}
