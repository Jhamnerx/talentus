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
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->subject('Tienes un nuevo Mensaje')
        //             ->greeting('Hola Sr.')
        //             ->line('Se ha creado una nueva acta.')
        //             ->action('Notification Action', route('mensajes.show', $this->mensaje->id))
        //             ->line('Has luego');

        return (new MailMessage)
                ->subject('Tienes un nuevo Mensaje')
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
            'url' => route('admin.certificados.actas.index'),
            'accion' => $this->mensaje->accion,
            'mensaje' => 'El usuario '.User::find($this->mensaje->from_user_id)->name.' ha creado una nueva acta',
        ];
    }

    public function toBroadcast($notifiable){

        return new BroadcastMessage([]);

    }
}
