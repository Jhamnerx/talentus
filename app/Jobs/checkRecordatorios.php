<?php

namespace App\Jobs;

use App\Models\Admin\Recordatorios;
use App\Models\User;
use App\Notifications\CrearRecordatorio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class checkRecordatorios implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        
        $recordatorios = Recordatorios::all();
      

        foreach ($recordatorios as $recordatorio) {
       
            if ($recordatorio->fecha == date('Y-m-d')) {
              // Log::alert('enviar notificacion');
               // dd($recordatorio);
                $recordatorio->user->notify(new CrearRecordatorio($recordatorio));
                $recordatorio->delete();
                //$recordatorio->user->notify(new CrearRecordatorio($recordatorio));
            }else{
                
            }
        }

    }
}
