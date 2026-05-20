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
        $orden->loadMissing(['tipo', 'vehiculo', 'tecnico', 'items']);

        $tecnico = $orden->tecnico;
        $tipo    = $orden->tipo;

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

        $sep = '─────────────────────';

        // ── PROYECTO: mensaje resumido ────────────────────────────────────
        if ($orden->es_proyecto) {
            $totalUnidades = $orden->items->count();
            $unidadesTexto = $totalUnidades > 0
                ? "{$totalUnidades} " . ($totalUnidades === 1 ? 'vehículo' : 'vehículos') . ' registrados'
                : 'Unidades por confirmar';

            $lineas = [
                '🔧 *ORDEN DE TRABAJO — PROYECTO*',
                '',
                '📋 *' . strtoupper($tipo->nombre ?? 'ORDEN') . '*',
                $sep,
                '📦 *PROYECTO:* ' . strtoupper($orden->titulo_proyecto ?? 'SIN TÍTULO'),
                '🚛 *UNIDADES:* ' . $unidadesTexto,
                '   _(Las placas y datos por unidad se gestionan en el detalle de la orden)_',
            ];

            if (!empty($orden->sector) && $orden->sector !== '-') {
                $lineas[] = '📍 *SECTOR:* ' . strtoupper($orden->sector);
            }
            if (!empty($orden->plan) && $orden->plan !== '-') {
                $lineas[] = '💳 *PLAN:* ' . strtoupper($orden->plan);
            }

            $lineas[] = $sep;
            $lineas[] = '👷 *TÉCNICO:* '       . strtoupper($tecnico->name ?? '-');
            $lineas[] = '📅 *LUGAR Y FECHA:* ' . strtoupper($fecha);

            if (!empty($orden->observaciones_inicial)) {
                $lineas[] = '📝 *CONSIDERACIONES:* ' . strtoupper($orden->observaciones_inicial);
            }

            if ($orden->ubicacion_lat && $orden->ubicacion_lng) {
                $lineas[] = '🗺️ *UBICACIÓN:* https://maps.google.com/?q=' . $orden->ubicacion_lat . ',' . $orden->ubicacion_lng;
            }

            if (!empty($listaAcc)) {
                $lineas[] = $sep;
                $lineas[] = '🔩 *ACCESORIOS:*';
                foreach ($listaAcc as $acc) {
                    $lineas[] = '   • ' . $acc;
                }
            }

            if ($orden->contacto) {
                $lineas[] = $sep;
                $lineas[] = '👋 *CONTACTO:* ' . $orden->contacto;
            }

            return implode("\n", $lineas);
        }

        // ── ORDEN INDIVIDUAL ──────────────────────────────────────────────
        $cliente  = $orden->vehiculo?->cliente ?? $orden->cliente;
        $vehiculo = $orden->vehiculo;

        // ¿Es cliente nuevo? (tiene solo 1 vehículo registrado en la empresa)
        $esClienteNuevo = $cliente
            ? $cliente->vehiculos()->count() <= 1
            : false;

        $clienteEmoji = $esClienteNuevo ? '🆕' : '👤';
        $clienteLabel = $esClienteNuevo ? 'CLIENTE NUEVO' : 'CLIENTE';

        $sep = '─────────────────────';

        // Placa + marca/modelo en una sola línea
        $marcaModelo   = trim(strtoupper($vehiculo->marca ?? '') . ' ' . strtoupper($vehiculo->modelo ?? ''));
        $vehiculoLinea = strtoupper($vehiculo->placa ?? '-');
        if ($marcaModelo) {
            $vehiculoLinea .= ' — ' . $marcaModelo;
        }

        $lineas = [
            '🔧 *ORDEN DE TRABAJO*',
            '',
            '📋 *' . strtoupper($tipo->nombre ?? 'ORDEN') . '*',
            $sep,
            "{$clienteEmoji} *{$clienteLabel}:* " . strtoupper($cliente->razon_social ?? '-'),
            '🪪 *RUC:* '    . ($cliente->numero_documento ?? '-'),
            '📧 *Correo:* ' . ($cliente->email ?? '-'),
            '🚗 *PLACA:* '  . $vehiculoLinea,
        ];

        if (!empty($orden->sector) && $orden->sector !== '-') {
            $lineas[] = '📍 *SECTOR:* ' . strtoupper($orden->sector);
        }
        if (!empty($orden->plan) && $orden->plan !== '-') {
            $lineas[] = '💳 *PLAN:* ' . strtoupper($orden->plan);
        }

        $lineas[] = $sep;
        $lineas[] = '👷 *TÉCNICO:* '       . strtoupper($tecnico->name ?? '-');
        $lineas[] = '📅 *LUGAR Y FECHA:* ' . strtoupper($fecha);

        if (!empty($orden->observaciones_inicial)) {
            $lineas[] = '📝 *CONSIDERACIONES:* ' . strtoupper($orden->observaciones_inicial);
        }

        // Link de Google Maps si hay coordenadas registradas
        if ($orden->ubicacion_lat && $orden->ubicacion_lng) {
            $lineas[] = '🗺️ *UBICACIÓN:* https://maps.google.com/?q=' . $orden->ubicacion_lat . ',' . $orden->ubicacion_lng;
        }

        if (!empty($listaAcc)) {
            $lineas[] = $sep;
            $lineas[] = '🔩 *ACCESORIOS:*';
            foreach ($listaAcc as $acc) {
                $lineas[] = '   • ' . $acc;
            }
        }

        if ($orden->contacto) {
            $lineas[] = $sep;
            $lineas[] = '👋 *CONTACTO:* ' . $orden->contacto;
        }

        return implode("\n", $lineas);
    }
}
