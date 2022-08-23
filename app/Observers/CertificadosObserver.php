<?php

namespace App\Observers;

use App\Events\nuevoCertificadoCreado;
use App\Models\Certificados;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\ChangesModels;
class CertificadosObserver
{
    /**
     * Handle the Certificados "created" event.
     *
     * @param  \App\Models\Certificados  $certificados
     * @return void
     */
    public function creating(Certificados $certificados)
    {

        if(! \App::runningInConsole()){
           // dd($certificados);
            $certificados->empresa_id = session('empresa');
            $certificados->user_id = auth()->user()->id;
            


        }
       
    }  

    public function updating(Certificados $certificados)
    {

        if(! \App::runningInConsole()){

            $certificados->empresa_id = session('empresa');

        }
       
    }

    public function created(Certificados $certificado)
    {
        if(! \App::runningInConsole()){



            $certificado->unique_hash = Hashids::connection(Certificados::class)->encode($certificado->id);
            $certificado->save();
            //EVENTO PARA ENVIAR EMAIL Y NOTIFICAR A ADMIN
            nuevoCertificadoCreado::dispatch($certificado);

            //REGISTRAMOS EL CAMBIO REALIZADO EN DB

            ChangesModels::create([
                'change_id' => $certificado->getKey(),
                'change_type' => Certificados::class,
                'type' => 'create',
                'user_id' => auth()->user()->id,
            ]);

        }
    }

    /**
     * Handle the Certificados "updated" event.
     *
     * @param  \App\Models\Certificados  $certificados
     * @return void
     */
    public function updated(Certificados $certificados)
    {
        ChangesModels::create([
            'change_id' => $certificados->getKey(),
            'change_type' => Certificados::class,
            'original' => json_encode($certificados->getOriginal()),
            'changes' => json_encode($certificados->getChanges()),
            'type' => 'update',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Certificados "deleted" event.
     *
     * @param  \App\Models\Certificados  $certificados
     * @return void
     */
    public function deleted(Certificados $certificados)
    {
        ChangesModels::create([
            'change_id' => $certificados->getKey(),
            'change_type' => Certificados::class,
            'type' => 'delete',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Certificados "restored" event.
     *
     * @param  \App\Models\Certificados  $certificados
     * @return void
     */
    public function restored(Certificados $certificados)
    {
        ChangesModels::create([
            'change_id' => $certificados->getKey(),
            'change_type' => Certificados::class,
            'type' => 'restored',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the Certificados "force deleted" event.
     *
     * @param  \App\Models\Certificados  $certificados
     * @return void
     */
    public function forceDeleted(Certificados $certificados)
    {
        ChangesModels::create([
            'change_id' => $certificados->getKey(),
            'change_type' => Certificados::class,
            'type' => 'forceDeleted',
            'user_id' => auth()->user()->id,
        ]);
    }
}
