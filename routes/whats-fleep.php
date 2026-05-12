<?php

use App\Http\Controllers\Admin\WhatsFleep\ApiDocController;
use App\Http\Controllers\Admin\WhatsFleep\AutoreplyController;
use App\Http\Controllers\Admin\WhatsFleep\CampaignController;
use App\Http\Controllers\Admin\WhatsFleep\ContactController;
use App\Http\Controllers\Admin\WhatsFleep\DeviceController;
use App\Http\Controllers\Admin\WhatsFleep\MessageController;
use App\Http\Controllers\Admin\WhatsFleep\MessageHistoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'verified'])->prefix('whatsapp')->name('admin.whats-fleep.')->group(function () {

    // Dispositivos
    Route::get('dispositivos', [DeviceController::class, 'index'])->name('devices')->middleware('can:ver-dispositivos-wa');
    Route::get('dispositivos/scan/{body}', [DeviceController::class, 'scan'])->name('devices.scan')->middleware('can:gestionar-dispositivos-wa');
    Route::post('dispositivos/session', [DeviceController::class, 'setSelectedDeviceSession'])->name('devices.set-session')->middleware('can:ver-dispositivos-wa');

    // Auto-respuestas
    Route::get('auto-reply', [AutoreplyController::class, 'index'])->name('autoreply')->middleware('can:gestionar-autoreplies-wa');

    // Contactos
    Route::get('contactos', [ContactController::class, 'index'])->name('contacts')->middleware('can:ver-contactos-wa');
    Route::get('contactos/grupos', [ContactController::class, 'groups'])->name('contacts.groups')->middleware('can:ver-contactos-wa');

    // Campañas
    Route::get('campanias', [CampaignController::class, 'index'])->name('campaigns')->middleware('can:ver-campanias-wa');
    Route::get('campanias/crear', [CampaignController::class, 'create'])->name('campaign.create')->middleware('can:gestionar-campanias-wa');

    // Mensajes
    Route::get('mensajes/prueba', [MessageController::class, 'index'])->name('messages.test')->middleware('can:enviar-mensajes-wa');
    Route::get('mensajes/historial', [MessageHistoryController::class, 'index'])->name('messages.history')->middleware('can:ver-historial-wa');

    // API Docs
    Route::get('api-docs', [ApiDocController::class, 'index'])->name('api-docs')->middleware('can:gestionar-dispositivos-wa');
});
