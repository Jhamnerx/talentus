<?php

namespace App\Observers;

use App\Models\Categoria;

class CategoriasObserver
{
    /**
     * Handle the Categoria "created" event.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return void
     */
    public function created(Categoria $categoria)
    {
        //
    }

    /**
     * Handle the Categoria "updated" event.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return void
     */
    public function updated(Categoria $categoria)
    {
        //
    }

    /**
     * Handle the Categoria "deleted" event.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return void
     */
    public function deleted(Categoria $categoria)
    {
        //
    }

    /**
     * Handle the Categoria "restored" event.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return void
     */
    public function restored(Categoria $categoria)
    {
        //
    }

    /**
     * Handle the Categoria "force deleted" event.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return void
     */
    public function forceDeleted(Categoria $categoria)
    {
        //
    }
}
