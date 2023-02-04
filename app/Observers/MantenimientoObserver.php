<?php

namespace App\Observers;

use App\Models\Mantenimiento;

class MantenimientoObserver
{

    public function creating(Mantenimiento $mantenimiento)
    {

        if (!\App::runningInConsole()) {
            $mantenimiento->empresa_id = session('empresa');
            $mantenimiento->user_id = auth()->user()->id;
        }
    }

    /**
     * Handle the Mantenimiento "created" event.
     *
     * @param  \App\Models\Mantenimiento  $mantenimiento
     * @return void
     */
    public function created(Mantenimiento $mantenimiento)
    {
        //
    }

    /**
     * Handle the Mantenimiento "updated" event.
     *
     * @param  \App\Models\Mantenimiento  $mantenimiento
     * @return void
     */
    public function updated(Mantenimiento $mantenimiento)
    {
        //
    }

    /**
     * Handle the Mantenimiento "deleted" event.
     *
     * @param  \App\Models\Mantenimiento  $mantenimiento
     * @return void
     */
    public function deleted(Mantenimiento $mantenimiento)
    {
        //
    }

    /**
     * Handle the Mantenimiento "restored" event.
     *
     * @param  \App\Models\Mantenimiento  $mantenimiento
     * @return void
     */
    public function restored(Mantenimiento $mantenimiento)
    {
        //
    }

    /**
     * Handle the Mantenimiento "force deleted" event.
     *
     * @param  \App\Models\Mantenimiento  $mantenimiento
     * @return void
     */
    public function forceDeleted(Mantenimiento $mantenimiento)
    {
        //
    }
}
