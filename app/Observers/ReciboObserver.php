<?php

namespace App\Observers;

use App\Models\Recibos;

class ReciboObserver
{

    public function creating(Recibos $recibo)
    {

    
        if(! \App::runningInConsole()){

            $recibo->empresa_id = session('empresa');

        }
       
    }    
    public function updating(Recibos $recibo)
    {

    
        if(! \App::runningInConsole()){

            $recibo->empresa_id = session('empresa');

        }
       
    }
    /**
     * Handle the Recibos "created" event.
     *
     * @param  \App\Models\Recibos  $recibos
     * @return void
     */
    public function created(Recibos $recibos)
    {
        //
    }

    /**
     * Handle the Recibos "updated" event.
     *
     * @param  \App\Models\Recibos  $recibos
     * @return void
     */
    public function updated(Recibos $recibos)
    {
        //
    }

    /**
     * Handle the Recibos "deleted" event.
     *
     * @param  \App\Models\Recibos  $recibos
     * @return void
     */
    public function deleted(Recibos $recibos)
    {
        //
    }

    /**
     * Handle the Recibos "restored" event.
     *
     * @param  \App\Models\Recibos  $recibos
     * @return void
     */
    public function restored(Recibos $recibos)
    {
        //
    }

    /**
     * Handle the Recibos "force deleted" event.
     *
     * @param  \App\Models\Recibos  $recibos
     * @return void
     */
    public function forceDeleted(Recibos $recibos)
    {
        //
    }
}
