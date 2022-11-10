<?php

namespace App\Observers;

use App\Models\Vehiculos;

class VehiculosObserver
{

    public function creating(Vehiculos $vehiculo)
    {

        if (!\App::runningInConsole()) {
            // dd($acta);
            $vehiculo->empresa_id = session('empresa');
        }
    }

    public function created(Vehiculos $vehiculos)
    {
        //
    }


    public function updated(Vehiculos $vehiculos)
    {
        //
    }

    /**
     * Handle the Vehiculos "deleted" event.
     *
     * @param  \App\Models\Vehiculos  $vehiculos
     * @return void
     */
    public function deleted(Vehiculos $vehiculos)
    {
        //
    }

    /**
     * Handle the Vehiculos "restored" event.
     *
     * @param  \App\Models\Vehiculos  $vehiculos
     * @return void
     */
    public function restored(Vehiculos $vehiculos)
    {
        //
    }

    /**
     * Handle the Vehiculos "force deleted" event.
     *
     * @param  \App\Models\Vehiculos  $vehiculos
     * @return void
     */
    public function forceDeleted(Vehiculos $vehiculos)
    {
        //
    }
}
