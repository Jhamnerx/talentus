<?php

namespace App\Observers;

use App\Models\Contratos;

class ContratosObserver
{
    /**
     * Handle the Contratos "created" event.
     *
     * @param  \App\Models\Contratos  $contratos
     * @return void
     */
    public function created(Contratos $contratos)
    {
        //
    }

    /**
     * Handle the Contratos "updated" event.
     *
     * @param  \App\Models\Contratos  $contratos
     * @return void
     */
    public function updated(Contratos $contratos)
    {
        //
    }

    /**
     * Handle the Contratos "deleted" event.
     *
     * @param  \App\Models\Contratos  $contratos
     * @return void
     */
    public function deleted(Contratos $contratos)
    {
        //
    }

    /**
     * Handle the Contratos "restored" event.
     *
     * @param  \App\Models\Contratos  $contratos
     * @return void
     */
    public function restored(Contratos $contratos)
    {
        //
    }

    /**
     * Handle the Contratos "force deleted" event.
     *
     * @param  \App\Models\Contratos  $contratos
     * @return void
     */
    public function forceDeleted(Contratos $contratos)
    {
        //
    }
}
