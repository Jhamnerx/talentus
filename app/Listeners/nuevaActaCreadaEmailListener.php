<?php

namespace App\Listeners;

use App\Events\nuevaActaCreada;
use App\Models\Actas;
use App\Notifications\Certificados\NotifyClienteActaCreada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class nuevaActaCreadaEmailListener
{

    public function __construct()
    {
        //
    }


    public function handle(nuevaActaCreada $event)
    {

        //NOTIFICACION PARA CLIENTES ACTAS CREADA
        //dd($event->acta->vehiculo->cliente);

        if ($event->acta->vehiculo->cliente) {

            $event->acta->vehiculo->cliente->notify(new NotifyClienteActaCreada($event->acta));
        }
    }
}
