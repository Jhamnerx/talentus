<?php

namespace App\Notifications\Certificados;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnviarActaCliente extends Notification
{
    use Queueable;


    public $acta;
    public $pdf;
    public $data;

    public function __construct($acta, $pdf, $data)
    {
        $this->acta = $acta;
        $this->pdf = $pdf;
        $this->data = $data;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->attachData($this->pdf->output(), 'ACTA-' . $this->acta->codigo . '.pdf', [
                'mime' => 'application/pdf',
            ])
            ->subject($this->data["asunto"])
            ->view('mail.certificados.acta', ['acta' => $this->acta, 'data' => $this->data]);
    }
}
