<?php

use App\Http\Controllers\Admin\ActasController;
use App\Http\Controllers\Admin\AjustesController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\CertificadosGpsController;
use App\Http\Controllers\Admin\CertificadosVelocimetrosController;
use App\Http\Controllers\Admin\CiudadesController;
use App\Http\Controllers\Admin\ClientesController;
use App\Http\Controllers\Admin\CobrosController;
use App\Http\Controllers\Admin\ComprasFacturasController;
use App\Http\Controllers\Admin\ContactosController;
use App\Http\Controllers\Admin\ContratosController;
use App\Http\Controllers\Admin\FlotasController;
use App\Http\Controllers\Admin\GpsController;
use App\Http\Controllers\Admin\GuiasController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\LineasController;
use App\Http\Controllers\Admin\PDF\ActaPdfController;
use App\Http\Controllers\Admin\PresupuestoController;
use App\Http\Controllers\Admin\ProductosController;
use App\Http\Controllers\Admin\ProveedoresController;
use App\Http\Controllers\Admin\RecibosController;
use App\Http\Controllers\Admin\ReportesController;
use App\Http\Controllers\Admin\ServicioTecnicoController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VehiculosController;
use App\Http\Controllers\Admin\VentasFacturasController;
use App\Http\Controllers\SearchController;
use App\Models\Dispositivos;
use Illuminate\Support\Facades\Route;



Route::get('', [HomeController::class, 'index'])->name('admin.home');
// ALMACEN


Route::resource('categorias', CategoriaController::class)->names('admin.almacen.categorias');
Route::resource('productos', ProductosController::class)->names('admin.almacen.productos');

Route::resource('lineas', LineasController::class)->names('admin.almacen.lineas');
Route::get('asign/lineas', [LineasController::class, 'asignLinea'])->name('admin.asign.lineas');
Route::post('asign/lineas/store', [LineasController::class, 'asignLineaStore'])->name('admin.asign.lineas.store');


Route::get('modelos/dispositivos', [GpsController::class, 'showModels'])->name('admin.almacen.modelos-dispositivos');
Route::resource('dispositivos', GpsController::class)->names('admin.almacen.dispositivos')->parameters([
    'dispositivos' => 'dispositivo'
]);
Route::resource('guias', GuiasController::class)->names('admin.almacen.guias');

Route::resource('clientes', ClientesController::class)->names('admin.clientes');
//Route::get('/proveedores/{proveedor}', [ProveedoresController::class, 'show']);
Route::resource('proveedor', ProveedoresController::class)->names('admin.proveedores');

// COMPRAS

Route::resource('compras-factura', ComprasFacturasController::class)->names('admin.compras.facturas')->parameters([
    'compras-factura' => 'factura'
]);

// VENTAS
Route::resource('presupuestos', PresupuestoController::class)->names('admin.ventas.presupuestos');
Route::resource('ventas-factura', VentasFacturasController::class)->names('admin.ventas.facturas')->parameters([
    'ventas-factura' => 'factura'
]);;
Route::resource('recibos', RecibosController::class)->names('admin.ventas.recibos');
Route::resource('contratos', ContratosController::class)->names('admin.ventas.contratos');

// VEHICULOS
Route::resource('flotas', FlotasController::class)->names('admin.vehiculos.flotas');
Route::resource('contactos', ContactosController::class)->names('admin.vehiculos.contactos');
Route::resource('vehiculos', VehiculosController::class)->names('admin.vehiculos');

Route::resource('reportes', ReportesController::class)->names('admin.vehiculos.reportes');

// CERTIFICADOS
Route::resource('actas', ActasController::class)->names('admin.certificados.actas');
Route::resource('certificados-gps', CertificadosGpsController::class)->names('admin.certificados.gps')->parameters([
    'certificados-gps' => 'certificado'
]);
Route::resource('certificados-velocimetros', CertificadosVelocimetrosController::class)->names('admin.certificados.velocimetros')->parameters([
    'certificados-velocimetros' => 'certificado'
]);


//ADMINISTRACION

Route::resource('usuarios', UsersController::class)->names('admin.users');
Route::resource('cobros', CobrosController::class)->names('admin.cobros');
Route::resource('ciudades', CiudadesController::class)->names('admin.ciudades');
Route::resource('ajustes', AjustesController::class)->names('admin.ajustes');


Route::get('tecnico/tareas-pendientes', [ServicioTecnicoController::class, 'pendientes'])->name('admin.tecnico.tareas.pendientes');
Route::get('tecnico/tareas-completadas', [ServicioTecnicoController::class, 'completadas'])->name('admin.tecnico.tareas.completadas');

Route::resource('servicio-tecnico', ServicioTecnicoController::class)->names('admin.servicio.tecnico');



Route::get('search/clientes', [SearchController::class, 'clientes'])->name('search.clientes');
Route::get('search/flotas', [SearchController::class, 'flotas'])->name('search.flotas');
Route::get('search/flota', [SearchController::class, 'flota'])->name('search.flota');
Route::get('busqueda/clientes', [SearchController::class, 'busqueda'])->name('busqueda.clientes');
Route::get('search/sim_card', [SearchController::class, 'sim_card'])->name('search.sim_card');
Route::get('search/lineas', [SearchController::class, 'lineas'])->name('search.lineas');
Route::get('search/dispositivos', [SearchController::class, 'dispositivos'])->name('search.dispositivos');
Route::get('search/vehiculos', [SearchController::class, 'vehiculos'])->name('search.vehiculos');
Route::get('search/ciudades', [SearchController::class, 'ciudades'])->name('search.ciudades');

// VERIFICAR


//EXPORTACION RUTAS
Route::get('export/lineas', [LineasController::class, 'exportExcel'])->name('admin.export.lineas');
Route::get('export/dispositivos', [GpsController::class, 'exportExcel'])->name('admin.export.dispositivos');
Route::get('export/clientes', [ClientesController::class, 'exportExcel'])->name('admin.export.clientes');
Route::get('export/proveedores', [ProveedoresController::class, 'exportExcel'])->name('admin.export.proveedores');



// PDF
// ----------------------------------------------

//  acta pdf
// -------------------------------------------------
Route::get('pdf/actas/{acta:unique_hash}', ActaPdfController::class)->name('admin.pdf.actas');
