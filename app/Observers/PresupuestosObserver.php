<?php

namespace App\Observers;

use App\Models\Presupuestos;

class PresupuestosObserver
{
    /**
     * Handle the Presupuestos "created" event.
     *
     * @param  \App\Models\Presupuestos  $presupuesto
     * @return void
     */
    public function creating(Presupuestos $presupuesto)
    {

    
        if(! \App::runningInConsole()){

            $presupuesto->empresa_id = session('empresa');

        }
       
    }

    public function created(Presupuestos $presupuesto)
    {
        //
    }

    /**
     * Handle the Presupuestos "updated" event.
     *
     * @param  \App\Models\Presupuestos  $presupuesto
     * @return void
     */
    public function updated(Presupuestos $presupuesto)
    {
        //
    }

    /**
     * Handle the Presupuestos "deleted" event.
     *
     * @param  \App\Models\Presupuestos  $presupuesto
     * @return void
     */
    public function deleted(Presupuestos $presupuesto)
    {
        //
    }

    /**
     * Handle the Presupuestos "restored" event.
     *
     * @param  \App\Models\Presupuestos  $presupuesto
     * @return void
     */
    public function restored(Presupuestos $presupuesto)
    {
        //
    }

    /**
     * Handle the Presupuestos "force deleted" event.
     *
     * @param  \App\Models\Presupuestos  $presupuesto
     * @return void
     */
    public function forceDeleted(Presupuestos $presupuesto)
    {
        //
    }
}
