<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas\Modales;

use App\Models\Tareas;
use Livewire\Component;
use Livewire\WithPagination;

class Canceled extends Component
{
    use WithPagination;

    public $openModal = false;
    public $search = '';

    protected $listeners = [
        'openModalCanceled' => 'openModal',
    ];
    public function render()
    {
        $tareas = Tareas::whereHas('vehiculo', function ($vehiculo) {
            $vehiculo->where('placa', 'LIKE', '%' . $this->search . '%');
        })->orWhereHas('cliente', function ($cliente) {
            $cliente->where('razon_social', 'LIKE', '%' . $this->search . '%');
        })->orWhereHas('user', function ($user) {
            $user->where('name', 'LIKE', '%' . $this->search . '%');
        })->orWhereHas('tipo_tarea', function ($user) {
            $user->where('nombre', 'LIKE', '%' . $this->search . '%');
        })->orWhere('dispositivo', 'LIKE', '%' . $this->search . '%')
            ->orWhere('numero', 'LIKE', '%' . $this->search . '%')
            ->with('vehiculo', 'cliente', 'user', 'tipo_tarea', 'image')
            ->estado('CANCELED')->with('vehiculo', 'cliente', 'user', 'tipo_tarea')
            ->paginate(5, ['*'], 'canceledPage');
        return view('livewire.admin.tecnico.tareas.modales.canceled', compact('tareas'));
    }
    public function updatingSearch()
    {
        $this->resetPage('canceledPage');
    }
    public function openModal()
    {
        $this->openModal = true;
    }

    public function deleteTask(Tareas $task)
    {

        $this->dispatchBrowserEvent('update-task', ['titulo' => 'TAREA ELIMINADA', 'message' => 'Se elimino la tarea',  'token' => $task->token, 'color' => '#f87171', 'progressBarColor' => 'rgb(255,255,255)']);
        $task->delete();
        $this->render();
    }
}
