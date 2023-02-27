<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ExtrasController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\PlatBasicaController;
use App\Http\Controllers\PlatPremiumController;
use App\Http\Controllers\SolicitudesController;


Route::get('/', [WebController::class, 'index'])->name('web.home');
Route::get('plataforma-basica', [PlatBasicaController::class, 'index'])->name('plataforma.basica');
Route::get('plataforma-premium', [PlatPremiumController::class, 'index'])->name('plataforma.premium');



Route::get('consulta/actas/{acta:codigo?}', [ConsultasController::class, 'consultaActas'])
    ->name('consulta.actas');
Route::get('consulta/certificado/{certificados:codigo?}', [ConsultasController::class, 'consultaCertificado'])
    ->name('consulta.certificado');
Route::get('consulta/velocimetro/{certificado_velocimetros:codigo?}', [ConsultasController::class, 'consultaCertificadoVelocimetro'])
    ->name('consulta.certificado.velocimetro');


// Route::get('consulta/vehiculos', [ConsultasController::class, 'consultaVehiculos'])->name('consulta.vehiculos');






Route::controller(SolicitudesController::class)->group(function () {

    Route::get('solicitudes/{solicitud}', 'create')->name('solicitudes');
});

// Route::controller(ExtrasController::class)->group(function () {

//     Route::get('confirmacion/{uuid}', 'confirmacion')->name('confirmacion.tarea');
// });

Route::get('confirmacion/tareas/{tarea:uuid}', ExtrasController::class)->name('confirmacion.tarea');


Route::get('faq', [WebController::class, 'faq'])->name('web.faq');
Route::get('contacto', [WebController::class, 'contacto'])->name('web.contacto');
Route::post('send/form', [WebController::class, 'submitContacto'])->name('contact.form');

Route::middleware(['auth:sanctum', 'verified'])->get('consulta/vehiculos', [ConsultasController::class, 'consultaVehiculos'])->name('consulta.vehiculos');
