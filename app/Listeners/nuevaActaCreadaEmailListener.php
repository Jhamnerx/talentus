<?php

namespace App\Listeners;

use App\Events\nuevaActaCreada;
use App\Models\Actas;
use App\Models\Vehiculos;
use App\Notifications\Certificados\NotifyClienteActaCreada;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class nuevaActaCreadaEmailListener
{

    public function __construct()
    {
        //
    }


    public function handle(nuevaActaCreada $event)
    {
        //NOTIFICACION PARA CLIENTES ACTAS CREADA
        if ($event->acta->vehiculo->cliente) {

            $event->acta->vehiculo->cliente->notify(new NotifyClienteActaCreada($event->acta));
        }
    }

    public function failed(nuevaActaCreada $event, $exception)
    {
        //
    }
}
