<?php

namespace App\Observers;

use App\Events\nuevaActaCreada;
use App\Models\Actas;
use App\Models\Admin\Mensaje;
use App\Models\ChangesModels;
use App\Notifications\ActaCreada;
use Vinkla\Hashids\Facades\Hashids;

class ActaObserver
{
    /**
     * Handle the Actas "created" event.
     *
     * @param  \App\Models\Actas  $actas
     * @return void
     */
    public function creating(Actas $acta)
    {

        if(! \App::runningInConsole()){
           // dd($acta);
            $acta->empresa_id = session('empresa');
            $acta->user_id = auth()->user()->id;
            


        }
       
    }   
     public function updating(Actas $acta)
    {

        if(! \App::runningInConsole()){

            $acta->empresa_id = session('empresa');

        }
       
    }
    public function created(Actas $acta)
    {
        if(! \App::runningInConsole()){


            $acta->unique_hash = Hashids::connection(Actas::class)->encode($acta->id);
            $acta->save();
            
            //EVENTO PARA ENVIAR EMAIL Y NOTIFICAR A ADMIN
            nuevaActaCreada::dispatch($acta);


            //REGISTRAMOS EL CAMBIO REALIZADO EN DB

            ChangesModels::create([
                'change_id' => $acta->getKey(),
                'change_type' => Actas::class,
                'type' => 'create',
                'user_id' => auth()->user()->id,
            ]);

        }

    }

    /**
     * Handle the Actas "updated" event.
     *
     * @param  \App\Models\Actas  $actas
     * @return void
     */
    public function updated(Actas $actas)
    {
        ChangesModels::create([
            'change_id' => $actas->getKey(),
            'change_type' => Actas::class,
            'original' => json_encode($actas->getOriginal()),
            'changes' => json_encode($actas->getChanges()),
            'type' => 'update',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Actas "deleted" event.
     *
     * @param  \App\Models\Actas  $actas
     * @return void
     */
    public function deleted(Actas $actas)
    {
        ChangesModels::create([
            'change_id' => $actas->getKey(),
            'change_type' => Actas::class,
            'type' => 'delete',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Actas "restored" event.
     *
     * @param  \App\Models\Actas  $actas
     * @return void
     */
    public function restored(Actas $actas)
    {
        ChangesModels::create([
            'change_id' => $actas->getKey(),
            'change_type' => Actas::class,
            'type' => 'restored',
            'user_id' => auth()->user()->id,
        ]);

    }

    /**
     * Handle the Actas "force deleted" event.
     *
     * @param  \App\Models\Actas  $actas
     * @return void
     */
    public function forceDeleted(Actas $actas)
    {
        ChangesModels::create([
            'change_id' => $actas->getKey(),
            'change_type' => Actas::class,
            'type' => 'forceDeleted',
            'user_id' => auth()->user()->id,
        ]);
    }
}
