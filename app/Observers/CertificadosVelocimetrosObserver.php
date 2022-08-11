<?php

namespace App\Observers;

use App\Models\CertificadosVelocimetros;
use Vinkla\Hashids\Facades\Hashids;
use App\Models\ChangesModels;
class CertificadosVelocimetrosObserver
{
    /**
     * Handle the CertificadosVelocimetros "created" event.
     *
     * @param  \App\Models\CertificadosVelocimetros  $certificados
     * @return void
     */
    public function creating(CertificadosVelocimetros $certificados)
    {

        if(! \App::runningInConsole()){
           // dd($certificados);
            $certificados->empresa_id = session('empresa');
            $certificados->user_id = auth()->user()->id;
            


        }
       
    } 
    public function updating(CertificadosVelocimetros $certificados)
    {

        if(! \App::runningInConsole()){

            $certificados->empresa_id = session('empresa');

        }
       
    }
    public function created(CertificadosVelocimetros $certificados)
    {
        if(! \App::runningInConsole()){

            $data = array(
                'body' => 'Se ha creado un certificado',
                'asunto' => 'CERTIFICADO CREADO',
                'accion' => 'certificado_created',
                'from_user_id' => auth()->id(),
            );

            $certificados->unique_hash = Hashids::connection(CertificadosVelocimetros::class)->encode($certificados->id);
            $certificados->save();

            ChangesModels::create([
                'change_id' => $certificados->getKey(),
                'change_type' => CertificadosVelocimetros::class,
                'type' => 'create',
                'user_id' => auth()->user()->id,
            ]);

        }
    }

    /**
     * Handle the CertificadosVelocimetros "updated" event.
     *
     * @param  \App\Models\CertificadosVelocimetros  $certificados
     * @return void
     */
    public function updated(CertificadosVelocimetros $certificados)
    {
        ChangesModels::create([
            'change_id' => $certificados->getKey(),
            'change_type' => CertificadosVelocimetros::class,
            'original' => json_encode($certificados->getOriginal()),
            'changes' => json_encode($certificados->getChanges()),
            'type' => 'update',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the CertificadosVelocimetros "deleted" event.
     *
     * @param  \App\Models\CertificadosVelocimetros  $certificados
     * @return void
     */
    public function deleted(CertificadosVelocimetros $certificados)
    {
        ChangesModels::create([
            'change_id' => $certificados->getKey(),
            'change_type' => CertificadosVelocimetros::class,
            'type' => 'delete',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the CertificadosVelocimetros "restored" event.
     *
     * @param  \App\Models\CertificadosVelocimetros  $certificados
     * @return void
     */
    public function restored(CertificadosVelocimetros $certificados)
    {
        ChangesModels::create([
            'change_id' => $certificados->getKey(),
            'change_type' => CertificadosVelocimetros::class,
            'type' => 'restored',
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * Handle the CertificadosVelocimetros "force deleted" event.
     *
     * @param  \App\Models\CertificadosVelocimetros  $certificados
     * @return void
     */
    public function forceDeleted(CertificadosVelocimetros $certificados)
    {
        ChangesModels::create([
            'change_id' => $certificados->getKey(),
            'change_type' => CertificadosVelocimetros::class,
            'type' => 'forceDeleted',
            'user_id' => auth()->user()->id,
        ]);
    }
}
