<?php

namespace App\Listeners;

use App\Events\nuevoCertificadoCreado;
use App\Notifications\Certificados\NotifyClienteCertificadoCreada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class nuevoCertificadoEmailListener
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
    public function handle(nuevoCertificadoCreado $event)
    {
        if ($event->certificado->vehiculo->cliente) {

            $event->certificado->vehiculo->cliente->notify(new NotifyClienteCertificadoCreada($event->certificado));
        }
    }
}
