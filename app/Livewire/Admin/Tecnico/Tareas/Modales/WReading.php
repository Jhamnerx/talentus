<?php

namespace App\Livewire\Admin\Tecnico\Tareas\Modales;

use Carbon\Carbon;
use App\Models\Tareas;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class WReading extends Component
{
    use WithPagination;

    public $openModal = false;
    public $search = '';


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
            ->orWhere('token', 'LIKE', '%' . $this->search . '%')
            ->with('vehiculo', 'cliente', 'user', 'tipo_tarea')
            ->estado('UNREAD')->with('vehiculo:id,placa', 'cliente:id,razon_social', 'user:id,name', 'tipo_tarea:id,nombre,descripcion')
            ->paginate(5, ['*'], 'unreadPage');

        return view('livewire.admin.tecnico.tareas.modales.w-reading', compact('tareas'));
    }

    public function updatingSearch()
    {
        $this->resetPage('unreadPage');
    }

    public function refreshComponent()
    {
        $this->render();
    }

    #[On('open-modal-unread')]
    public function openModal()
    {
        $this->openModal = true;
        $this->refreshComponent();
    }
    #[On('render-cancel')]
    public function updateTo()
    {
        $this->refreshComponent();
    }
    public function closeModal()
    {
        $tareas = Tareas::estado('UNREAD')->update(array('estado' => 'PENDIENT'));

        $this->openModal = false;
        $this->dispatch('update-unread');
    }

    public function cancelTask(Tareas $task)
    {

        $this->dispatch('open-modal-cancel', tarea: $task);
    }
}
