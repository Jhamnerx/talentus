<?php

namespace App\Notifications\Certificados;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyClienteCertificadoVelocimetroCreada extends Notification implements ShouldQueue
{
    use Queueable;



    public function __construct(public $certificado)
    {
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('SE HA CREADO UN CERTIFICADO VELOCIMETRO')
            ->view('mail.certificados.certificado-velocimetro', ['certificado' => $this->certificado]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
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
