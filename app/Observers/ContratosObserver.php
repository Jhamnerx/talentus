<?php

namespace App\Observers;

use App\Models\Contratos;
use Vinkla\Hashids\Facades\Hashids;
class ContratosObserver
{
    /**
     * Handle the Contratos "created" event.
     *
     * @param  \App\Models\Contratos  $contratos
     * @return void
     */
    public function created(Contratos $contrato)
    {
        if(! \App::runningInConsole()){

            $contrato->unique_hash = Hashids::connection(Contratos::class)->encode($contrato->id);
            $contrato->save();
            
            //EVENTO PARA ENVIAR EMAIL Y NOTIFICAR A ADMIN
            //nuevaActaCreada::dispatch($acta);

            //REGISTRAMOS EL CAMBIO REALIZADO EN DB

            // ChangesModels::create([
            //     'change_id' => $acta->getKey(),
            //     'change_type' => Actas::class,
            //     'type' => 'create',
            //     'user_id' => auth()->user()->id,
            // ]);

        }

    }
    public function creating(Contratos $contrato)
    {

        if(! \App::runningInConsole()){
           // dd($acta);
            $contrato->empresa_id = session('empresa');
            $contrato->user_id = auth()->user()->id;
            


        }
       
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
