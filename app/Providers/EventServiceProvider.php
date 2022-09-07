<?php

namespace App\Providers;

use App\Events\ClientesImportUpdated;
use App\Events\nuevaActaCreada;
use App\Events\nuevoCertificadoCreado;
use App\Events\nuevoCertificadoGpsCreado;
use App\Listeners\nuevaActaCreadaAdminsListener;
use App\Listeners\nuevaActaCreadaEmailListener;
use App\Listeners\nuevoCertificadoAdminsListener;
use App\Listeners\nuevoCertificadoEmailListener;
use App\Listeners\nuevoCertificadoGpsAdminsListener;
use App\Listeners\nuevoCertificadoGpsEmailListener;
use App\Models\Actas;
use App\Models\User;
use App\Observers\UserObserver;
use App\Models\Categoria;
use App\Models\Certificados;
use App\Models\CertificadosVelocimetros as ModelsCertificadosVelocimetros;
use App\Models\Clientes;
use App\Models\Contactos;
use App\Models\Contratos;
use App\Models\Dispositivos;
use App\Models\Facturas;
use App\Models\Flotas;
use App\Models\Lineas;
use App\Models\ModelosDispositivo;
use App\Models\Presupuestos;
use App\Models\Productos;
use App\Models\Recibos;
use App\Models\Reportes;
use App\Models\SimCard;
use App\Models\Vehiculos;
use App\Observers\ActaObserver;
use App\Observers\CategoriasObserver;
use App\Observers\CertificadosObserver;
use App\Observers\CertificadosVelocimetrosObserver;
use App\Observers\ClientesObserver;
use App\Observers\ContactosObserver;
use App\Observers\ContratosObserver;
use App\Observers\DispositivosObserver;
use App\Observers\FacturaObserver;
use App\Observers\FlotasObserver;
use App\Observers\LineasObserver;
use App\Observers\ModelosDispositivosObserver;
use App\Observers\PresupuestosObserver;
use App\Observers\ProductoObserver;
use App\Observers\ReciboObserver;
use App\Observers\ReportesObserver;
use App\Observers\SimCardObserver;
use App\Observers\VehiculosObserver;
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
        nuevaActaCreada::class => [nuevaActaCreadaEmailListener::class, nuevaActaCreadaAdminsListener::class],
        nuevoCertificadoCreado::class => [nuevoCertificadoEmailListener::class, nuevoCertificadoAdminsListener::class],
        nuevoCertificadoGpsCreado::class => [nuevoCertificadoGpsEmailListener::class, nuevoCertificadoGpsAdminsListener::class],
        ClientesImportUpdated::class => [],

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
        Actas::observe(ActaObserver::class);
        Contratos::observe(ContratosObserver::class);
        SimCard::observe(SimCardObserver::class);
        Lineas::observe(LineasObserver::class);
        Dispositivos::observe(DispositivosObserver::class);
        ModelosDispositivo::observe(ModelosDispositivosObserver::class);
        Clientes::observe(ClientesObserver::class);
        Contactos::observe(ContactosObserver::class);
        Flotas::observe(FlotasObserver::class);
        Vehiculos::observe(VehiculosObserver::class);
        Reportes::observe(ReportesObserver::class);
        Certificados::observe(CertificadosObserver::class);
        ModelsCertificadosVelocimetros::observe(CertificadosVelocimetrosObserver::class);
    }
}
