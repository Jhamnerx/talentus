<?php

namespace App\Observers;

use App\Models\Tareas;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Notifications\Tecnico\NotificacionTarea;
use App\Http\Controllers\Admin\ServicioTecnicoController;

class TareasObserver
{
    public function creating(Tareas $tarea)
    {
        $tareaController = new ServicioTecnicoController();

        $tarea->token = $tareaController->setNextSequenceNumber();
        $tarea->user_id = auth()->user()->id;
        $tarea->uuid = Str::uuid();
        $tarea->empresa_id = session('empresa');
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
