<?php

namespace App\Livewire\Admin\Tecnico\Tareas;

use App\Models\Tareas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InformTask extends Component
{

    public $message;
    public $openModal = false;
    public Tareas $tarea;

    protected $listeners = [
        'open-modal-inform' => 'openModal',
    ];

    public function render()
    {
        return view('livewire.admin.tecnico.tareas.inform-task');
    }
    public function openModal(Tareas $tarea)
    {
        $this->tarea = $tarea;
        $this->openModal = true;
        $this->dispatch('set-data', ['data' => $tarea->informe ? $tarea->informe->message : '']);
    }

    public function closeModal()
    {
        $this->openModal = false;
    }

    public function save()
    {


        $informe = $this->tarea->informe()->updateOrCreate([
            'tarea_id' => $this->tarea->id
        ], [
            'message' => $this->message,
            'user_id' => Auth::user()->id,
        ]);
        $this->closeModal();
        $this->dispatch('save-inform', ['token' => $this->tarea->token]);
    }
}
