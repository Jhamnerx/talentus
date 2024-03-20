<?php

namespace App\Observers;

use App\Models\GuiaRemision;

class GuiaRemisionObserver
{

    public function creating(GuiaRemision $guiaRemision)
    {

        if (!\App::runningInConsole()) {
            $guiaRemision->empresa_id = session('empresa');
            $guiaRemision->user_id = auth()->user()->id;
        }
    }
    public function created(GuiaRemision $guiaRemision)
    {
        //
    }


    public function updated(GuiaRemision $guiaRemision)
    {
        //
    }

    public function deleted(GuiaRemision $guiaRemision)
    {
        //
    }

    public function restored(GuiaRemision $guiaRemision)
    {
        //
    }


    public function forceDeleted(GuiaRemision $guiaRemision)
    {
        //
    }
}
