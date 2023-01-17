<?php

namespace App\Notifications\Imports;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportHasFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $data)
    {
        //dd($data["value"]);
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'asunto' => 'Error al importar un archivo',
            'mensaje' => $this->data['error'] . ' en la fila ' . $this->data['row'] . '   - ' . $this->data["value"],
            'data' => $this->data,
            'tipo' => 'error_import',
        ];
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
