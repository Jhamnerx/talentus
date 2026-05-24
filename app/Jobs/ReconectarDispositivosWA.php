<?php

namespace App\Jobs;

use App\Models\WhatsFleep\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReconectarDispositivosWA implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Reconecta dispositivos WhatsApp desconectados y mantiene activas las sesiones.
     * Se ejecuta cada 5 minutos desde el scheduler.
     */
    public function handle(): void
    {
        $devices = Device::whereIn('status', ['Connected', 'Disconnect'])->get();

        if ($devices->isEmpty()) {
            return;
        }

        $serverUrl = config('whatsapp.node_server_url', 'http://localhost:3000');

        Log::info("WA keep-alive: verificando {$devices->count()} dispositivo(s)...");

        foreach ($devices as $device) {
            try {
                $response = Http::timeout(15)->post("{$serverUrl}/backend-initialize", [
                    'token' => $device->body,
                ]);

                $json    = $response->json();
                $success = $json['status'] ?? false;

                Log::info("WA keep-alive #{$device->id} ({$device->body}): " . ($success ? '✓ ' . ($json['message'] ?? 'OK') : '✗ ' . ($json['message'] ?? 'sin respuesta')));

                // Si el Node confirma reconexión, marcar como Connected en la BD
                if ($success && $device->status !== 'Connected') {
                    $device->update(['status' => 'Connected']);
                }
            } catch (\Throwable $e) {
                Log::warning("WA keep-alive error #{$device->id} ({$device->body}): " . $e->getMessage());
            }
        }
    }
}
