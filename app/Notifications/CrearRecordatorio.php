<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CrearRecordatorio extends Notification implements ShouldQueue
{
    use Queueable;

    public $recordatorio;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($recordatorio)
    {
        $this->recordatorio = $recordatorio;
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
        return (new MailMessage)
                ->subject('Tienes un nuevo Mensaje')
                ->view('mail.recordatorio', ['mensaje' => $this->recordatorio]);
   
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
            'placa' => 'AHF-976',
            'accion' => '',
            'mensaje' => '',
        ];
    }

    public function toBroadcast($notifiable){

        return new BroadcastMessage([]);

    }
}
