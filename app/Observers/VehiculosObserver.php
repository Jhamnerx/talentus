<?php

namespace App\Observers;

use App\Models\Vehiculos;

class VehiculosObserver
{
    /**
     * Handle the Vehiculos "created" event.
     *
     * @param  \App\Models\Vehiculos  $vehiculos
     * @return void
     */
    public function created(Vehiculos $vehiculos)
    {
        //
    }

    /**
     * Handle the Vehiculos "updated" event.
     *
     * @param  \App\Models\Vehiculos  $vehiculos
     * @return void
     */
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
