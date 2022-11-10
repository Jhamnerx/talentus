<?php

namespace App\Notifications\Certificados;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyClienteActaCreada extends Notification implements ShouldQueue
{
    use Queueable;

    public $acta;

    public function __construct($acta)
    {
        $this->acta = $acta;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject('SE HA CREADO UN ACTA ')
            ->view('mail.certificados.acta', ['acta' => $this->acta]);
    }


    // public function withDelay($notifiable)
    // {
    //     return [

    //         'mail' => now()->addSeconds(30),

    //     ];
    // }

    // public function viaQueues()
    // {
    //     return [
    //         'mail' => 'mail',
    //     ];
    // }
}
