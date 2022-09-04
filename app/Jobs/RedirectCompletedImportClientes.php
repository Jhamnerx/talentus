<?php

namespace App\Jobs;

use App\Events\ClientesImportUpdated;
use App\Http\Controllers\Admin\ClientesController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RedirectCompletedImportClientes implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $user;
    public function __construct($user)
    {
        //
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
        ClientesImportUpdated::dispatch($this->user);
       
        //redirect()->action([ClientesController::class, 'index'])->with('flash.banner', 'Clientes importados correctamente');
        //redirect()->route('admin.clientes.index')->with('flash.bannerStyle', 'success');
    }
}
