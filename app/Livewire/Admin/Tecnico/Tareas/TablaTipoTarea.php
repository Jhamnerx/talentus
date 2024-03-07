<?php

namespace App\Livewire\Admin\Tecnico\Tareas;

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
            ->orWhere('costo', $this->search)->paginate($this->pages, ['*'], 'tipoTaskPage');

        return view('livewire.admin.tecnico.tareas.tabla-tipo-tarea', compact('tareas'));
    }

    public function addTipoTask()
    {
        $this->dispatch('addTipoTask');
    }

    public function editTipoTask(tipoTareas $task)
    {

        $this->dispatch('openModalEditTipoTask', $task);
    }

    public function deleteTipoTask(tipoTareas $task)
    {

        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'TIPO TAREA ELIMINADA',
            mensaje: 'Se elimino el tipo tarea'
        );

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
