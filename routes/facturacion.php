<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Facturacion\VisualizarArchivosController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(VisualizarArchivosController::class)->group(function () {

    Route::get('pdf/{ventas:serie_correlativo}', 'pdf')->name('facturacion.ver.pdf');
    //Route::get('ticket/{ventas:serie_correlativo}', 'ticket')->name('facturacion.ver.ticket');
    Route::get('xml/{ventas:serie_correlativo}', 'xml')->name('facturacion.ver.xml');
    Route::get('cdr/{ventas:serie_correlativo}', 'cdr')->name('facturacion.ver.cdr');

    //GUIA DE REMISION - VISUALIZAR ARCHIVOS
    Route::get('guia/pdf/{guia:serie_correlativo}', 'pdf_guia')->name('facturacion.guia.ver.pdf');
    Route::get('guia/xml/{guia:serie_correlativo}', 'xml_guia')->name('facturacion.guia.ver.xml');
    Route::get('guia/cdr/{guia:serie_correlativo}', 'cdr_guia')->name('facturacion.guia.qver.cdr');
});
