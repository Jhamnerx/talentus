<?php

namespace App\Observers;

use App\Models\Categoria;
use App\Models\ChangesModels;

class CategoriasObserver
{
    /**
     * Handle the Categoria "created" event.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return void
     */
    public function creating(Categoria $categoria)
    {

        if(! \App::runningInConsole()){

            $categoria->empresa_id = session('empresa');

        }
       
    }   
     public function updating(Categoria $categoria)
    {

        if(! \App::runningInConsole()){

            $categoria->empresa_id = session('empresa');

        }
       
    }
    public function created(Categoria $categoria)
    {
        
        if(! \App::runningInConsole()){

           
            ChangesModels::create([
                'change_id' => $categoria->getKey(),
                'change_type' => Categoria::class,
                'type' => 'create',
                'user_id' => auth()->user()->id,
            ]);
        }
       
    }

    /**
     * Handle the Categoria "updated" event.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return void
     */
    public function updated(Categoria $categoria)
    {
        ChangesModels::create([
            'change_id' => $categoria->getKey(),
            'change_type' => Categoria::class,
            'original' => json_encode($categoria->getOriginal()),
            'changes' => json_encode($categoria->getChanges()),
            'type' => 'update',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Categoria "deleted" event.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return void
     */
    public function deleted(Categoria $categoria)
    {
        ChangesModels::create([
            'change_id' => $categoria->getKey(),
            'change_type' => Categoria::class,
            'type' => 'delete',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Categoria "restored" event.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return void
     */
    public function restored(Categoria $categoria)
    {
        ChangesModels::create([
            'change_id' => $categoria->getKey(),
            'change_type' => Categoria::class,
            'type' => 'restored',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Categoria "force deleted" event.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return void
     */
    public function forceDeleted(Categoria $categoria)
    {
        ChangesModels::create([
            'change_id' => $categoria->getKey(),
            'change_type' => Categoria::class,
            'type' => 'forceDeleted',
            'user_id' => auth()->user()->id,
        ]);
    }
}
