<?php

namespace App\Notifications\Birthday;

use App\Models\Contactos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdmin extends Notification
{
    use Queueable;

    public Contactos $contacto;
    public $pdf;

    public function __construct(Contactos $contacto, $pdf)
    {
        $this->contacto = $contacto;
        $this->pdf = $pdf;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->attachData($this->pdf->output(), 'FELICITACIONES ' . $this->contacto->nombre . '.pdf', [
                'mime' => 'application/pdf',
            ])
            ->subject('NOTIFICACION DE CUMPLEAÑOS CLIENTE')
            ->view('pdf.birthday.pdf', ['contacto' => $this->contacto]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
