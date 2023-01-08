<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas;

use Livewire\Component;
use App\Models\tipoTareas;
use Livewire\WithPagination;

class TablaTipoTarea extends Component
{
    use WithPagination;
    public $search = '';
    public $pages = 10;

    protected $listeners = [
        'updateIndex' => 'render'
    ];

    public function render()
    {
        $tareas = tipoTareas::where('nombre', 'LIKE', '%' . $this->search . '%')
            ->orWhere('costo', $this->search)->paginate(5, ['*'], 'tipoTaskPage');

        return view('livewire.admin.tecnico.tareas.tabla-tipo-tarea', compact('tareas'));
    }

    public function addTipoTask()
    {
        $this->emit('addTipoTask');
    }

    public function editTipoTask(tipoTareas $task)
    {

        $this->emit('openModalEditTipoTask', $task);
    }

    public function deleteTipoTask(tipoTareas $task)
    {


        $this->dispatchBrowserEvent('update-task', ['titulo' => 'TIPO TAREA ELIMINADA', 'message' => 'Se elimino el tipo tarea',  'token' => '', 'color' => '#f87171', 'progressBarColor' => 'rgb(255,255,255)']);
        $task->delete();
        $this->render();
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function pagination($pages)
    {
        $this->pages = $pages;
    }
}
