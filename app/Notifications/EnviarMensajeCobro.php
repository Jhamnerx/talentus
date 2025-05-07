<?php

namespace App\Notifications;

use App\Models\DetalleCobros;
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

    public function __construct($mensaje)
    {
        dd($mensaje);
        $this->mensaje = $mensaje;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->mensaje["asunto"])
            ->view('mail.cobros', ['mensaje' => $this->mensaje]);
    }

    public function toDatabase($notifiable)
    {
        return [
            'url' => config('app.url') . '/admin/cobros/' . $this->mensaje['id_cobro'],
            'asunto' => $this->mensaje["asunto"],
            'mensaje' => $this->mensaje["body"],
            'accion' => $this->mensaje["accion"],
            'tipo' => 'cobro',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([]);
    }
}
