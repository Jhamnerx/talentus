<?php

namespace App\Notifications\Certificados;

use App\Models\Actas;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesAndRestoresModelIdentifiers;
use Illuminate\Queue\SerializesModels;

class NotifyClienteActaCreada extends Notification
{
    use Queueable, SerializesModels;

    public $acta;

    public function __construct(Actas $acta)
    {
        $this->acta = $acta;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

        // dd($this->acta->vehiculo->cliente);

        return (new MailMessage)
            ->subject('SE HA CREADO UN ACTA')
            ->view('mail.certificados.acta', ['acta' => $this->acta]);
    }


    public function withDelay($notifiable)
    {
        return [

            'mail' => now()->addSeconds(30),

        ];
    }

    public function viaQueues()
    {
        return [
            'mail' => 'mail',
        ];
    }
}
