<?php

namespace App\Jobs;

use App\Models\Admin\Recordatorios;
use App\Models\User;
use App\Notifications\CrearRecordatorio;
use Carbon\Carbon;
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
        $recordatorios = Recordatorios::whereDate('fecha', Carbon::now()->format('Y-m-d'))->get();
      
        foreach ($recordatorios as $recordatorio) {
       
            // Log::alert('enviar notificacion');
           // dd($recordatorio);
            $recordatorio->user->notify(new CrearRecordatorio($recordatorio));
            // $recordatorio->delete();
                //$recordatorio->user->notify(new CrearRecordatorio($recordatorio));

        }

    }
}
