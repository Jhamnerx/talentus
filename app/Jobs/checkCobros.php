<?php

namespace App\Jobs;

use App\Models\Admin\Mensaje;
use App\Models\Cobros;
use App\Notifications\EnviarMensajeCobro;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class checkCobros implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $cobros = Cobros::all();


        foreach ($cobros as $cobro) {

            if (Carbon::now()->diffInDays($cobro->fecha_vencimiento) <= 3 && Carbon::now()->diffInDays($cobro->fecha_vencimiento) > 1) {

                $cobro->vencido = 0;
                $cobro->verificado = 1;
                $cobro->save();
              //  Log::alert($cobro->id." por vencer");


                $data = array(
                    'body' => 'Cobro por vencer',
                    'asunto' => 'NOTIFICACION DE COBRO',
                    'accion' => 'notification_cobro',
                );

                $mensaje = new Mensaje();
                $mensaje->sendCobroMessage($data, $cobro);
            }

            if (Carbon::now()->diffInDays($cobro->fecha_vencimiento) <= 0) {

                $cobro->vencido = 1;
                $cobro->verificado = 1;
                $cobro->save();
                Log::alert($cobro->id." vencido");

            }
            
        }
        //dd($cobros);
    }
}
