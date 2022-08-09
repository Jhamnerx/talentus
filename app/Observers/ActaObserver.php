<?php

namespace App\Observers;

use App\Models\Actas;
use App\Models\Admin\Mensaje;
use App\Notifications\ActaCreada;


class ActaObserver
{
    /**
     * Handle the Actas "created" event.
     *
     * @param  \App\Models\Actas  $actas
     * @return void
     */
    public function creating(Actas $acta)
    {

        if(! \App::runningInConsole()){

            $acta->empresa_id = session('empresa');

        }
       
    }   
     public function updating(Actas $acta)
    {

        if(! \App::runningInConsole()){

            $acta->empresa_id = session('empresa');

        }
       
    }
    public function created(Actas $acta)
    {
        if(! \App::runningInConsole()){

            $data = array(
                'body' => 'Se ha creado un acta',
                'asunto' => 'ACTA CREADA',
                'accion' => 'acta_created',
                'from_user_id' => auth()->id(),
            );


        //     $mensaje = new Mensaje();
        // //$mensaje->sendMessage($data, 'to_user');
        //     $mensaje->sendMessage($data, 'to_client');

            $acta->vehiculos->flotas->clientes->notify(new ActaCreada($acta));

            $mensaje = new Mensaje();
            $mensaje->sendMessage($data);

           

        }

    }

    /**
     * Handle the Actas "updated" event.
     *
     * @param  \App\Models\Actas  $actas
     * @return void
     */
    public function updated(Actas $actas)
    {
        //
    }

    /**
     * Handle the Actas "deleted" event.
     *
     * @param  \App\Models\Actas  $actas
     * @return void
     */
    public function deleted(Actas $actas)
    {
        //
    }

    /**
     * Handle the Actas "restored" event.
     *
     * @param  \App\Models\Actas  $actas
     * @return void
     */
    public function restored(Actas $actas)
    {
        //
    }

    /**
     * Handle the Actas "force deleted" event.
     *
     * @param  \App\Models\Actas  $actas
     * @return void
     */
    public function forceDeleted(Actas $actas)
    {
        //
    }
}
