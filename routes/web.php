<?php

use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\PlatBasicaController;
use App\Http\Controllers\PlatPremiumController;
use App\Http\Controllers\SolicitudesController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WebController::class, 'index'])->name('web.home');
Route::get('plataforma-basica', [PlatBasicaController::class, 'index'])->name('plataforma.basica');
Route::get('plataforma-premium', [PlatPremiumController::class, 'index'])->name('plataforma.premium');



Route::get('consulta/actas/{acta:codigo?}', [ConsultasController::class, 'consultaActas'])->name('consulta.actas');


// Route::get('consulta/vehiculos', [ConsultasController::class, 'consultaVehiculos'])->name('consulta.vehiculos');




Route::resource('solicitudes', SolicitudesController::class)->names('solicitudes');




Route::get('faq', [WebController::class, 'faq'])->name('web.faq');
Route::get('contacto', [WebController::class, 'contacto'])->name('web.contacto');
Route::post('send/form', [WebController::class, 'submitContacto'])->name('contact.form');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::middleware(['auth:sanctum', 'verified'])->get('consulta/vehiculos', [ConsultasController::class, 'consultaVehiculos'])->name('consulta.vehiculos');