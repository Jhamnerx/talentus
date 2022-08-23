<?php

namespace App\Listeners;

use App\Events\nuevoCertificadoGpsCreado;
use App\Notifications\Certificados\NotifyClienteCertificadoVelocimetroCreada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class nuevoCertificadoGpsEmailListener
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
    public function handle(nuevoCertificadoGpsCreado $event)
    {
        $event->certificado->vehiculos->flotas->clientes->notify(new NotifyClienteCertificadoVelocimetroCreada($event->certificado));
    }
}
