<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnviarMensajeCobro extends Notification implements ShouldQueue
{
    use Queueable;
    public $mensaje;
    public $cobro;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mensaje, $cobro)
    {
        $this->mensaje = $mensaje;
        $this->cobro = $cobro;
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
                ->view('mail.cobros', ['mensaje' => $this->mensaje, 'cobro' => $this->cobro]);
   
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
            'url' => route('admin.cobros.index'),
            'mensaje' => 'Cobro por Vencer',
        ];
    }

    public function toBroadcast($notifiable){

        return new BroadcastMessage([]);

    }
}
