<?php

namespace App\Jobs;

use App\Models\Contactos;
use App\Models\User;
use App\Notifications\Birthday\NotifyAdmin;
use App\Scopes\EmpresaScope;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CheckBirthdayContacts implements ShouldQueue
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
        $contactos = Contactos::where('birthday', 'LIKE', Carbon::today()->format('d/m') . '%')->withoutGlobalScope(EmpresaScope::class)->get();

        $today = Carbon::today()->format('Y-m');

        foreach ($contactos as $key => $contacto) {

            $birthday = Carbon::createFromFormat('d/m/Y', $contacto->birthday)->format('Y-m');

            if ($today === $birthday) {

                return $contacto->notifyContactBirthday();
            }
        }
    }
}
