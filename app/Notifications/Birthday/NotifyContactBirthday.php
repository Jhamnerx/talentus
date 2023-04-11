<?php

namespace App\Notifications\Birthday;

use App\Models\Contactos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyContactBirthday extends Notification
{
    use Queueable;

    public Contactos $contacto;

    public function __construct(Contactos $contacto)
    {
        $this->contacto = $contacto;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('FELIZ CUMPLEAÑOS ' . $this->contacto->nombre . ' TE DESEA TALENTUS TECHNOLOGY')
            ->view('pdf.birthday.pdf', ['contacto' => $this->contacto]);
    }
}
