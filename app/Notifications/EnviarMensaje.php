<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class EnviarMensaje extends Notification implements ShouldQueue
{
    use Queueable;

    public $mensaje;

    public function __construct($mensaje)
    {
  
        $this->mensaje = $mensaje;
    }


    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];

    }

    public function toMail($notifiable)
    {

        return (new MailMessage)
                ->subject('TALENTUS NOTIFICACION')
                ->view('mail.notificacion', ['mensaje' => $this->mensaje]);
   
    }

    public function toDatabase($notifiable)
    {
     
        return [
            'url' => route($this->mensaje["url"], $this->mensaje["id_certificado"]),
            'asunto' => $this->mensaje["asunto"],
            'mensaje' => $this->mensaje["body"],
            'accion' => $this->mensaje["accion"],
        ];
    }


    public function toBroadcast($notifiable){

        return new BroadcastMessage([]);

    }
}
