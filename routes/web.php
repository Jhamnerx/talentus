<?php

use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\PlatBasicaController;
use App\Http\Controllers\PlatPremiumController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;


Route::get('/', [WebController::class, 'index'])->name('web.home');
Route::get('plataforma-basica', [PlatBasicaController::class, 'index'])->name('plataforma.basica');
Route::get('plataforma-premium', [PlatPremiumController::class, 'index'])->name('plataforma.premium');



Route::get('consulta/actas', [ConsultasController::class, 'consultaActas'])->name('consulta.actas');
Route::get('consulta/vehiculos', [ConsultasController::class, 'consultaVehiculos'])->name('consulta.vehiculos');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
