<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas\Modales;

use App\Models\Tareas;
use Livewire\Component;
use Livewire\WithPagination;

class Pending extends Component
{
    use WithPagination;

    public $openModal = false;
    public $search = '';

    protected $listeners = [
        'openModalPending' => 'openModal',
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
            ->estado('PENDIENT')->with('vehiculo', 'cliente', 'user', 'tipo_tarea')
            ->paginate(5, ['*'], 'PendientPage');
        return view('livewire.admin.tecnico.tareas.modales.pending', compact('tareas'));
    }

    public function updatingSearch()
    {
        $this->resetPage('PendientPage');
    }
    public function openModal()
    {
        $this->openModal = true;
    }
}
