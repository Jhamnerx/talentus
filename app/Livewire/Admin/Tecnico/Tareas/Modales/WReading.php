<?php

namespace App\Livewire\Admin\Tecnico\Tareas\Modales;

use Carbon\Carbon;
use App\Models\Tareas;
use Livewire\Component;
use Livewire\WithPagination;

class WReading extends Component
{
    use WithPagination;

    public $openModal = false;
    public $search = '';

    protected $listeners = [
        'openModalWReading' => 'openModal',
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
            ->with('vehiculo', 'cliente', 'user', 'tipo_tarea')
            ->estado('UNREAD')->with('vehiculo', 'cliente', 'user', 'tipo_tarea')
            ->paginate(5, ['*'], 'unreadPage');
        return view('livewire.admin.tecnico.tareas.modales.w-reading', compact('tareas'));
    }
    public function updatingSearch()
    {
        $this->resetPage('unreadPage');
    }
    public function openModal()
    {
        $this->openModal = true;
    }
    public function closeModal()
    {
        $tareas = Tareas::estado('UNREAD')->update(array('estado' => 'PENDIENT'));

        $this->openModal = false;
        $this->dispatch('update-unread');
    }

    public function cancelTask(Tareas $task)
    {
        $task->estado = "CANCELED";
        $task->fecha_termino = Carbon::now();
        $task->save();
        $this->dispatch('update-task', ['titulo' => 'TAREA CANCELADA', 'message' => 'Se cancelo la tarea',  'token' => $task->token, 'color' => '#f87171', 'progressBarColor' => 'rgb(255,255,255)']);
        $this->render();
    }
}
