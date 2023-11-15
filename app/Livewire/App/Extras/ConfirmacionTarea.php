<?php

namespace App\Livewire\App\Extras;

use Carbon\Carbon;
use App\Models\Tareas;
use Livewire\Component;

class ConfirmacionTarea extends Component
{
    public Tareas $tarea;
    public $page;

    public function mount(Tareas $tarea, $page)
    {
        $this->tarea = $tarea;
        $this->page = $page;
    }

    public function render()
    {

        return view('livewire.app.extras.confirmacion-tarea');
    }

    public function confirmar(Tareas $tarea)
    {

        $tarea->respuesta = 1;
        $tarea->fecha_validacion = Carbon::now();
        $tarea->save();
        return redirect($this->page);
    }
    public function back()
    {
        return redirect()->route('web.home');
    }
}
