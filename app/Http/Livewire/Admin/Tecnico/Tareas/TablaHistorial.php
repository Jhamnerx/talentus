<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas;

use App\Models\Tareas;
use Livewire\Component;

class TablaHistorial extends Component
{
    public function render()
    {
        $tareas = Tareas::all();
        return view('livewire.admin.tecnico.tareas.tabla-historial', compact('tareas'));
    }

    public function addTask()
    {
        $this->emit('addTask');
    }
}
