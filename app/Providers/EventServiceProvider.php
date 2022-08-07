<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Models\Categoria;
use App\Models\Facturas;
use App\Models\Presupuestos;
use App\Models\Productos;
use App\Models\Recibos;
use App\Observers\CategoriasObserver;
use App\Observers\FacturaObserver;
use App\Observers\PresupuestosObserver;
use App\Observers\ProductoObserver;
use App\Observers\ReciboObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Categoria::observe(CategoriasObserver::class);
        Productos::observe(ProductoObserver::class);
        Presupuestos::observe(PresupuestosObserver::class);
        Facturas::observe(FacturaObserver::class);
        Recibos::observe(ReciboObserver::class);
    }
}
