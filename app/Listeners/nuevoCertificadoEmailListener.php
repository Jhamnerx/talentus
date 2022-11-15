<?php

namespace App\Listeners;

use App\Events\nuevoCertificadoCreado;
use App\Notifications\Certificados\NotifyClienteCertificadoCreada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class nuevoCertificadoEmailListener
{

    public function __construct()
    {
        //
    }

    public function handle(nuevoCertificadoCreado $event)
    {
        //NOTIFICACION PARA CLIENTES CERTIFICADO CREADA
        if ($event->certificado->vehiculo->cliente) {

            $event->certificado->vehiculo->cliente->notify(new NotifyClienteCertificadoCreada($event->certificado));
        }
    }
}
