<?php

namespace App\Listeners;

use App\Models\Admin\Mensaje;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class nuevoCertificadoAdminsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $data = array(
            'id' => $event->certificado->id,
            'url' => 'admin.certificados.gps.index',
            'asunto' => 'CERTIFICADO CREADO',
            'body' => 'El usuario '.User::find($event->certificado->user_id)->name.' ha creado un nuevo certificado',
            'accion' => 'certificado_created',
            'from_user_id' => auth()->id(),
        );

        $mensaje = new Mensaje();
        $mensaje->sendMessage($data);
    }
}
