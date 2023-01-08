<?php

namespace App\Listeners;

use App\Events\nuevoCertificadoGpsCreado;
use App\Models\Admin\Mensaje;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class nuevoCertificadoGpsAdminsListener
{

    public function __construct()
    {
        //
    }


    public function handle(nuevoCertificadoGpsCreado $event)
    {
        $data = array(
            'id_certificado' => $event->certificado->id,
            'url' => "admin.certificados.velocimetros.index",
            'asunto' => 'CERTIFICADO DE VELOCIMETRO CREADO',
            'body' => 'El usuario ' . User::find($event->certificado->user_id)->name . ' ha creado un nuevo certificado',
            'accion' => 'certificado_velocimetro_created',
            'from_user_id' => auth()->id(),
        );

        $mensaje = new Mensaje();
        $mensaje->sendMessage($data);
    }
}
