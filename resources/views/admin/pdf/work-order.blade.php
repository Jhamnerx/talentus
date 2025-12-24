<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Trabajo {{ $workOrder->codigo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 10px;
        }

        .badge-pendiente {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-proceso {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-finalizado {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-cancelado {
            background: #fee2e2;
            color: #991b1b;
        }

        .info-section {
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 15px;
        }

        .info-section h2 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            padding: 5px 10px 5px 0;
            font-weight: bold;
            width: 30%;
            color: #6b7280;
        }

        .info-value {
            display: table-cell;
            padding: 5px 0;
        }

        .timeline {
            margin: 20px 0;
        }

        .timeline-item {
            padding: 10px;
            margin-bottom: 10px;
            border-left: 3px solid #2563eb;
            background: #f9fafb;
        }

        .timeline-item .title {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .timeline-item .date {
            color: #6b7280;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #f3f4f6;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #d1d5db;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }

        .signature-box {
            border: 1px solid #d1d5db;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 60px;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h1>ORDEN DE TRABAJO</h1>
        <p>{{ $workOrder->codigo }}</p>
        <span class="badge badge-{{ strtolower($workOrder->estado->value) }}">
            {{ $workOrder->estado->label() }}
        </span>
        @if ($workOrder->bloqueado)
            <span class="badge" style="background: #fee2e2; color: #991b1b;">BLOQUEADA</span>
        @endif
    </div>

    <!-- Información General -->
    <div class="info-section">
        <h2>Información General</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Tipo de Orden:</div>
                <div class="info-value">{{ $workOrder->tipo_data['nombre'] ?? $workOrder->tipo->nombre }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Costo Base:</div>
                <div class="info-value">S/ {{ number_format($workOrder->tipo_data['costo_base'] ?? 0, 2) }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Vehículo:</div>
                <div class="info-value">{{ $workOrder->vehiculo->placa }} - {{ $workOrder->vehiculo->marca }}
                    {{ $workOrder->vehiculo->modelo }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Cliente:</div>
                <div class="info-value">{{ $workOrder->cliente->nombres }} -
                    {{ $workOrder->cliente->numero_documento }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Técnico Asignado:</div>
                <div class="info-value">{{ $workOrder->tecnico->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Fecha Programada:</div>
                <div class="info-value">{{ $workOrder->fecha_programada->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Creado Por:</div>
                <div class="info-value">{{ $workOrder->creador->name }} -
                    {{ $workOrder->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="info-section">
        <h2>Timeline de Progreso</h2>
        <div class="timeline">
            <div class="timeline-item">
                <div class="title">Orden Creada</div>
                <div class="date">{{ $workOrder->created_at->format('d/m/Y H:i') }} - Por
                    {{ $workOrder->creador->name }}</div>
            </div>

            @if ($workOrder->fecha_inicio)
                <div class="timeline-item">
                    <div class="title">Trabajo Iniciado</div>
                    <div class="date">{{ $workOrder->fecha_inicio->format('d/m/Y H:i') }}</div>
                </div>
            @endif

            @if ($workOrder->fecha_finalizacion)
                <div class="timeline-item">
                    <div class="title">Trabajo Finalizado</div>
                    <div class="date">{{ $workOrder->fecha_finalizacion->format('d/m/Y H:i') }}</div>
                </div>
            @endif

            @if ($workOrder->fecha_cerrado)
                <div class="timeline-item">
                    <div class="title">Orden Cerrada y Bloqueada</div>
                    <div class="date">{{ $workOrder->fecha_cerrado->format('d/m/Y H:i') }}</div>
                </div>
            @endif

            @if ($workOrder->estado === \App\Enums\WorkOrderStatus::CANCELADO)
                <div class="timeline-item" style="border-left-color: #dc2626;">
                    <div class="title">Orden Cancelada</div>
                    <div class="date">{{ $workOrder->updated_at->format('d/m/Y H:i') }}</div>
                    @if ($workOrder->motivo_cancelacion)
                        <div style="margin-top: 5px;">Motivo: {{ $workOrder->motivo_cancelacion }}</div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Checklist -->
    @if ($workOrder->checklists->count() > 0)
        <div class="info-section">
            <h2>Checklist de Inspección</h2>

            @php
                $checklistBefore = $workOrder->checklists->where('fase', 'before');
                $checklistAfter = $workOrder->checklists->where('fase', 'after');
            @endphp

            @if ($checklistBefore->count() > 0)
                <h3 style="margin-top: 15px; font-size: 14px; color: #2563eb;">✓ Antes del Trabajo</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 35%;">Categoría / Ítem</th>
                            <th style="width: 15%; text-align: center;">Resultado</th>
                            <th style="width: 50%;">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checklistBefore->groupBy('template.categoria') as $categoria => $items)
                            <tr style="background: #f9fafb;">
                                <td colspan="3" style="font-weight: bold; color: #1f2937; padding: 6px 8px;">
                                    {{ strtoupper($categoria) }}
                                </td>
                            </tr>
                            @foreach ($items as $item)
                                <tr>
                                    <td style="padding-left: 20px;">{{ $item->template->nombre }}</td>
                                    <td style="text-align: center;">
                                        @if ($item->resultado->value === 'ok')
                                            <span
                                                style="background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">✓
                                                OK</span>
                                        @elseif($item->resultado->value === 'observado')
                                            <span
                                                style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">⚠
                                                OBSERVADO</span>
                                        @else
                                            <span
                                                style="background: #e5e7eb; color: #6b7280; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">—
                                                N/A</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 11px;">{{ $item->observaciones ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if ($checklistAfter->count() > 0)
                <h3 style="margin-top: 20px; font-size: 14px; color: #10b981;">✓ Después del Trabajo</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 35%;">Categoría / Ítem</th>
                            <th style="width: 15%; text-align: center;">Resultado</th>
                            <th style="width: 50%;">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checklistAfter->groupBy('template.categoria') as $categoria => $items)
                            <tr style="background: #f9fafb;">
                                <td colspan="3" style="font-weight: bold; color: #1f2937; padding: 6px 8px;">
                                    {{ strtoupper($categoria) }}
                                </td>
                            </tr>
                            @foreach ($items as $item)
                                <tr>
                                    <td style="padding-left: 20px;">{{ $item->template->nombre }}</td>
                                    <td style="text-align: center;">
                                        @if ($item->resultado->value === 'ok')
                                            <span
                                                style="background: #d1fae5; color: #065f46; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">✓
                                                OK</span>
                                        @elseif($item->resultado->value === 'observado')
                                            <span
                                                style="background: #fef3c7; color: #92400e; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">⚠
                                                OBSERVADO</span>
                                        @else
                                            <span
                                                style="background: #e5e7eb; color: #6b7280; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: bold;">—
                                                N/A</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 11px;">{{ $item->observaciones ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endif

    <!-- Dispositivos -->
    @if ($workOrder->deviceHistory->count() > 0)
        <div class="info-section">
            <h2>Historial de Dispositivos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Identificador</th>
                        <th>Acción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workOrder->deviceHistory as $history)
                        @if ($history->accion_imei !== 'ninguna')
                            <tr>
                                <td>IMEI</td>
                                <td>{{ $history->imei }}</td>
                                <td>{{ ucfirst($history->accion_imei) }}</td>
                                <td>{{ optional($history->fecha_instalacion)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endif
                        @if ($history->accion_sim !== 'ninguna')
                            <tr>
                                <td>SIM</td>
                                <td>{{ $history->numero_linea }}</td>
                                <td>{{ ucfirst($history->accion_sim) }}</td>
                                <td>{{ optional($history->fecha_instalacion)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Accesorios -->
    @if ($workOrder->accessories->count() > 0)
        <div class="info-section">
            <h2>Accesorios Instalados/Retirados</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Acción</th>
                        <th>P. Unitario</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workOrder->accessories as $accessory)
                        <tr>
                            <td>{{ $accessory->nombre }}</td>
                            <td>{{ $accessory->cantidad }}</td>
                            <td>{{ ucfirst($accessory->accion) }}</td>
                            <td>S/ {{ number_format($accessory->precio_unitario, 2) }}</td>
                            <td>S/ {{ number_format($accessory->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr style="font-weight: bold;">
                        <td colspan="4" style="text-align: right;">TOTAL:</td>
                        <td>S/ {{ number_format($workOrder->accessories->sum('subtotal'), 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    <!-- Observaciones -->
    @if ($workOrder->observaciones_inicial || $workOrder->observaciones_tecnico || $workOrder->observaciones_final)
        <div class="info-section">
            <h2>Observaciones</h2>

            @if ($workOrder->observaciones_inicial)
                <div style="margin-bottom: 10px;">
                    <strong>Observaciones Iniciales:</strong><br>
                    {{ $workOrder->observaciones_inicial }}
                </div>
            @endif

            @if ($workOrder->observaciones_tecnico)
                <div style="margin-bottom: 10px;">
                    <strong>Observaciones del Técnico:</strong><br>
                    {{ $workOrder->observaciones_tecnico }}
                </div>
            @endif

            @if ($workOrder->observaciones_final)
                <div style="margin-bottom: 10px;">
                    <strong>Observaciones Finales:</strong><br>
                    {{ $workOrder->observaciones_final }}
                </div>
            @endif
        </div>
    @endif

    <!-- Firmas -->
    @if ($workOrder->signatures->count() > 0)
        <div class="info-section" style="page-break-inside: avoid;">
            <h2>Firmas Digitales</h2>

            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">Tipo</th>
                        <th style="width: 25%;">Firmante</th>
                        <th style="width: 15%;">Documento</th>
                        <th style="width: 20%;">Fecha</th>
                        <th style="width: 25%; text-align: center;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workOrder->signatures as $signature)
                        <tr>
                            <td style="font-weight: bold;">{{ ucfirst($signature->tipo) }}</td>
                            <td>{{ $signature->nombre_firmante }}
                                @if ($signature->tipo_firmante)
                                    <br><span
                                        style="font-size: 10px; color: #6b7280;">({{ ucfirst($signature->tipo_firmante) }})</span>
                                @endif
                            </td>
                            <td>{{ $signature->documento_firmante ?? '-' }}</td>
                            <td>{{ $signature->firmado_at->format('d/m/Y H:i') }}</td>
                            <td style="text-align: center;">
                                @if ($signature->verificarIntegridad())
                                    <span
                                        style="background: #d1fae5; color: #065f46; padding: 3px 10px; border-radius: 4px; font-size: 10px; font-weight: bold;">✓
                                        VERIFICADA</span>
                                @else
                                    <span
                                        style="background: #fee2e2; color: #991b1b; padding: 3px 10px; border-radius: 4px; font-size: 10px; font-weight: bold;">✗
                                        COMPROMETIDA</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Mostrar imágenes de firmas -->
            @foreach ($workOrder->signatures as $signature)
                @php
                    $signaturePath = storage_path('app/private/' . $signature->path);
                @endphp
                @if (file_exists($signaturePath))
                    <div class="signature-box" style="margin-top: 20px; page-break-inside: avoid;">
                        <h3 style="margin: 0 0 10px 0; font-size: 12px;">Firma de {{ ucfirst($signature->tipo) }} -
                            {{ $signature->nombre_firmante }}</h3>
                        <div style="border: 1px solid #d1d5db; padding: 10px; background: #fff;">
                            <img src="{{ $signaturePath }}" alt="Firma"
                                style="max-width: 300px; max-height: 150px; display: block; margin: 0 auto;">
                        </div>
                        <div style="margin-top: 10px; font-size: 10px; color: #6b7280;">
                            <strong>IP:</strong> {{ $signature->ip_address }} |
                            <strong>Hash:</strong> {{ substr($signature->hash, 0, 16) }}...
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Este documento fue generado automáticamente el {{ now()->format('d/m/Y H:i') }}</p>
        <p>{{ config('app.name') }} - Sistema de Gestión de Órdenes de Trabajo</p>
    </div>

</body>

</html>
