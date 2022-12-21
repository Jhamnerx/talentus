<?php

namespace App\Observers;

use App\Http\Controllers\Admin\ServicioTecnicoController;
use App\Models\Tareas;
use App\Notifications\Tecnico\NotificacionTarea;
use Illuminate\Support\Facades\Auth;

class TareasObserver
{
    public function creating(Tareas $tarea)
    {
        $tareaController = new ServicioTecnicoController();

        $tarea->token = $tareaController->setNextSequenceNumber();
        $tarea->user_id = auth()->user()->id;
    }

    public function created(Tareas $tarea)
    {
        $tarea->tecnico->notify(new NotificacionTarea($tarea));
    }


    public function updated(Tareas $tarea)
    {
        //
    }


    public function deleted(Tareas $tarea)
    {
        //
    }

    public function restored(Tareas $tarea)
    {
        //
    }


    public function forceDeleted(Tareas $tarea)
    {
        //
    }
}
