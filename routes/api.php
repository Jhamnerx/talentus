<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SelectsController;
use App\Http\Controllers\Admin\UtilesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::controller(SelectsController::class)->group(function () {

    Route::get('categorias', 'categorias')->name('api.categorias.index');
    Route::get('tipo-afectacion', 'tipoAfectacion')->name('api.tipo-afectacion.index');
    Route::get('unit', 'unit')->name('api.unit.index');
    Route::get('clientes', 'clientes')->name('api.clientes.index');
    Route::get('series', 'series')->name('api.series.index');
    Route::get('productos', 'productos')->name('api.productos.index');
    Route::get('documentos', 'documentos')->name('api.documentos.index');
    Route::get('comprobantes', 'comprobantes')->name('api.comprobantes.index');
    Route::get('sim-card', 'sim')->name('api.sim.index');
    Route::get('lineas', 'lineas')->name('api.lineas.index');
    Route::get('vehiculos', 'vehiculos')->name('api.vehiculos.index');
    Route::get('modelos/dispositivos', 'modelosDispositivos')->name('api.dispositivos.modelos.index');
});


Route::controller(UtilesController::class)->group(function () {

    Route::get('tipo_cambio', 'tipoCambio')->name('api.tipo-cambio.index');
});
