<?php

namespace App\Notifications\Certificados;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyClienteCertificadoCreada extends Notification implements ShouldQueue
{
    use Queueable;

    public $certificado;

    public function __construct($certificado)
    {

        $this->certificado = $certificado;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        dd($this->certificado);
        return (new MailMessage)
            ->subject('SE HA CREADO UN CERTIFICADO')
            ->view('mail.certificados.certificado', ['certificado' => $this->certificado]);
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
