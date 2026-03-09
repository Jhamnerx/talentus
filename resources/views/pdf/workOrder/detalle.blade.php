<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle WO-{{ str_pad($workOrder->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            padding: 10mm 10mm 12mm 10mm;
        }

        @page {
            size: A4;
            margin: 0;
        }

        .info-section {
            margin-bottom: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            padding: 10px 14px;
        }

        .info-section h2 {
            margin: 0 0 8px 0;
            font-size: 13px;
            color: #1f2937;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 4px;
        }

        .section-header {
            background: #1e3a5f;
            color: #fff;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 12px;
            border-radius: 3px;
        }

        /* Timeline */
        .timeline-item {
            padding: 7px 10px;
            margin-bottom: 7px;
            border-left: 3px solid #2563eb;
            background: #f9fafb;
        }

        .timeline-item .tl-title {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 2px;
        }

        .timeline-item .tl-date {
            color: #6b7280;
            font-size: 10px;
        }

        /* Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 10px;
        }

        th {
            background: #f3f4f6;
            padding: 6px 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #d1d5db;
        }

        td {
            padding: 6px 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Firmas */
        .signature-box {
            border: 1px solid #d1d5db;
            padding: 10px;
            margin-top: 12px;
            text-align: center;
            page-break-inside: avoid;
        }

        .footer {
            margin-top: 20px;
            padding-top: 8px;
            border-top: 1px solid #d1d5db;
            text-align: center;
            color: #9ca3af;
            font-size: 9px;
        }
    </style>
</head>

<body>

    <div class="section-header">
        WO-{{ str_pad($workOrder->id, 5, '0', STR_PAD_LEFT) }} &mdash; Detalle de Actividades
    </div>

    <!-- Timeline -->
    <div class="info-section">
        <h2>Timeline de Progreso</h2>

        <div class="timeline-item">
            <div class="tl-title">Orden Creada</div>
            <div class="tl-date">{{ $workOrder->created_at->format('d/m/Y H:i') }}</div>
        </div>

        @if ($workOrder->fecha_inicio)
            <div class="timeline-item">
                <div class="tl-title">Trabajo Iniciado</div>
                <div class="tl-date">{{ $workOrder->fecha_inicio->format('d/m/Y H:i') }}</div>
            </div>
        @endif

        @if ($workOrder->fecha_finalizacion)
            <div class="timeline-item">
                <div class="tl-title">Trabajo Finalizado</div>
                <div class="tl-date">{{ $workOrder->fecha_finalizacion->format('d/m/Y H:i') }}</div>
            </div>
        @endif

        @if ($workOrder->fecha_cerrado)
            <div class="timeline-item">
                <div class="tl-title">Orden Cerrada y Bloqueada</div>
                <div class="tl-date">{{ $workOrder->fecha_cerrado->format('d/m/Y H:i') }}</div>
            </div>
        @endif

        @if ($workOrder->estado === \App\Enums\WorkOrderStatus::CANCELADO)
            <div class="timeline-item" style="border-left-color: #dc2626;">
                <div class="tl-title">Orden Cancelada</div>
                <div class="tl-date">{{ $workOrder->updated_at->format('d/m/Y H:i') }}</div>
                @if ($workOrder->motivo_cancelacion)
                    <div style="margin-top: 3px;">Motivo: {{ $workOrder->motivo_cancelacion }}</div>
                @endif
            </div>
        @endif
    </div>

    <!-- Checklist -->
    @if ($workOrder->checklists->count() > 0)
        @php
            $checklistBefore = $workOrder->checklists->where('fase', 'before');
            $checklistAfter = $workOrder->checklists->where('fase', 'after');
        @endphp
        <div class="info-section">
            <h2>Checklist de Inspección</h2>

            @if ($checklistBefore->count() > 0)
                <h3 style="margin: 10px 0 5px; font-size: 12px; color: #2563eb;">Antes del Trabajo</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 35%;">Categoría / Ítem</th>
                            <th style="width: 15%; text-align: center;">Resultado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checklistBefore->groupBy('template.categoria') as $categoria => $items)
                            <tr style="background: #f9fafb;">
                                <td colspan="3" style="font-weight: bold; color: #1f2937; padding: 5px 8px;">
                                    {{ strtoupper($categoria) }}</td>
                            </tr>
                            @foreach ($items as $item)
                                <tr>
                                    <td style="padding-left: 16px;">{{ $item->template->nombre }}</td>
                                    <td style="text-align: center;">
                                        @if ($item->resultado->value === 'ok')
                                            <span
                                                style="background:#d1fae5;color:#065f46;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">OK</span>
                                        @elseif($item->resultado->value === 'observado')
                                            <span
                                                style="background:#fef3c7;color:#92400e;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">OBSERVADO</span>
                                        @else
                                            <span
                                                style="background:#e5e7eb;color:#6b7280;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->observaciones ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endif

            @if ($checklistAfter->count() > 0)
                <h3 style="margin: 14px 0 5px; font-size: 12px; color: #10b981;">Después del Trabajo</h3>
                <table>
                    <thead>
                        <tr>
                            <th style="width: 35%;">Categoría / Ítem</th>
                            <th style="width: 15%; text-align: center;">Resultado</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($checklistAfter->groupBy('template.categoria') as $categoria => $items)
                            <tr style="background: #f9fafb;">
                                <td colspan="3" style="font-weight: bold; color: #1f2937; padding: 5px 8px;">
                                    {{ strtoupper($categoria) }}</td>
                            </tr>
                            @foreach ($items as $item)
                                <tr>
                                    <td style="padding-left: 16px;">{{ $item->template->nombre }}</td>
                                    <td style="text-align: center;">
                                        @if ($item->resultado->value === 'ok')
                                            <span
                                                style="background:#d1fae5;color:#065f46;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">OK</span>
                                        @elseif($item->resultado->value === 'observado')
                                            <span
                                                style="background:#fef3c7;color:#92400e;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">OBSERVADO</span>
                                        @else
                                            <span
                                                style="background:#e5e7eb;color:#6b7280;padding:2px 7px;border-radius:4px;font-size:9px;font-weight:bold;">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->observaciones ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endif

    <!-- Historial de Dispositivos -->
    @if ($workOrder->deviceHistory->count() > 0)
        <div class="info-section">
            <h2>Historial de Dispositivos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Identificador</th>
                        <th>Acción</th>
                        <th>Ubicación</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workOrder->deviceHistory as $history)
                        @if ($history->accion_imei !== 'ninguna')
                            <tr>
                                <td>IMEI</td>
                                <td style="font-family: monospace;">{{ $history->imei }}</td>
                                <td>{{ ucfirst($history->accion_imei) }}</td>
                                <td>{{ $history->ubicacion ?? '-' }}</td>
                                <td>{{ optional($history->fecha_instalacion)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endif
                        @if ($history->accion_sim !== 'ninguna')
                            <tr>
                                <td>SIM</td>
                                <td style="font-family: monospace;">{{ $history->numero_linea }}</td>
                                <td>{{ ucfirst($history->accion_sim) }}</td>
                                <td>{{ $history->ubicacion ?? '-' }}</td>
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
            <h2>Accesorios Instalados / Retirados</h2>
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
                    <tr style="font-weight: bold; background: #f9fafb;">
                        <td colspan="4" style="text-align: right;">TOTAL:</td>
                        <td>S/ {{ number_format($workOrder->accessories->sum('subtotal'), 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    <!-- Observaciones técnicas -->
    @if ($workOrder->observaciones_inicial || $workOrder->observaciones_tecnico || $workOrder->observaciones_final)
        <div class="info-section">
            <h2>Observaciones</h2>
            @if ($workOrder->observaciones_inicial)
                <div style="margin-bottom: 8px;">
                    <strong>Iniciales:</strong><br>{{ $workOrder->observaciones_inicial }}
                </div>
            @endif
            @if ($workOrder->observaciones_tecnico)
                <div style="margin-bottom: 8px;">
                    <strong>Del Técnico:</strong><br>{{ $workOrder->observaciones_tecnico }}
                </div>
            @endif
            @if ($workOrder->observaciones_final)
                <div>
                    <strong>Finales:</strong><br>{{ $workOrder->observaciones_final }}
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
                                        style="font-size: 9px; color: #6b7280;">({{ ucfirst($signature->tipo_firmante) }})</span>
                                @endif
                            </td>
                            <td>{{ $signature->documento_firmante ?? '-' }}</td>
                            <td>{{ $signature->firmado_at->format('d/m/Y H:i') }}</td>
                            <td style="text-align: center;">
                                @if ($signature->verificarIntegridad())
                                    <span
                                        style="background:#d1fae5;color:#065f46;padding:2px 8px;border-radius:4px;font-size:9px;font-weight:bold;">VERIFICADA</span>
                                @else
                                    <span
                                        style="background:#fee2e2;color:#991b1b;padding:2px 8px;border-radius:4px;font-size:9px;font-weight:bold;">COMPROMETIDA</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @foreach ($workOrder->signatures as $signature)
                @php $signaturePath = storage_path('app/private/' . $signature->path); @endphp
                @if (file_exists($signaturePath))
                    <div class="signature-box">
                        <h3 style="margin: 0 0 8px 0; font-size: 11px;">
                            Firma de {{ ucfirst($signature->tipo) }} — {{ $signature->nombre_firmante }}
                        </h3>
                        <div style="border: 1px solid #d1d5db; padding: 8px; background: #fff;">
                            <img src="{{ $signaturePath }}" alt="Firma"
                                style="max-width: 280px; max-height: 130px; display: block; margin: 0 auto;">
                        </div>
                        <div style="margin-top: 6px; font-size: 9px; color: #6b7280;">
                            <strong>IP:</strong> {{ $signature->ip_address }} &nbsp;|&nbsp;
                            <strong>Hash:</strong> {{ substr($signature->hash, 0, 16) }}...
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Generado automáticamente el {{ now()->format('d/m/Y H:i') }} &nbsp;·&nbsp; {{ config('app.name') }}</p>
    </div>

</body>

</html>
