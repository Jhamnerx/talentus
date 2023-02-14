<?php

namespace App\Observers;

use App\Models\Dispositivos;

class DispositivosObserver
{
    /**
     * Handle the Dispositivos "created" event.
     *
     * @param  \App\Models\Dispositivos  $dispositivos
     * @return void
     */
    public function creating(Dispositivos $dispositivo)
    {

        if (!\App::runningInConsole()) {
            $dispositivo->empresa_id = session('empresa');
            $dispositivo->user_id = auth()->user()->id;
        }
    }


    public function created(Dispositivos $dispositivos)
    {
        //
    }

    /**
     * Handle the Dispositivos "updated" event.
     *
     * @param  \App\Models\Dispositivos  $dispositivos
     * @return void
     */
    public function updated(Dispositivos $dispositivos)
    {
        //
    }

    /**
     * Handle the Dispositivos "deleted" event.
     *
     * @param  \App\Models\Dispositivos  $dispositivos
     * @return void
     */
    public function deleted(Dispositivos $dispositivos)
    {
        //
    }

    /**
     * Handle the Dispositivos "restored" event.
     *
     * @param  \App\Models\Dispositivos  $dispositivos
     * @return void
     */
    public function restored(Dispositivos $dispositivos)
    {
        //
    }

    /**
     * Handle the Dispositivos "force deleted" event.
     *
     * @param  \App\Models\Dispositivos  $dispositivos
     * @return void
     */
    public function forceDeleted(Dispositivos $dispositivos)
    {
        //
    }
}
