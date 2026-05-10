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
    Route::get('dispositivos', [DeviceController::class, 'index'])->name('devices');
    Route::get('dispositivos/scan/{body}', [DeviceController::class, 'scan'])->name('devices.scan');
    Route::post('dispositivos/session', [DeviceController::class, 'setSelectedDeviceSession'])->name('devices.set-session');

    // Auto-respuestas
    Route::get('auto-reply', [AutoreplyController::class, 'index'])->name('autoreply');

    // Contactos
    Route::get('contactos', [ContactController::class, 'index'])->name('contacts');
    Route::get('contactos/grupos', [ContactController::class, 'groups'])->name('contacts.groups');

    // Campañas
    Route::get('campanias', [CampaignController::class, 'index'])->name('campaigns');
    Route::get('campanias/crear', [CampaignController::class, 'create'])->name('campaign.create');

    // Mensajes
    Route::get('mensajes/prueba', [MessageController::class, 'index'])->name('messages.test');
    Route::get('mensajes/historial', [MessageHistoryController::class, 'index'])->name('messages.history');

    // API Docs
    Route::get('api-docs', [ApiDocController::class, 'index'])->name('api-docs');
});
