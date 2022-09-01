<?php

namespace App\Notifications\Ventas;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnviarReciboCliente extends Notification
{
    use Queueable;

    public $recibo;
    public $pdf;
    public $data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($recibo, $pdf, $data)
    {
        $this->recibo = $recibo;
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
                    ->attachData($this->pdf->output(), 'COTIZACIÓN '.$this->recibo->serie."-".$this->recibo->numero.'.pdf',  [
                        'mime' => 'application/pdf',
                    ])
                    ->subject($this->data["asunto"])
                    ->view('mail.ventas.recibo', ['recibo' => $this->recibo, 'data' => $this->data]);
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
