<?php

namespace App\Services;

use App\Models\WorkOrder;
use App\Models\ModelosDispositivo;
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

    /** Alertas GPS disponibles para configurar en una orden */
    public const ALERTAS = [
        'exceso_velocidad'           => 'Exceso de velocidad',
        'duracion_estacionado'       => 'Duración de estacionado',
        'duracion_tiempo'            => 'Duración de tiempo',
        'duracion_fuera_linea'       => 'Duración fuera de línea',
        'duracion_movimiento'        => 'Duración de movimiento',
        'duracion_encendido'         => 'Duración de encendido',
        'duracion_inactividad'       => 'Duración de inactividad',
        'encendido_onoff'            => 'Encendido ON/OFF',
        'comienzo_movimiento'        => 'Comienzo del movimiento',
        'comienzo_movimiento_filter' => 'Comienzo del movimiento (Filter)',
        'cambio_controlador'         => 'Cambio de controlador',
        'autorizacion_conductor'     => 'Autorización de cambio de conductor',
        'geocerca_entrada'           => 'Geocerca de Entrada',
        'geocerca_salida'            => 'Geocerca de Salida',
        'geocerca_entrada_salida'    => 'Geocerca de Entrada/Salida',
        'exceso_vel_geocerca'        => 'Exceso de velocidad en geocerca',
        'eventos_personalizados'     => 'Eventos personalizados',
        'sos'                        => 'SOS',
        'combustible'                => 'Combustible (Relleno / Robo)',
        'distancia'                  => 'Distancia',
        'pdi_duracion_parada'        => 'PDI - Duración de la parada',
        'pdi_duracion_inactiva'      => 'PDI - Duración inactiva',
        'desenchufado'               => 'Desenchufado',
        'estado_tarea'               => 'Estado de la tarea',
        'boton_panico' => 'Boton de panico',
    ];

    /** Alertas disponibles para sensores ADAS */
    public const ALERTAS_ADAS = [
        'colision_frontal'       => 'Colisión Frontal',
        'desvio_carril'          => 'Desvío de Carril',
        'deteccion_peatones'     => 'Detección de Peatones',
        'fatiga_conductor'       => 'Fatiga del Conductor',
        'distancia_seguimiento'  => 'Distancia de Seguimiento',
        'conduccion_distraida'   => 'Conducción Distraída',
        'freno_brusco'           => 'Frenado Brusco',
        'aceleracion_brusca'     => 'Aceleración Brusca',
        'giro_brusco'            => 'Giro Brusco',
        'exceso_velocidad'       => 'Exceso de Velocidad',
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
        'boton_panico' => 'Boton de panicó'
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

        // Cascade de dispositivo:
        // 1. Parámetro explícito (Connected)
        // 2. Dispositivo interno reservado para notificaciones (interno = 1, Connected)
        // 3. Cualquier dispositivo conectado del sistema (último recurso)
        if (!$device || $device->status !== 'Connected') {
            $device = Device::where('interno', true)->where('status', 'Connected')->first()
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
                Log::warning("WorkOrder #{$orden->id}: device #{$device->id} ({$device->body}) tiene sesión caída. Marcando como Disconnect.");
                $device->update(['status' => 'Disconnect']);
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
     * Edita el mensaje WA previamente enviado para la orden.
     * Reconstruye el messageKey a partir de wa_group_id + wa_message_id guardados.
     * Retorna true si se editó correctamente, false en caso contrario.
     */
    public function editarMensaje(WorkOrder $orden, ?Device $device = null): bool
    {
        if (empty($orden->wa_message_id) || empty($orden->wa_group_id)) {
            Log::info("WorkOrder #{$orden->id}: sin wa_message_id/wa_group_id, no se edita el mensaje WA.");
            return false;
        }

        if (!$device || $device->status !== 'Connected') {
            $device = Device::where('interno', true)->where('status', 'Connected')->first()
                ?? Device::where('status', 'Connected')->first();
        }

        if (!$device) {
            Log::warning("WorkOrder #{$orden->id}: no hay dispositivo WA conectado para editar mensaje.");
            return false;
        }

        $messageKey = [
            'remoteJid' => $orden->wa_group_id,
            'fromMe'    => true,
            'id'        => $orden->wa_message_id,
        ];

        $mensaje   = $this->formatMensaje($orden);
        $serverUrl = config('whatsapp.node_server_url', 'http://localhost:3000');

        try {
            $response = Http::timeout(30)->post("{$serverUrl}/api/edit-message", [
                'token'      => $device->body,
                'messageKey' => $messageKey,
                'newText'    => $mensaje,
            ]);

            if ($response->successful() && $response->json('status')) {
                Log::info("WorkOrder #{$orden->id}: mensaje WA editado. MsgId: {$orden->wa_message_id}");
                return true;
            }

            Log::warning("WorkOrder #{$orden->id}: edición WA falló. HTTP {$response->status()}. Body: " . $response->body());
            return false;
        } catch (\Throwable $e) {
            Log::error("WorkOrder #{$orden->id}: excepción editando WA: " . $e->getMessage());
            return false;
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
        $meta          = $orden->metadata ?? [];
        $accesorios    = $meta['accesorios'] ?? [];
        $alertas       = $meta['alertas'] ?? [];

        // Operador SIM y modelo de dispositivo (tipo de equipo)
        $operadorSim = !empty($meta['operador_sim']) ? strtoupper($meta['operador_sim']) : null;
        $modeloDisp  = !empty($meta['modelo_dispositivo_id'])
            ? ModelosDispositivo::find((int) $meta['modelo_dispositivo_id'])
            : null;
        $equipoTexto = null;
        if ($modeloDisp) {
            $equipoTexto = trim(
                ($modeloDisp->marca ? strtoupper($modeloDisp->marca) . ' ' : '') . strtoupper($modeloDisp->modelo)
            );
        }
        $listaAcc      = array_values(array_filter(
            array_map(
                fn($key) => isset(self::ACCESORIOS[$key]) ? strtoupper(self::ACCESORIOS[$key]) : null,
                $accesorios
            )
        ));
        $listaAlertas  = array_values(array_filter(
            array_map(
                fn($key) => isset(self::ALERTAS[$key]) ? strtoupper(self::ALERTAS[$key]) : null,
                $alertas
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
            if ($operadorSim) {
                $lineas[] = '📶 *OPERADOR SIM:* ' . $operadorSim;
            }
            if ($equipoTexto) {
                $lineas[] = '📡 *EQUIPO GPS:* ' . $equipoTexto;
            }

            $lineas[] = $sep;
            $lineas[] = '👷 *TÉCNICO:* '       . strtoupper($tecnico->name ?? '-');
            $lineas[] = '📅 *LUGAR Y FECHA:* ' . strtoupper($fecha);

            if (!empty($orden->direccion)) {
                $lineas[] = '📍 *DIRECCIÓN:* ' . strtoupper($orden->direccion);
            }

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

            if (!empty($listaAlertas)) {
                $lineas[] = $sep;
                $lineas[] = '🔔 *ALERTAS GPS:*';
                foreach ($listaAlertas as $alerta) {
                    $lineas[] = '   • ' . $alerta;
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
        if ($operadorSim) {
            $lineas[] = '📶 *OPERADOR SIM:* ' . $operadorSim;
        }
        if ($equipoTexto) {
            $lineas[] = '📡 *EQUIPO GPS:* ' . $equipoTexto;
        }

        $lineas[] = $sep;
        $lineas[] = '👷 *TÉCNICO:* '       . strtoupper($tecnico->name ?? '-');
        $lineas[] = '📅 *LUGAR Y FECHA:* ' . strtoupper($fecha);

        if (!empty($orden->direccion)) {
            $lineas[] = '📍 *DIRECCIÓN:* ' . strtoupper($orden->direccion);
        }

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

        if (!empty($listaAlertas)) {
            $lineas[] = $sep;
            $lineas[] = '🔔 *ALERTAS GPS:*';
            foreach ($listaAlertas as $alerta) {
                $lineas[] = '   • ' . $alerta;
            }
        }

        if ($orden->contacto) {
            $lineas[] = $sep;
            $lineas[] = '👋 *CONTACTO:* ' . $orden->contacto;
        }

        return implode("\n", $lineas);
    }
}
