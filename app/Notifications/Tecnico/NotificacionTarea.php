<?php

namespace App\Notifications\Tecnico;

use App\Models\Tareas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionTarea extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    public $tarea;

    public function __construct(Tareas $tarea)
    {
        $this->tarea = $tarea;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'url' => route('admin.tecnico.tareas.index'),
            'asunto' => 'TAREA CREADA ' . $this->tarea->token,
            'mensaje' => 'Se ha creado la tarea con ID ' . $this->tarea->token . ' por favor revisar',
            'accion' => 'tarea_creada',
            'tipo' => 'tarea_creada',
        ];
    }

    public function toBroadcast($notifiable)
    {

        return new BroadcastMessage([]);
    }

    // public function viaQueues()
    // {
    //     return [
    //         'database' => 'database',
    //         'broadcast' => 'broadcast',
    //     ];
    // }
}
