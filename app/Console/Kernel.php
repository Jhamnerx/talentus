<?php

namespace App\Console;

use App\Console\Commands\CheckRecordatorios;
use App\Jobs\checkCobros;
use App\Jobs\checkRecordatorios as JobsCheckRecordatorios;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        //  $schedule->call(new CheckRecordatorios)->daily();
        // $schedule->job(new JobsCheckRecordatorios)->everyFiveMinutes();
        $schedule->job(new JobsCheckRecordatorios)->everyMinute();
        //$schedule->job(new JobsCheckRecordatorios)->dailyAt('08:40');
        // $schedule->job(new checkCobros)->daily();
        //$schedule->job(new checkCobros)->everyMinute(1);
        // $schedule->job(new checkCobros)->everyFiveMinutes();
        $schedule->job(new checkCobros)->dailyAt('08:50');
        $schedule->command('activitylog:clean')->weekly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
