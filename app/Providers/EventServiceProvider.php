<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Actas;
use App\Models\Cobros;
use App\Models\Flotas;
use App\Models\Lineas;
use App\Models\Tareas;
use App\Models\Ventas;
use App\Models\Recibos;
use App\Models\SimCard;
use App\Models\Clientes;
use App\Models\Facturas;
use App\Models\Payments;
use App\Models\Reportes;
use App\Models\Categoria;
use App\Models\Contactos;
use App\Models\Contratos;
use App\Models\Productos;
use App\Models\Vehiculos;
use App\Models\NotaDebito;
use App\Models\NotaCredito;
use App\Models\Certificados;
use App\Models\Dispositivos;
use App\Models\GuiaRemision;
use App\Models\Presupuestos;
use App\Models\Mantenimiento;
use App\Events\nuevaActaCreada;
use App\Models\ComprasFacturas;
use App\Observers\ActaObserver;
use App\Observers\UserObserver;
use App\Observers\CobrosObserver;
use App\Observers\FlotasObserver;
use App\Observers\LineasObserver;
use App\Observers\ReciboObserver;
use App\Observers\TareasObserver;
use App\Observers\VentasObserver;
use App\Models\ModelosDispositivo;
use App\Models\RecibosPagosVarios;
use App\Observers\FacturaObserver;
use App\Observers\SimCardObserver;
use App\Observers\ClientesObserver;
use App\Observers\PaymentsObserver;
use App\Observers\ProductoObserver;
use App\Observers\ReportesObserver;
use App\Observers\ContactosObserver;
use App\Observers\ContratosObserver;
use App\Observers\VehiculosObserver;
use App\Events\ClientesImportUpdated;
use App\Observers\CategoriasObserver;
use App\Observers\NotaDebitoObserver;
use Illuminate\Support\Facades\Event;
use App\Events\Facturacion\EmitirGuia;
use App\Events\Facturacion\EmitirNota;
use App\Events\nuevoCertificadoCreado;
use App\Observers\NotaCreditoObserver;
use Illuminate\Auth\Events\Registered;
use App\Observers\CertificadosObserver;
use App\Observers\DispositivosObserver;
use App\Observers\GuiaRemisionObserver;
use App\Observers\PresupuestosObserver;
use App\Observers\RecibosPagosObserver;
use App\Observers\MantenimientoObserver;
use App\Events\nuevoCertificadoGpsCreado;
use App\Listeners\Facturacion\UpdateGuia;
use App\Listeners\Facturacion\UpdateNota;
use App\Observers\ComprasFacturasObserver;
use App\Events\Facturacion\EmitirComprobante;
use App\Observers\ModelosDispositivosObserver;
use App\Listeners\nuevaActaCreadaEmailListener;
use App\Listeners\Facturacion\UpdateComprobante;
use App\Listeners\nuevaActaCreadaAdminsListener;
use App\Listeners\nuevoCertificadoEmailListener;
use App\Listeners\nuevoCertificadoAdminsListener;
use App\Listeners\nuevoCertificadoGpsEmailListener;
use App\Observers\CertificadosVelocimetrosObserver;
use App\Listeners\nuevoCertificadoGpsAdminsListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Models\CertificadosVelocimetros as ModelsCertificadosVelocimetros;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        nuevaActaCreada::class => [nuevaActaCreadaEmailListener::class, nuevaActaCreadaAdminsListener::class],
        nuevoCertificadoCreado::class => [nuevoCertificadoEmailListener::class, nuevoCertificadoAdminsListener::class],
        nuevoCertificadoGpsCreado::class => [nuevoCertificadoGpsEmailListener::class, nuevoCertificadoGpsAdminsListener::class],
        ClientesImportUpdated::class => [],
        EmitirComprobante::class => [
            UpdateComprobante::class,
        ],
        EmitirNota::class => [
            UpdateNota::class,
        ],
        EmitirGuia::class => [
            UpdateGuia::class,
        ],
    ];

    public function boot()
    {
        User::observe(UserObserver::class);
        Categoria::observe(CategoriasObserver::class);
        Productos::observe(ProductoObserver::class);
        Presupuestos::observe(PresupuestosObserver::class);
        ComprasFacturas::observe(ComprasFacturasObserver::class);
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
        Payments::observe(PaymentsObserver::class);
        Cobros::observe(CobrosObserver::class);
        GuiaRemision::observe(GuiaRemisionObserver::class);
        Tareas::observe(TareasObserver::class);
        RecibosPagosVarios::observe(RecibosPagosObserver::class);
        Mantenimiento::observe(MantenimientoObserver::class);
        Ventas::observe(VentasObserver::class);
        NotaCredito::observe(NotaCreditoObserver::class);
        NotaDebito::observe(NotaDebitoObserver::class);
    }
}
