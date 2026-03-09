<?php

use App\Jobs\CheckDetalleCobros;
use App\Jobs\CheckBirthdayContacts;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Jobs\checkMantenimientoVehiculos;
use Illuminate\Console\Scheduling\Schedule;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Jobs\checkRecordatorios as JobsCheckRecordatorios;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web', 'auth')->prefix('invoice')->group(base_path('routes/facturacion.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);
    })->withSchedule(function (Schedule $schedule) {
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('22:00');
        $schedule->job(new JobsCheckRecordatorios)->dailyAt('07:40');
        $schedule->job(new CheckDetalleCobros)->dailyAt('08:50');
        //$schedule->job(new CheckDetalleCobros)->everyMinute();
        $schedule->command('activitylog:clean')->daily();
        //$schedule->job(new checkMantenimientoVehiculos)->daily();
        $schedule->job(new CheckBirthdayContacts)->dailyAt('07:50');
        $schedule->command('telescope:prune')->daily();

        // Generar notificaciones de cobro diariamente a las 8:00 AM
        $schedule->job(new \App\Jobs\GenerarNotificacionesCobro(7))
            ->dailyAt('08:00')
            ->name('generar-notificaciones-cobro')
            ->withoutOverlapping()
            ->onSuccess(function () {
                info('✅ Notificaciones de cobro generadas exitosamente');
            })
            ->onFailure(function () {
                \Illuminate\Support\Facades\Log::error('❌ Error al generar notificaciones de cobro');
            });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
