<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnviarPresupuestoCliente extends Notification
{
    use Queueable;

    public $presupuesto;
    public $pdf;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($presupuesto, $pdf)
    {
        $this->presupuesto = $presupuesto;
        $this->pdf = $pdf;
        //
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
                    ->attachData($this->pdf->output(), 'PRESUPUESTO-'.$this->presupuesto->numero.'.pdf', [
                        'mime' => 'application/pdf',
                    ])
                    ->subject('TALENTUS - COTIZACIÓN #'.$this->presupuesto->numero)
                    ->view('mail.presupuesto', ['presupuesto' => $this->presupuesto]);
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
}
