<!DOCTYPE html>
<html>

<head>
    <title>Resumen Operaciones Diarias - {{ $caja->nombre }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            color: #333;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 10px;
        }

        .header h1 {
            color: #4F46E5;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .header p {
            margin: 3px 0;
            color: #666;
            font-size: 10px;
        }

        .info-box {
            background: #F3F4F6;
            border: 1px solid #D1D5DB;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 20px;
        }

        .info-row {
            margin: 4px 0;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 140px;
        }

        .section-title {
            background: #4F46E5;
            color: white;
            padding: 8px 10px;
            margin: 20px 0 10px 0;
            font-weight: bold;
            font-size: 12px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .stats-row {
            display: table-row;
        }

        .stats-cell {
            display: table-cell;
            width: 50%;
            padding: 10px;
            vertical-align: top;
        }

        .stat-box {
            background: #F3F4F6;
            border: 1px solid #D1D5DB;
            border-radius: 5px;
            padding: 12px;
            height: 100%;
        }

        .stat-box.ingreso {
            border-left: 4px solid #10B981;
        }

        .stat-box.egreso {
            border-left: 4px solid #EF4444;
        }

        .stat-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 8px;
            color: #374151;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            margin: 8px 0;
        }

        .stat-value.ingreso {
            color: #10B981;
        }

        .stat-value.egreso {
            color: #EF4444;
        }

        .stat-detail {
            font-size: 10px;
            color: #6B7280;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background: #374151;
            color: white;
        }

        table th,
        table td {
            padding: 8px 5px;
            text-align: left;
            border: 1px solid #D1D5DB;
            font-size: 10px;
        }

        table tbody tr:nth-child(even) {
            background: #F9FAFB;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totales-summary {
            background: #EEF2FF;
            border: 2px solid #4F46E5;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }

        .totales-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-weight: 600;
        }

        .totales-final {
            font-size: 16px;
            padding-top: 10px;
            margin-top: 10px;
            border-top: 2px solid #4F46E5;
            color: #4F46E5;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #6B7280;
            font-size: 9px;
            border-top: 1px solid #E5E7EB;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>RESUMEN DE OPERACIONES DIARIAS</h1>
        <p><strong>{{ config('app.name') }}</strong></p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Información de la Caja -->
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Caja:</span>
            <span>{{ $caja->nombre }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Usuario Responsable:</span>
            <span>{{ $caja->user->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Fecha Apertura:</span>
            <span>{{ $caja->fecha_apertura?->format('d/m/Y H:i') ?? 'N/A' }}</span>
        </div>
        @if (!$caja->estado)
            <div class="info-row">
                <span class="info-label">Fecha Cierre:</span>
                <span>{{ $caja->fecha_cierre?->format('d/m/Y H:i') ?? 'N/A' }}</span>
            </div>
        @endif
        <div class="info-row">
            <span class="info-label">Estado Actual:</span>
            <span>{{ $caja->estado ? 'ABIERTA' : 'CERRADA' }}</span>
        </div>
    </div>

    <!-- Resumen de Movimientos -->
    <div class="section-title">RESUMEN DE MOVIMIENTOS</div>

    <div class="stats-grid">
        <div class="stats-row">
            <div class="stats-cell">
                <div class="stat-box ingreso">
                    <div class="stat-title">INGRESOS</div>
                    <div class="stat-value ingreso">S/ {{ number_format($totales['ingresos'], 2) }}</div>
                    <div class="stat-detail">
                        Documentos:
                        {{ $caja->cashDocuments->filter(function ($doc) {
                                return $doc->factura_id || $doc->recibo_id || $doc->venta_id;
                            })->count() }}
                    </div>
                </div>
            </div>
            <div class="stats-cell">
                <div class="stat-box egreso">
                    <div class="stat-title">EGRESOS</div>
                    <div class="stat-value egreso">S/ {{ number_format($totales['egresos'], 2) }}</div>
                    <div class="stat-detail">
                        Documentos:
                        {{ $caja->cashDocuments->filter(function ($doc) {
                                return $doc->expense_payment_id || $doc->compra_id;
                            })->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalle por Tipo de Documento -->
    <div class="section-title">DETALLE POR TIPO DE DOCUMENTO</div>

    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Tipo Documento</th>
                <th class="text-center" style="width: 15%;">Cantidad</th>
                <th class="text-center" style="width: 15%;">Movimiento</th>
                <th class="text-right" style="width: 25%;">Monto PEN</th>
                <th class="text-right" style="width: 25%;">% del Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $documentosPorTipo = $movimientos->groupBy(function ($gp) {
                    return $gp->payment_type_description;
                });
            @endphp

            @foreach ($documentosPorTipo as $tipo => $documentos)
                @php
                    $cantidad = $documentos->count();
                    $totalTipo = 0;
                    $esIngreso = false;

                    foreach ($documentos as $doc) {
                        $documento = $doc->getDocumento();
                        $moneda = $documento->moneda ?? 'PEN';
                        $monto = $documento->total_a_pagar ?? ($documento->total ?? 0);
                        $totalTipo += $caja->convertirAPen($monto, $moneda);

                        if ($doc->factura_id || $doc->recibo_id || $doc->venta_id) {
                            $esIngreso = true;
                        }
                    }

                    $totalGeneral = $totales['ingresos'] + $totales['egresos'];
                    $porcentaje = $totalGeneral > 0 ? ($totalTipo / $totalGeneral) * 100 : 0;
                @endphp
                <tr>
                    <td>{{ $tipo }}</td>
                    <td class="text-center">{{ $cantidad }}</td>
                    <td class="text-center">{{ $esIngreso ? 'Ingreso' : 'Egreso' }}</td>
                    <td class="text-right">S/ {{ number_format($totalTipo, 2) }}</td>
                    <td class="text-right">{{ number_format($porcentaje, 1) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totales Finales -->
    <div class="totales-summary">
        <div class="totales-row">
            <span>Saldo Inicial:</span>
            <span>S/ {{ number_format($caja->saldo_inicial, 2) }}</span>
        </div>
        <div class="totales-row">
            <span>Total Ingresos:</span>
            <span style="color: #10B981;">+ S/ {{ number_format($totales['ingresos'], 2) }}</span>
        </div>
        <div class="totales-row">
            <span>Total Egresos:</span>
            <span style="color: #EF4444;">- S/ {{ number_format($totales['egresos'], 2) }}</span>
        </div>
        <div class="totales-row totales-final">
            <span>SALDO FINAL:</span>
            <span>S/ {{ number_format($totales['saldo_final'], 2) }}</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Documento generado automáticamente por {{ config('app.name') }}</p>
        <p>Fecha de impresión: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
