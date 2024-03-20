<?php

namespace App\Livewire\Admin\Tecnico\Tareas\Modales;

use Carbon\Carbon;
use App\Models\Tareas;
use Livewire\Component;
use Livewire\Attributes\On;

class CancelarModal extends Component
{

    public Tareas $tarea;
    public $openModalDelete = false;

    public function cancel()
    {
        $this->tarea->estado = "CANCELED";
        $this->tarea->fecha_termino = Carbon::now();
        $this->tarea->save();
        $this->afterCancel();
    }

    #[On('open-modal-cancel')]
    public function openModalDelete(Tareas $tarea)
    {
        $this->openModalDelete = true;
        $this->tarea = $tarea;
    }


    public function render()
    {
        return view('livewire.admin.tecnico.tareas.modales.cancelar-modal');
    }


    public function afterCancel()
    {


        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'TAREA CANCELADA',
            mensaje: 'Se cancelo la tarea: ' . $this->tarea->token . "."
        );

        $this->dispatch('render-cancel');
    }
}
