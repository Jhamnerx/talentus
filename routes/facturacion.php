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
    Route::get('guia/pdf/{id}/{guia:serie_correlativo}', 'pdf_guia')->name('facturacion.guia.ver.pdf');
    Route::get('guia/xml/{guia:serie_correlativo}', 'xml_guia')->name('facturacion.guia.ver.xml');
    Route::get('guia/cdr/{guia:serie_correlativo}', 'cdr_guia')->name('facturacion.guia.qver.cdr');


    //GUIA DE REMISION - VISUALIZAR ARCHIVOS
    Route::get('nota/pdf/{id}/{comprobantes:serie_correlativo}', 'pdf_nota')->name('facturacion.nota.ver.pdf');
    Route::get('nota/xml/{comprobantes:serie_correlativo}', 'xml_nota')->name('facturacion.nota.ver.xml');
    Route::get('nota/cdr/{comprobantes:serie_correlativo}', 'cdr_nota')->name('facturacion.nota.qver.cdr');



    Route::get('anulaciones/pdf/{id}/{envio_resumen:nombre_xml}', 'pdf_anulacion')->name('facturacion.anulacion.ver.pdf');
    Route::get('anulaciones/xml/{id}/{envio_resumen:nombre_xml}', 'xml_anulacion')->name('facturacion.anulacion.ver.xml');
});
