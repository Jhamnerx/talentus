<?php

namespace App\Notifications\Mantenimientos;

use App\Models\Mantenimiento;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyClient extends Notification implements ShouldQueue
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
        return ['mail'];
    }


    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject($this->mensaje["asunto"])
            ->view('mail.notifications.mantenimiento.cliente', ['mensaje' => $this->mensaje, 'mantenimiento' => $this->mantenimiento]);
    }
}
