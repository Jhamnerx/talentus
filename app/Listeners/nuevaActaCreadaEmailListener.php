<?php

namespace App\Listeners;

use App\Events\nuevaActaCreada;
use App\Models\Actas;
use App\Notifications\Certificados\NotifyClienteActaCreada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class nuevaActaCreadaEmailListener
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
     * @param  \App\Events\nuevaActaCreada  $event
     * @return void
     */
    public function handle(nuevaActaCreada $event)
    {
        //NOTIFICACION PARA CLIENTES ACTAS CREADA
        if($event->acta->vehiculos->flotas){

            $event->acta->vehiculos->flotas->clientes->notify(new NotifyClienteActaCreada($event->acta));
        }
       

    }
}
