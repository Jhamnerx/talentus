<?php

namespace App\Http\Livewire\Admin\Tecnico\Tareas;

use App\Models\Tareas;
use Livewire\Component;
use Livewire\WithPagination;

class TablaHistorial extends Component
{
    use WithPagination;
    public $search = '';
    public $pages = 10;

    protected $listeners = [
        'updateIndex' => 'render'
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
            ->orderBy('id', 'desc')
            ->paginate();

        return view('livewire.admin.tecnico.tareas.tabla-historial', compact('tareas'));
    }

    public function addTask()
    {
        $this->emit('addTask');
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
