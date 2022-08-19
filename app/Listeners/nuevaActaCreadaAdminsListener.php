<?php

namespace App\Listeners;

use App\Events\nuevaActaCreada;
use App\Models\Actas;
use App\Models\Admin\Mensaje;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class nuevaActaCreadaAdminsListener
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

        $data = array(
            'body' => 'Se ha creado un acta',
            'asunto' => 'ACTA CREADA',
            'accion' => 'acta_created',
            'from_user_id' => auth()->id(),
        );

        $mensaje = new Mensaje();
        $mensaje->sendMessage($data);

    }
}
