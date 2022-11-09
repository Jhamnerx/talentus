<?php

namespace App\Notifications\Certificados;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnviarCertificadoCliente extends Notification
{
    use Queueable;

    public $certificado;
    public $pdf;
    public $data;

    public function __construct($certificado, $pdf, $data)
    {
        $this->certificado = $certificado;
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
            ->attachData($this->pdf->output(), 'CERTIFICADO-' . $this->certificado->codigo . '.pdf', [
                'mime' => 'application/pdf',
            ])
            ->subject($this->data["asunto"])
            ->view('mail.certificados.certificado-mail', ['certificado' => $this->certificado, 'data' => $this->data]);
    }
}
