<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas;

use App\Models\Tareas;
use Livewire\Component;

class Delete extends Component
{
    public Tareas $tarea;

    public $modalDelete = false;

    protected $listeners = [
        'deleteTarea' => 'openModal',
    ];

    public function delete()
    {
        $this->tarea->delete();
        $this->dispatchBrowserEvent('update-task', ['titulo' => 'TAREA ELIMINADA', 'message' => 'Se elimino la tarea',  'token' => $this->tarea->token, 'color' => '#f87171', 'progressBarColor' => 'rgb(255,255,255)']);

        $this->emit('updateIndex');
    }


    public function openModal(Tareas $tarea)
    {
        $this->modalDelete = true;
        $this->tarea = $tarea;
    }
    public function render()
    {
        return view('livewire.admin.tecnico.tareas.delete');
    }
}
