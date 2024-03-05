<?php

use Maatwebsite\Excel\Row;
use App\Models\Dispositivos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Admin\GpsController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ActasController;
use App\Http\Controllers\Admin\GuiasController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Api\SelectsController;
use App\Http\Controllers\Admin\CobrosController;
use App\Http\Controllers\Admin\FlotasController;
use App\Http\Controllers\Admin\LineasController;
use App\Http\Controllers\Admin\UtilesController;
use App\Http\Controllers\Admin\AjustesController;
use App\Http\Controllers\Admin\MensajeController;
use App\Http\Controllers\Admin\RecibosController;
use App\Http\Controllers\Admin\SimCardController;
use App\Http\Controllers\Admin\ClientesController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\ReportesController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ContactosController;
use App\Http\Controllers\Admin\ContratosController;
use App\Http\Controllers\Admin\ProductosController;
use App\Http\Controllers\Admin\ReportesGerenciales;
use App\Http\Controllers\Admin\VehiculosController;
use App\Http\Controllers\Admin\PDF\ActaPdfController;
use App\Http\Controllers\Admin\PresupuestoController;
use App\Http\Controllers\Admin\ProveedoresController;
use App\Http\Controllers\Admin\SolicitudesController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Admin\PDF\TareaPdfController;
use App\Http\Controllers\Admin\MantenimientoController;
use App\Http\Controllers\Admin\PDF\ReciboPdfController;
use App\Http\Controllers\Admin\NotificacionesController;
use App\Http\Controllers\Admin\PDF\FacturaPdfController;
use App\Http\Controllers\Admin\VentasFacturasController;
use App\Http\Controllers\Admin\CertificadosGpsController;
use App\Http\Controllers\Admin\ComprasFacturasController;
use App\Http\Controllers\Admin\PDF\ContratoPdfController;
use App\Http\Controllers\Admin\ServicioTecnicoController;
use App\Http\Controllers\Admin\PDF\ReciboPagoPdfController;
use App\Http\Controllers\Admin\PDF\CertificadoPdfController;
use App\Http\Controllers\Admin\PDF\PresupuestoPdfController;
use App\Http\Controllers\Admin\RecibosPagosVariosController;
use App\Http\Controllers\Admin\Almacen\GuiaRemisionController;
use App\Http\Controllers\Admin\CertificadosVelocimetrosController;
use App\Http\Controllers\Admin\Facturacion\ComprobantesController;
use App\Http\Controllers\Admin\PDF\CertificadoVelocimetroPdfController;

Route::get('', [HomeController::class, 'index'])->name('admin.home');


// ALMACEN
Route::controller(CategoriaController::class)->group(function () {
    Route::get('categorias', 'index')->name('admin.almacen.categorias.index');
});

Route::controller(ProductosController::class)->group(function () {
    Route::get('productos', 'index')->name('admin.almacen.productos.index');
});


Route::controller(SimCardController::class)->group(function () {

    Route::get('sim-card', 'index')->name('admin.almacen.sim-card.index');
});


Route::controller(LineasController::class)->group(function () {
    //lineas
    Route::get('lineas', 'index')->name('admin.almacen.lineas.index');
});

Route::controller(GpsController::class)->group(function () {
    Route::get('dispositivos', 'index')->name('admin.almacen.dispositivos.index');
    Route::get('modelos/dispositivos', 'showModels')->name('admin.almacen.modelos-dispositivos');
});


Route::controller(GuiaRemisionController::class)->group(function () {
    Route::get('guias', 'index')->name('admin.almacen.guias.index');
    Route::get('guias/crear', 'create')->name('admin.almacen.guias.create');
    Route::get('guias/{guia}', 'show')->name('admin.almacen.guias.show');
    Route::get('guias/{guia}/editar', 'edit')->name('admin.almacen.guias.edit');
});

//Route::resource('clientes', ClientesController::class)->names('admin.clientes');

Route::controller(ClientesController::class)->group(function () {

    Route::get('clientes', 'index')->name('admin.clientes.index');
    Route::post('clientes', 'store')->name('admin.clientes.store');
    Route::get('clientes/crear', 'create')->name('admin.clientes.create');
    Route::get('clientes/{cliente}', 'show')->name('admin.clientes.show');
    Route::put('clientes/{cliente}', 'update')->name('admin.clientes.updated');
    Route::get('clientes/{cliente}/editar', 'edit')->name('admin.clientes.edit');
});



Route::controller(ContactosController::class)->group(function () {
    Route::get('contactos', 'index')->name('admin.clientes.contactos.index');
});


//Route::get('/proveedores/{proveedor}', [ProveedoresController::class, 'show']);
Route::resource('proveedor', ProveedoresController::class)->names('admin.proveedores');

// COMPRAS
Route::resource('compras-factura', ComprasFacturasController::class)->names('admin.compras.facturas')->parameters([
    'compras-factura' => 'factura'
]);




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
    Route::get('recibos/crear', 'create')->name('admin.ventas.recibos.create');
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
    Route::get('vehiculos/{vehiculo}/editar', 'edit')->name('admin.vehiculos.edit');
    Route::put('vehiculos/{vehiculo}', 'update')->name('admin.vehiculos.update');
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


//ADMINISTRACION

Route::resource('usuarios', UsersController::class)->names('admin.users')->parameters([
    'usuarios' => 'user'
]);

//Route::resource('cobros', CobrosController::class)->names('admin.cobros');
// Route::resource('payments', PaymentsController::class)->names('admin.payments');


Route::controller(CobrosController::class)->group(function () {

    Route::get('cobros/crear', 'create')->name('admin.cobros.create');
    Route::get('cobros', 'index')->name('admin.cobros.index');
    Route::get('cobros/{cobro}', 'show')->name('admin.cobros.show');
    Route::get('cobros/{cobro}/editar', 'edit')->name('admin.cobros.edit');
});




Route::controller(PaymentsController::class)->group(function () {

    Route::get('payments', 'index')->name('admin.payments.index');
    Route::get('payments/{payment}', 'show')->name('admin.payments.show');
});

Route::get('ajustes/cuenta', [AjustesController::class, 'cuenta'])->name('admin.ajustes.cuenta');
Route::get('ajustes/ciudades', [AjustesController::class, 'ciudades'])->name('admin.ajustes.ciudades');
Route::get('ajustes/notificaciones', [AjustesController::class, 'notificaciones'])->name('admin.ajustes.notificaciones');
Route::get('ajustes/roles', [AjustesController::class, 'roles'])->name('admin.ajustes.roles');
Route::get('ajustes/series', [AjustesController::class, 'series'])->name('admin.ajustes.series');
Route::get('ajustes/plantilla', [AjustesController::class, 'plantilla'])->name('admin.ajustes.plantilla');

//Route::resource('ajustes/plantilla', RolController::class)->names('admin.ajustes.roles');
Route::post('ajustes/roles/store', [RolController::class, 'store'])->name('admin.ajustes.roles.store');


Route::controller(ServicioTecnicoController::class)->prefix('tecnico')->group(function () {

    Route::get('tareas', 'index')->name('admin.tecnico.tareas.index');
});



Route::controller(SearchController::class)->prefix('search')->group(function () {

    // Route::get('clientes', 'clientes')->name('search.clientes');
    //Route::get('cliente/{cliente?}', 'cliente')->name('search.cliente');
    //Route::get('proveedores', 'proveedores')->name('search.proveedores');
    //Route::get('proveedor/{proveedor?}', 'proveedor')->name('search.proveedor');
    //Route::get('flotas', 'flotas')->name('search.flotas');
    // Route::get('flota', 'flota')->name('search.flota');

    // Route::get('sim_card', 'sim_card')->name('search.sim_card');
    // Route::get('lineas', 'lineas')->name('search.lineas');
    // Route::get('dispositivos', 'dispositivos')->name('search.dispositivos');
    // //Route::get('modelos/dispositivos', 'modelos')->name('search.dispositivos.modelos');
    // Route::get('vehiculos', 'vehiculos')->name('search.vehiculos');
    // Route::get('ciudades', 'ciudades')->name('search.ciudades');
    // Route::get('productos', 'productos')->name('search.productos');
    // Route::get('facturas', 'facturas')->name('search.facturas');
    // Route::get('ubigeos', 'ubigeos')->name('search.ubigeos');
    // Route::get('users', 'users')->name('search.users');
});


Route::get('busqueda/clientes', [SearchController::class, 'busqueda'])->name('busqueda.clientes');

//consulta sunat
Route::get('consulta/documento', [SearchController::class, 'sunat'])->name('consulta.sunat');

Route::get('consulta/placa', [SearchController::class, 'placa'])->name('consulta.placa');


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
Route::get('/test/sunat', [UtilesController::class, 'sunatConsulta'])->name('sunat.consulta');



Route::controller(ComprobantesController::class)->group(function () {

    Route::get('ventas', 'index')->name('admin.ventas.index');
    Route::get('emitir/factura', 'emitirFactura')->name('admin.factura.create');
    Route::get('emitir/boleta', 'emitirBoleta')->name('admin.boleta.create');
    Route::get('emitir/nota-venta', 'emitirNotaVenta')->name('admin.nota.venta.create');
    Route::get('emitir/nota-credito', 'emitirNotaCredito')->name('admin.nota.credito.create');
    Route::get('emitir/nota-debito', 'emitirNotaDebito')->name('admin.nota.debito.create');
});



//SELECTS



Route::controller(SelectsController::class)->group(function () {

    Route::get('api/categorias', 'categorias')->name('api.categorias.index');
    Route::get('api/ciudades', 'ciudades')->name('api.ciudades.index');
    Route::get('api/tipo-afectacion', 'tipoAfectacion')->name('api.tipo-afectacion.index');
    Route::get('api/unit', 'unit')->name('api.unit.index');
    Route::get('api/clientes', 'clientes')->name('api.clientes.index');
    Route::get('api/series', 'series')->name('api.series.index');
    Route::get('api/invoices', 'invoices')->name('api.invoices.index');
    Route::get('api/productos', 'productos')->name('api.productos.index');
    Route::get('api/documentos', 'documentos')->name('api.documentos.index');
    Route::get('api/comprobantes', 'comprobantes')->name('api.comprobantes.index');
    Route::get('api/sim-card', 'sim')->name('api.sim.index');
    Route::get('api/lineas', 'lineas')->name('api.lineas.index');
    Route::get('api/dispositivos', 'dispositivos')->name('api.dispositivos.index');
    Route::get('api/vehiculos', 'vehiculos')->name('api.vehiculos.index');
    Route::get('api/modelos/dispositivos', 'modelosDispositivos')->name('api.dispositivos.modelos.index');

    Route::get('api/sustentos', 'sustentos')->name('api.sustentos.index');
});


Route::controller(UtilesController::class)->group(function () {

    Route::get('api/tipo_cambio', 'tipoCambio')->name('api.tipo-cambio.index');
});
