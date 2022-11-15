<?php

namespace App\Listeners;

use App\Events\nuevoCertificadoGpsCreado;
use App\Notifications\Certificados\NotifyClienteCertificadoVelocimetroCreada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class nuevoCertificadoGpsEmailListener
{

    public function __construct()
    {
        //
    }

    public function handle(nuevoCertificadoGpsCreado $event)
    {
        if ($event->certificado->vehiculo->cliente) {

            $event->certificado->vehiculo->cliente->notify(new NotifyClienteCertificadoVelocimetroCreada($event->certificado));
        }
    }
}
