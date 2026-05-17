<?php

use App\Http\Controllers\Admin\ActasController;
use App\Http\Controllers\Admin\AjustesController;
use App\Http\Controllers\Admin\Almacen\GuiaRemisionController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\CertificadosGpsController;
use App\Http\Controllers\Admin\CertificadosVelocimetrosController;
use App\Http\Controllers\Admin\ClientesController;
use App\Http\Controllers\Admin\CobrosController;
use App\Http\Controllers\Admin\ComprasController;
use App\Http\Controllers\Admin\ContactosController;
use App\Http\Controllers\Admin\ContratosController;
use App\Http\Controllers\Admin\Facturacion\ComprobantesController;
use App\Http\Controllers\Admin\Finanzas\FinanzasController;
use App\Http\Controllers\Admin\FlotasController;
use App\Http\Controllers\Admin\GpsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LineasController;
use App\Http\Controllers\Admin\MantenimientoController;
use App\Http\Controllers\Admin\MensajeController;
use App\Http\Controllers\Admin\NotificacionesController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\PlanesController;
use App\Http\Controllers\Admin\PDF\ActaPdfController;
use App\Http\Controllers\Admin\PDF\CajaChicaPdfController;
use App\Http\Controllers\Admin\PDF\CertificadoAntifatigaPdfController;
use App\Http\Controllers\Admin\PDF\CertificadoPdfController;
use App\Http\Controllers\Admin\PDF\CertificadoVelocimetroPdfController;
use App\Http\Controllers\Admin\PDF\ContratoPdfController;
use App\Http\Controllers\Admin\PDF\FacturaPdfController;
use App\Http\Controllers\Admin\PDF\PresupuestoPdfController;
use App\Http\Controllers\Admin\PDF\ReciboPagoPdfController;
use App\Http\Controllers\Admin\PDF\ReciboPdfController;
use App\Http\Controllers\Admin\PDF\TareaPdfController;
use App\Http\Controllers\Admin\PDF\WorkOrderPdfController;
use App\Http\Controllers\Admin\PresupuestoController;
use App\Http\Controllers\Admin\ProductosController;
use App\Http\Controllers\Admin\ProveedoresController;
use App\Http\Controllers\Admin\RecibosController;
use App\Http\Controllers\Admin\RecibosPagosVariosController;
use App\Http\Controllers\Admin\ReportesController;
use App\Http\Controllers\Admin\ReportesGerenciales;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\ServicioTecnicoController;
use App\Http\Controllers\Admin\SimCardController;
use App\Http\Controllers\Admin\SolicitudesController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VehiculosController;
use App\Http\Controllers\Admin\VentasFacturasController;
use App\Http\Controllers\Admin\WorkOrderController;
use App\Http\Controllers\Api\SelectsController;
use App\Http\Controllers\CertificadosAntifatigaController;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('admin.home');
    Route::get('dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('dashboard/chart-ventas', [HomeController::class, 'getChartVentas'])->name('admin.dashboard.chart-ventas');
    Route::get('dashboard/chart-facturadas', [HomeController::class, 'getChartFacturadas'])->name('admin.dashboard.chart-facturadas');

    // ==================== FINANZAS ====================
    Route::controller(FinanzasController::class)->prefix('finanzas')->name('finanzas.')->group(function () {
        Route::get('caja-chica', 'cajaChica')->name('caja-chica.index')->middleware('can:ver-finanzas-caja');
        Route::get('movimientos', 'movimientos')->name('movimientos.index')->middleware('can:ver-finanzas-movimientos');
        Route::get('transacciones', 'transacciones')->name('transacciones.index')->middleware('can:ver-finanzas-transacciones');
        Route::get('cuentas-cobrar', 'cuentasCobrar')->name('cuentas-cobrar.index')->middleware('can:ver-finanzas-cuentas-cobrar');
        Route::get('cuentas-pagar', 'cuentasPagar')->name('cuentas-pagar.index')->middleware('can:ver-finanzas-cuentas-pagar');
        Route::get('balance', 'balance')->name('balance.index')->middleware('can:ver-finanzas-balance');
    });

    // Reportes de Caja Chica (igual que FactuPRO)
    Route::controller(CajaChicaPdfController::class)->prefix('finanzas/caja-chica')->name('finanzas.caja-chica.')->group(function () {
        // Dropdown "Reporte"
        Route::get('{caja}/reporte-a4', 'reportA4')->name('reporte-a4');
        Route::get('{caja}/reporte-ticket/{width?}', 'reportTicket')->name('reporte-ticket');
        Route::get('{caja}/reporte-ticket-resumen', 'reportTicketResumen')->name('reporte-ticket-resumen');
        Route::get('{caja}/reporte-simple-a4', 'reportSimpleA4')->name('reporte-simple-a4');
        Route::get('{caja}/reporte-excel', 'reportExcel')->name('reporte-excel');
        Route::get('{caja}/reporte-operaciones', 'reportSummaryDailyOperations')->name('reporte-operaciones');

        // Dropdown "Reporte Efectivo"
        Route::get('{caja}/efectivo-excel', 'reportCashPaymentExcel')->name('efectivo-excel');
        Route::get('{caja}/ingresos-egresos', 'reportIncomeEgress')->name('ingresos-egresos');
        Route::get('{caja}/pagos-asociados', 'reportPaymentsAssociated')->name('pagos-asociados');

        // Dropdown "Reporte Productos"
        Route::get('{caja}/productos-pdf', 'reportProductsPdf')->name('productos-pdf');
        Route::get('{caja}/productos-excel', 'reportProductsExcel')->name('productos-excel');

        // Reporte General
        Route::get('reporte-general', 'reportGeneral')->name('reporte-general');
    });

    // ALMACEN
    Route::controller(CategoriaController::class)->group(function () {
        Route::get('categorias', 'index')->name('admin.almacen.categorias.index');
    });

    Route::controller(ProductosController::class)->group(function () {
        Route::get('productos', 'index')->name('admin.almacen.productos.index');
        Route::get('servicios', 'servicios')->name('admin.almacen.servicios.index');
    });


    Route::controller(SimCardController::class)->group(function () {

        Route::get('sim-card', 'index')->name('admin.almacen.sim-card.index');
    });


    Route::controller(LineasController::class)->group(function () {
        //lineas
        Route::get('lineas', 'index')->name('admin.almacen.lineas.index');
        Route::get('lineas-y-sim-card', 'indexCombinado')->name('admin.almacen.lineas-sim-card.index');
    });

    Route::controller(GpsController::class)->group(function () {
        Route::get('dispositivos', 'index')->name('admin.almacen.dispositivos.index');
        Route::get('modelos/dispositivos', 'showModels')->name('admin.almacen.modelos-dispositivos');
    });


    Route::controller(GuiaRemisionController::class)->group(function () {
        Route::get('guias', 'index')->name('admin.almacen.guias.index');
        Route::get('guias/crear', 'create')->name('admin.almacen.guias.create');
        Route::get('guias/{guia}/editar', 'edit')->name('admin.almacen.guias.edit');
    });

    //Route::resource('clientes', ClientesController::class)->names('admin.clientes');

    Route::controller(ClientesController::class)->group(function () {

        Route::get('clientes', 'index')->name('admin.clientes.index');
        // Route::post('clientes', 'store')->name('admin.clientes.store');
        //Route::get('clientes/crear', 'create')->name('admin.clientes.create');
        //Route::get('clientes/{cliente}', 'show')->name('admin.clientes.show');
        // Route::put('clientes/{cliente}', 'update')->name('admin.clientes.updated');
        //Route::get('clientes/{cliente}/editar', 'edit')->name('admin.clientes.edit');
    });

    Route::controller(ContactosController::class)->group(function () {
        Route::get('contactos', 'index')->name('admin.clientes.contactos.index');
    });

    // PAGOS (Mantener por compatibilidad pero redireccionar)
    Route::controller(PaymentsController::class)->group(function () {
        Route::get('pagos', 'index')->name('admin.payments.index');
        Route::get('pagos/metodos-pago', 'metodosPago')->name('admin.payments.metodos-pago');
    });

    // COBROS (dentro del módulo de pagos)
    Route::controller(CobrosController::class)->group(function () {
        Route::get('cobros/crear', 'create')->name('admin.cobros.create');
        Route::get('cobros', 'index')->name('admin.cobros.index');
        Route::get('cobros-notificaciones', 'notificaciones')->name('admin.cobros.notificaciones');
        Route::get('cobros/{cobro}/editar', 'edit')->name('admin.cobros.edit');
    });

    // PLANES DE SERVICIO
    Route::controller(PlanesController::class)->group(function () {
        Route::get('planes', 'index')->name('admin.planes.index');
    });

    // Mensajes de Contacto Web
    Route::get('mensajes-contacto', function () {
        return view('admin.contactos.index');
    })->name('admin.contactos.index');


    Route::controller(ProveedoresController::class)->group(function () {
        Route::get('proveedor', 'index')->name('admin.proveedores.index');
    });

    // COMPRAS

    Route::controller(ComprasController::class)->middleware(['auth'])->group(function () {

        Route::get('compras', 'index')->name('admin.compras.index');
        Route::get('compras/registrar', 'create')->name('admin.compras.create');
        Route::get('compras/editar/{compra}', 'editar')->name('admin.compras.edit');
    });


    // VENTAS PRESUPUESTOS
    Route::controller(PresupuestoController::class)->group(function () {
        Route::get('presupuestos', 'index')->name('admin.ventas.presupuestos.index');
        Route::get('presupuestos/crear', 'create')->name('admin.ventas.presupuestos.create');
        Route::get('presupuestos/{presupuesto}/editar', 'edit')->name('admin.ventas.presupuestos.edit');
    });



    Route::controller(VentasFacturasController::class)->group(function () {

        Route::get('ventas-facturas', 'index')->name('admin.ventas.facturas.index');
        Route::get('ventas-facturas/crear', 'create')->name('admin.ventas.facturas.create');
        Route::get('ventas-facturas/{factura}', 'show')->name('admin.ventas.facturas.show');
        Route::get('ventas-facturas/{factura}/editar', 'edit')->name('admin.ventas.facturas.edit');
    });


    Route::controller(RecibosController::class)->group(function () {
        Route::get('recibos', 'index')->name('admin.ventas.recibos.index');
        Route::get('recibos/crear/{notificacion_ids?}', 'create')->name('admin.ventas.recibos.create');
        Route::get('recibos/{recibo}/editar', 'edit')->name('admin.ventas.recibos.edit');
    });


    Route::controller(RecibosPagosVariosController::class)->group(function () {

        Route::get('recibos-pagos', 'index')->name('admin.gerencia.recibos.index');
        Route::get('recibos-pagos/crear', 'create')->name('admin.gerencia.recibos.create');
        Route::get('recibos-pagos/{recibo}/editar', 'edit')->name('admin.gerencia.recibos.edit');
    });

    //Route::resource('contratos', ContratosController::class)->names('admin.ventas.contratos');


    Route::controller(ContratosController::class)->group(function () {

        Route::get('contratos/crear', 'create')->name('admin.ventas.contratos.create');
        Route::get('contratos', 'index')->name('admin.ventas.contratos.index');
        // Route::get('contratos/{contrato}', 'show')->name('admin.ventas.contratos.show');
        Route::get('contratos/{contrato}/editar', 'edit')->name('admin.ventas.contratos.edit');
    });

    // VEHICULOS
    Route::controller(FlotasController::class)->group(function () {

        Route::get('flotas', 'index')->name('admin.vehiculos.flotas.index');
    });

    Route::controller(VehiculosController::class)->group(function () {

        Route::get('vehiculos', 'index')->name('admin.vehiculos.index');
        Route::get('vehiculos/{vehiculo}', 'show')->name('admin.vehiculos.show');
    });


    Route::controller(MantenimientoController::class)->group(function () {
        Route::get('mantenimiento', 'index')->name('admin.vehiculos.mantenimiento.index');
    });



    Route::controller(ReportesController::class)->group(function () {

        Route::get('reportes', 'index')->name('admin.vehiculos.reportes.index');
        Route::get('reportes/{reporte}', 'show')->name('admin.vehiculos.reportes.show');
    });


    // CERTIFICADOS

    Route::controller(ActasController::class)->group(function () {

        Route::get('actas', 'index')->name('admin.certificados.actas.index');
    });


    Route::resource('certificados-gps', CertificadosGpsController::class)->names('admin.certificados.gps')->parameters([
        'certificados-gps' => 'certificado'
    ]);

    Route::resource('certificados-velocimetros', CertificadosVelocimetrosController::class)->names('admin.certificados.velocimetros')->parameters([
        'certificados-velocimetros' => 'certificado'
    ]);

    Route::resource('certificados-antifatiga', CertificadosAntifatigaController::class)->names('admin.certificados.antifatiga')->parameters([
        'certificados-antifatiga' => 'certificado'
    ]);


    //ADMINISTRACION

    Route::resource('usuarios', UsersController::class)->names('admin.users')->parameters([
        'usuarios' => 'user'
    ]);

    Route::get('ajustes/cuenta', [AjustesController::class, 'cuenta'])->name('admin.ajustes.cuenta');
    Route::get('ajustes/ciudades', [AjustesController::class, 'ciudades'])->name('admin.ajustes.ciudades');
    Route::get('ajustes/operadores', [AjustesController::class, 'operadores'])->name('admin.ajustes.operadores');
    Route::get('ajustes/notificaciones', [AjustesController::class, 'notificaciones'])->name('admin.ajustes.notificaciones');
    Route::get('ajustes/roles', [AjustesController::class, 'roles'])->name('admin.ajustes.roles');
    Route::get('ajustes/series', [AjustesController::class, 'series'])->name('admin.ajustes.series');
    Route::get('ajustes/plantilla', [AjustesController::class, 'plantilla'])->name('admin.ajustes.plantilla');
    Route::get('ajustes/sunat', [AjustesController::class, 'sunat'])->name('admin.ajustes.sunat');

    // Banking module routes
    Route::view('ajustes/bancos', 'admin.ajustes.bancos')->name('admin.ajustes.bancos');
    Route::view('ajustes/cuentas-bancarias', 'admin.ajustes.cuentas-bancarias')->name('admin.ajustes.cuentas-bancarias');

    //Route::resource('ajustes/plantilla', RolController::class)->names('admin.ajustes.roles');
    Route::post('ajustes/roles/store', [RolController::class, 'store'])->name('admin.ajustes.roles.store');


    Route::controller(ServicioTecnicoController::class)->prefix('tecnico')->group(function () {

        Route::get('tareas', 'index')->name('admin.tecnico.tareas.index');
        Route::get('index', 'tecnicos')->name('admin.tecnico.tecnico.index');
    });


    // Todas las consultas de SUNAT/Factiliza ahora se realizan directamente desde los componentes Livewire
    // usando el servicio FactilizaService: (new FactilizaService())->consultarDni() / consultarRuc() / consultarPlaca()
    // Ver: app/Livewire/Admin/Clientes/Save.php y Edit.php


    // VERIFICAR


    //EXPORTACION RUTAS
    Route::get('export/lineas', [LineasController::class, 'exportExcel'])->name('admin.export.lineas');
    Route::get('export/dispositivos', [GpsController::class, 'exportExcel'])->name('admin.export.dispositivos');
    Route::get('export/clientes', [ClientesController::class, 'exportExcel'])->name('admin.export.clientes');
    Route::get('export/proveedores', [ProveedoresController::class, 'exportExcel'])->name('admin.export.proveedores');
    Route::get('export/vehiculos', [VehiculosController::class, 'exportExcel'])->name('admin.export.vehiculos');



    // PDF
    // ----------------------------------------------

    //  acta pdf
    // -------------------------------------------------
    Route::get('pdf/actas/{acta}/vehiculo/{vehiculo}', ActaPdfController::class)->scopeBindings()->name('admin.pdf.actas');

    //  certificado pdf
    // -------------------------------------------------
    Route::get('pdf/certificados/{certificado}/vehiculo/{vehiculo}', CertificadoPdfController::class)->name('admin.pdf.certificados');
    Route::get('pdf/contratos/{contrato:unique_hash}', ContratoPdfController::class)->name('admin.pdf.contratos');
    Route::get('pdf/certificados/velocimetros/{certificado}/vehiculo/{vehiculo}', CertificadoVelocimetroPdfController::class)->name('admin.pdf.velocimetros');
    Route::get('pdf/certificados/antifatiga/{certificado}/vehiculo/{vehiculo}', CertificadoAntifatigaPdfController::class)->name('admin.pdf.antifatiga');
    Route::get('pdf/presupuestos/{presupuesto}/{action?}', PresupuestoPdfController::class)->name('admin.pdf.presupuesto');
    Route::get('pdf/recibo/{recibo}/{action?}', ReciboPdfController::class)->name('admin.pdf.recibo');
    Route::get('pdf/recibo-pago/{recibo}/{action?}', ReciboPagoPdfController::class)->name('admin.pdf.recibo.pagos');
    Route::get('pdf/factura/{factura}/{action?}', FacturaPdfController::class)->name('admin.pdf.factura');


    //mantenimiento informe pdf
    //-----------------------------

    Route::get('pdf/mantenimientos/{mantenimiento}', [MantenimientoController::class, 'pdfInforme'])->name('admin.pdf.mantenimiento');


    //  tarea informe pdf
    // -------------------------------------------------
    Route::get('pdf/tarea/{tarea}', TareaPdfController::class)->name('admin.pdf.tarea');

    //notificaciones y mensajes
    route::get('mensajes/{mensaje}', [MensajeController::class, 'show'])->name('mensajes.show');
    route::get('solicitudes', [SolicitudesController::class, 'index'])->name('admin.solicitudes.index');
    route::get('reviews', [SolicitudesController::class, 'review'])->name('admin.reviews.index');

    Route::controller(ReportesGerenciales::class)->group(function () {

        Route::get('gerencia/reportes', 'index')->name('admin.gerencia.reportes');
    });

    route::get('notificaciones', [NotificacionesController::class, 'index'])->name('notificaciones.index');
    route::get('notificaciones/importes-fallidos', [NotificacionesController::class, 'importes'])->name('notificaciones.importes');

    Route::group(['middleware' => ['role:super-admin']], function () {
        //
    });



    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('admin.profile.show');


    // DATA CHARTS

    Route::get('/json-data-ventas', [HomeController::class, 'getDataVentas'])->name('json_data_feed');
    // Route de test SUNAT eliminada - usar FactilizaService directamente



    Route::controller(ComprobantesController::class)->group(function () {

        Route::get('ventas', 'index')->name('admin.ventas.index');
        Route::get('emitir/factura/{notificacion_ids?}', 'emitirFactura')->name('admin.factura.create');
        Route::get('emitir/boleta/{notificacion_ids?}', 'emitirBoleta')->name('admin.boleta.create');
        Route::get('emitir/nota-venta', 'emitirNotaVenta')->name('admin.nota.venta.create');
        Route::get('emitir/nota-credito', 'emitirNotaCredito')->name('admin.nota.credito.create');
        Route::get('emitir/nota-debito', 'emitirNotaDebito')->name('admin.nota.debito.create');
        Route::get('notas', 'notas')->name('admin.nota.index');
    });



    //SELECTS



    Route::controller(SelectsController::class)->group(function () {

        Route::get('api/categorias', 'categorias')->name('api.categorias.index');
        Route::get('api/ciudades', 'ciudades')->name('api.ciudades.index');
        Route::get('api/tipo-afectacion', 'tipoAfectacion')->name('api.tipo-afectacion.index');
        Route::get('api/unit', 'unit')->name('api.unit.index');
        Route::get('api/clientes', 'clientes')->name('api.clientes.index');
        Route::get('api/proveedores', 'proveedores')->name('api.proveedores.index');
        Route::get('api/series', 'series')->name('api.series.index');
        Route::get('api/invoices', 'invoices')->name('api.invoices.index');
        Route::get('api/productos', 'productos')->name('api.productos.index');
        Route::get('api/documentos', 'documentos')->name('api.documentos.index');
        Route::get('api/tipo-comprobantes', 'tipoComprobantes')->name('api.tipo.comprobantes.index');
        Route::get('api/sim-card', 'sim')->name('api.sim.index');
        Route::get('api/lineas', 'lineas')->name('api.lineas.index');
        Route::get('api/dispositivos', 'dispositivos')->name('api.dispositivos.index');
        Route::get('api/vehiculos', 'vehiculos')->name('api.vehiculos.index');
        Route::get('api/modelos/dispositivos', 'modelosDispositivos')->name('api.dispositivos.modelos.index');

        Route::get('api/sustentos', 'sustentos')->name('api.sustentos.index');
        Route::get('api/motivos-traslado', 'motivosTraslado')->name('api.motivos.traslado.index');
        Route::get('api/modalidad-traslado', 'modalidadTraslado')->name('api.modalidad.traslado.index');
        Route::get('api/ubigeos', 'ubigeos')->name('api.ubigeos.index');
        Route::get('api/comprobantes', 'comprobantes')->name('api.comprobantes.index');
        Route::get('api/user', 'user')->name('api.user.index');
        Route::get('api/prueba', 'prueba')->name('api.prueba.index');
        Route::get('api/puertos', 'puertosPeru')->name('api.puertos.index');
        Route::get('api/unidades', 'codesProductosGre')->name('api.unidades.index');
        Route::get('api/detracciones', 'codigosDetracciones')->name('api.detracciones.index');
        Route::get('api/metodos-pago', 'metodosPago')->name('api.metodos.pago.index');

        Route::get('/lineas/disponibles', [SelectsController::class, 'lineasDisponibles'])->name('api.lineas.disponibles');
        Route::get('/simcards/disponibles', [SelectsController::class, 'simCardsDisponibles'])->name('api.simcards.disponibles');
    });

    // ÓRDENES DE TRABAJO (WORK ORDERS)
    Route::prefix('work-orders')->name('admin.work-orders.')->middleware(['auth', 'can:ver-work_order'])->group(function () {
        Route::get('/', [WorkOrderController::class, 'index'])->name('index');
        Route::get('/{workOrder}', [WorkOrderController::class, 'show'])->name('show');
        Route::get('/{workOrder}/pdf', [WorkOrderPdfController::class, 'generate'])->name('pdf')->middleware('can:descargar-work_order');
        Route::get('/{workOrder}/checklist/{fase}', function (WorkOrder $workOrder, string $fase) {
            return view('admin.work-orders.checklist', compact('workOrder', 'fase'));
        })->name('checklist');

        Route::get('/{workOrder}/file/{type}/{filename}', function (WorkOrder $workOrder, string $type, string $filename) {
            $path = "work-orders/{$workOrder->id}/{$type}/{$filename}";

            if (!Storage::disk('private')->exists($path)) {
                abort(404);
            }

            return response()->file(Storage::disk('private')->path($path));
        })->name('file');
    });

    // TICKETS
    Route::controller(\App\Http\Controllers\Admin\TicketsController::class)->middleware('can:ver-ticket')->group(function () {
        Route::get('tickets', 'index')->name('admin.tickets.index');
        Route::get('tickets/{ticket}', 'show')->name('admin.tickets.show');

        // Dashboard endpoints
        Route::get('tickets-dashboard/summary', 'dashboardSummary')->name('admin.tickets.dashboard.summary');
        Route::get('tickets-dashboard/trends', 'dashboardTrends')->name('admin.tickets.dashboard.trends');
        Route::get('tickets-dashboard/agents', 'dashboardAgentPerformance')->name('admin.tickets.dashboard.agents');
        Route::get('tickets-dashboard/teams', 'dashboardTeamLoad')->name('admin.tickets.dashboard.teams');
    });
});
