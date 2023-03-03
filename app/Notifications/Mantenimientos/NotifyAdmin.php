<?php

namespace App\Notifications\Mantenimientos;

use App\Models\Mantenimiento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NotifyAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    public $mensaje;
    public Mantenimiento $mantenimiento;

    public function __construct($mensaje, $mantenimiento)
    {
        $this->mensaje = $mensaje;
        $this->mantenimiento = $mantenimiento;
    }


    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }


    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject($this->mensaje["asunto"])
            ->view('mail.notifications.mantenimiento.admin', ['mensaje' => $this->mensaje, 'mantenimiento' => $this->mantenimiento]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'url' => route($this->mensaje["url"], $this->mensaje["id_mantenimiento"]),
            'asunto' => $this->mensaje["asunto"],
            'mensaje' => $this->mensaje["body"],
            'accion' => $this->mensaje["accion"],
            'tipo' => 'mantenimiento',
        ];
    }

    public function toBroadcast($notifiable)
    {

        return new BroadcastMessage([]);
    }
}
