<?php

namespace App\Services;

use App\Models\WorkOrder;
use App\Models\WhatsFleep\Device;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WorkOrderNotificationService
{
    /** Sectores predefinidos */
    public const ZONAS = [
        'SUTRAN'         => 'SUTRAN',
        'OSINERGMIN'     => 'OSINERGMIN',
        'MINA: CMC'      => 'MINA: CMC',
        'MINA: ZANJA'    => 'MINA: ZANJA',
        'MINA: YANACOCHA' => 'MINA: YANACOCHA',
        'MINA: SHAHUINDO' => 'MINA: SHAHUINDO',
        'SISCOP'         => 'SISCOP',
        'OTROS'          => 'OTROS',
    ];

    /** Accesorios disponibles para una orden */
    public const ACCESORIOS = [
        'buzzer'            => 'Buzzer - Alerta Sonora',
        'corte_motor'       => 'Corte de Motor - Apagado Remoto',
        'apertura_puertas'  => 'Apertura de Puertas',
        'telemetria'        => 'Telemetría',
        'combustible'       => 'Sensor de Combustible',
        'temperatura'       => 'Sensor de Temperatura',
        'horas_motor'       => 'Horas de Motor',
        'rpm'               => 'RPM',
        'acelerometro'      => 'Acelerómetro',
        'camara'            => 'Cámara',
    ];

    /**
     * Envía la notificación de la orden al grupo de WhatsApp del técnico.
     * Usa el primer dispositivo conectado disponible como emisor.
     * Guarda el wa_message_id y wa_group_id en la orden al enviar correctamente.
     * Retorna el ID del mensaje WA o null si falló.
     */
    public function enviarAlGrupo(WorkOrder $orden, ?Device $device = null): ?string
    {
        $orden->loadMissing(['tipo', 'vehiculo.cliente', 'tecnico', 'creador']);

        $tecnico = $orden->tecnico;

        if (!$tecnico || !$tecnico->wa_group_id) {
            Log::info("WorkOrder #{$orden->id}: técnico sin wa_group_id configurado.");
            return null;
        }

        // Usar el dispositivo recibido; si no, el del creador; si no, cualquiera conectado
        if (!$device || $device->status !== 'Connected') {
            $device = $orden->creador?->waDevices()->where('status', 'Connected')->first()
                ?? Device::where('status', 'Connected')->first();
        }

        if (!$device) {
            Log::warning("WorkOrder #{$orden->id}: no hay dispositivo WA conectado para enviar notificación.");
            return null;
        }

        $mensaje = $this->formatMensaje($orden);
        $serverUrl = config('whatsapp.node_server_url', 'http://localhost:3000');

        Log::info("WorkOrder #{$orden->id}: intentando enviar WA.", [
            'device_id'  => $device->id,
            'token'      => $device->body,
            'group_id'   => $tecnico->wa_group_id,
            'server_url' => $serverUrl,
        ]);

        try {
            $response = Http::timeout(30)->post("{$serverUrl}/api/send-message", [
                'token'          => $device->body,
                'number'         => $tecnico->wa_group_id,
                'message'        => $mensaje,
                'simulateTyping' => false,
            ]);

            Log::info("WorkOrder #{$orden->id}: respuesta del Node.", [
                'http_status' => $response->status(),
                'body'        => $response->body(),
            ]);

            if ($response->successful() && $response->json('status')) {
                $messageId = $response->json('data.key.id');

                // Persistir referencia del mensaje en la orden
                $orden->withoutGlobalScope(\App\Scopes\EmpresaScope::class)
                    ->where('id', $orden->id)
                    ->update([
                        'wa_message_id' => $messageId,
                        'wa_group_id'   => $tecnico->wa_group_id,
                    ]);

                Log::info("WorkOrder #{$orden->id}: WA enviado al grupo {$tecnico->wa_group_id}. MsgId: {$messageId}");
                return $messageId;
            }

            // Si el error es "Connection Closed", marcar el device como desconectado para evitar futuros intentos fallidos
            $nodeError = $response->json('error') ?? '';
            if (str_contains($nodeError, 'Connection Closed') || str_contains($nodeError, 'Connection')) {
                Log::warning("WorkOrder #{$orden->id}: device #{$device->id} ({$device->body}) tiene sesión caída. Marcando como Disconnected.");
                $device->update(['status' => 'Disconnected']);
            }

            Log::warning("WorkOrder #{$orden->id}: WA falló. HTTP {$response->status()}. Error: {$nodeError}. Body: " . $response->body());
            return null;
        } catch (\Throwable $e) {
            Log::error("WorkOrder #{$orden->id}: excepción enviando WA: " . $e->getMessage(), [
                'device' => $device->body,
                'group'  => $tecnico->wa_group_id,
            ]);
            return null;
        }
    }

    /**
     * Formatea el mensaje de WhatsApp con los datos de la orden.
     */
    public function formatMensaje(WorkOrder $orden): string
    {
        $orden->loadMissing(['tipo', 'vehiculo', 'tecnico']);

        $cliente  = $orden->vehiculo?->cliente ?? $orden->cliente;
        $vehiculo = $orden->vehiculo;
        $tecnico  = $orden->tecnico;
        $tipo     = $orden->tipo;

        // ¿Es cliente nuevo? (tiene solo 1 vehículo registrado en la empresa)
        $esClienteNuevo = $cliente
            ? $cliente->vehiculos()->count() <= 1
            : false;

        $clienteLabel = $esClienteNuevo ? 'CLIENTE NUEVO' : 'CLIENTE';

        // Accesorios de metadata
        $meta       = $orden->metadata ?? [];
        $accesorios = $meta['accesorios'] ?? [];
        $listaAcc   = array_values(array_filter(
            array_map(
                fn($key) => isset(self::ACCESORIOS[$key]) ? strtoupper(self::ACCESORIOS[$key]) : null,
                $accesorios
            )
        ));

        // Fecha en formato humano (Lima)
        $fecha = $orden->fecha_programada
            ->setTimezone('America/Lima')
            ->translatedFormat('l d/m H:i A');

        $lineas = [
            strtoupper($tipo->nombre ?? 'ORDEN DE TRABAJO') . ':',
            '',
            "{$clienteLabel}: " . strtoupper($cliente->razon_social ?? '-'),
            'RUC: '    . ($cliente->numero_documento ?? '-'),
            'Correo: ' . ($cliente->email ?? '-'),
            'PLACA: '  . strtoupper($vehiculo->placa ?? '-'),
        ];

        // Solo mostrar si tiene valor
        if (!empty($orden->sector) && $orden->sector !== '-') {
            $lineas[] = 'SECTOR: ' . strtoupper($orden->sector);
        }
        if (!empty($orden->plan) && $orden->plan !== '-') {
            $lineas[] = 'PLAN: ' . strtoupper($orden->plan);
        }

        // Marca y modelo del vehículo (no el campo "tipo" que guarda el color/categoría)
        $marcaModelo = trim(
            strtoupper($vehiculo->marca ?? '') . ' ' . strtoupper($vehiculo->modelo ?? '')
        );
        if ($marcaModelo) {
            $lineas[] = 'VEHÍCULO: ' . $marcaModelo;
        }

        $lineas[] = 'TECNICO: '         . strtoupper($tecnico->name ?? '-');
        $lineas[] = 'LUGAR Y FECHA: '   . strtoupper($fecha);

        if (!empty($orden->observaciones_inicial)) {
            $lineas[] = 'CONSIDERACIONES: ' . strtoupper($orden->observaciones_inicial);
        }

        if (!empty($listaAcc)) {
            $lineas[] = 'ACCESORIOS: ' . implode(', ', $listaAcc);
        }

        if ($orden->contacto) {
            $lineas[] = 'CONTACTO: ' . $orden->contacto;
        }

        return implode("\n", $lineas);
    }
}
