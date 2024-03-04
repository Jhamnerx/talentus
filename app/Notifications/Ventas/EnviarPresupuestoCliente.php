<?php

namespace App\Notifications\Ventas;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class EnviarPresupuestoCliente extends Notification
{
    use Queueable;

    public $presupuesto;
    public $pdf;
    public $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($presupuesto, $pdf, $data)
    {
        $this->presupuesto = $presupuesto;
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
        //dd($this->pdf->output());
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->attachData($this->pdf->output(), 'COTIZACIÓN-' . $this->presupuesto->serie_correlativo . '.pdf', [
                'mime' => 'application/pdf',
            ])
            ->subject($this->data["asunto"])
            ->view('mail.ventas.presupuesto', ['presupuesto' => $this->presupuesto, 'data' => $this->data]);
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
