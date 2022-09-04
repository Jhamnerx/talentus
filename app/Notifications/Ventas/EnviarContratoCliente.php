<?php

namespace App\Notifications\Ventas;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnviarContratoCliente extends Notification
{
    use Queueable;

    public $contrato;
    public $pdf;
    public $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($contrato, $pdf, $data)
    {
        $this->contrato = $contrato;
        $this->pdf = $pdf;
        $this->data = $data;
       
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->attachData($this->pdf->output(), 'CONTRATO '.$this->contrato->clientes->razon_social.'.pdf', [
                        'mime' => 'application/pdf',
                    ])
                    ->subject($this->data["asunto"])
                    ->view('mail.ventas.contrato', ['contrato' => $this->contrato, 'data' => $this->data]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
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
