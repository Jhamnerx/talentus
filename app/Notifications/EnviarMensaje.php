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
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mensaje)
    {
  
        $this->mensaje = $mensaje;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
      // return ['mail', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
                ->subject('TALENTUS NOTIFICACION')
                ->view('mail.notificacion', ['mensaje' => $this->mensaje]);
   
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
     
        return [
            'url' => route($this->mensaje->url, $this->mensaje->id_certificado),
            'asunto' => $this->mensaje->asunto,
            'body' => $this->mensaje->body,
            'mensaje' => $this->mensaje->body,
            'accion' => $this->mensaje->action,
        ];
    }

    public function toArray($notifiable)
    {

        return [
            'url' => route($this->mensaje->url, $this->mensaje->id_certificado),
            'asunto' => $this->mensaje->asunto,
            'body' => $this->mensaje->body,
            'mensaje' => $this->mensaje->body,
            'accion' => $this->mensaje->action,
        ];
    }
    public function toBroadcast($notifiable){

        return new BroadcastMessage([]);

    }
}
