<?php

namespace App\Observers;

use App\Models\ChangesModels;
use App\Models\Productos;
use Haruncpi\LaravelIdGenerator\IdGenerator;
class ProductoObserver
{
    /**
     * Handle the Productos "created" event.
     *
     * @param  \App\Models\Productos  $producto
     * @return void
     */
    public function creating(Productos $producto)
    {
        if(! \App::runningInConsole()){

            $producto->empresa_id = session('empresa');
            $producto->codigo = IdGenerator::generate(['table' => 'productos','field'=>'codigo', 'length' => 9, 'prefix' => 'PROD-']);;

        }
    }    
    public function updating(Productos $producto)
    {
        if(! \App::runningInConsole()){

            $producto->empresa_id = session('empresa');
            //$producto->codigo = IdGenerator::generate(['table' => 'productos','field'=>'codigo', 'length' => 9, 'prefix' => 'PROD-']);;

        }
    }

    public function created(Productos $producto)
    {
        if(! \App::runningInConsole()){

           
            ChangesModels::create([
                'change_id' => $producto->getKey(),
                'change_type' => Productos::class,
                'type' => 'create',
                'user_id' => auth()->user()->id,
            ]);
        }
    }

    /**
     * Handle the Productos "updated" event.
     *
     * @param  \App\Models\Productos  $producto
     * @return void
     */
    public function updated(Productos $producto)
    {
       // dd($producto);
        ChangesModels::create([
            'change_id' => $producto->getKey(),
            'change_type' => Productos::class,
            'original' => json_encode($producto->getOriginal()),
            'changes' => json_encode($producto->getChanges()),
            'type' => 'update',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Productos "deleted" event.
     *
     * @param  \App\Models\Productos  $producto
     * @return void
     */
    public function deleted(Productos $producto)
    {
        dd($producto);
        ChangesModels::create([
            'change_id' => $producto->getKey(),
            'change_type' => Productos::class,
            'type' => 'delete',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Productos "restored" event.
     *
     * @param  \App\Models\Productos  $producto
     * @return void
     */
    public function restored(Productos $producto)
    {
        ChangesModels::create([
            'change_id' => $producto->getKey(),
            'change_type' => Productos::class,
            'type' => 'restore',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Productos "force deleted" event.
     *
     * @param  \App\Models\Productos  $producto
     * @return void
     */
    public function forceDeleted(Productos $producto)
    {
        //
    }
}
