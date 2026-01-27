<!DOCTYPE html>
<html>

<head>
    <title>Ingresos y Egresos - {{ $caja->nombre }}</title>
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
            width: 120px;
        }

        .section-title {
            background: #065F46;
            color: white;
            padding: 8px 10px;
            margin: 20px 0 10px 0;
            font-weight: bold;
            font-size: 12px;
        }

        .section-title.egreso {
            background: #991B1B;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background: #065F46;
            color: white;
        }

        table.egreso thead {
            background: #991B1B;
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

        .subtotal {
            background: #EEF2FF !important;
            font-weight: bold;
        }

        .totales {
            background: #EEF2FF;
            border: 2px solid #4F46E5;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
        }

        .totales-table {
            width: 100%;
        }

        .totales-row {
            display: table-row;
        }

        .totales-label {
            display: table-cell;
            font-weight: 600;
            padding: 5px 0;
            width: 70%;
        }

        .totales-value {
            display: table-cell;
            text-align: right;
            padding: 5px 0;
            font-weight: 600;
        }

        .totales-final {
            font-size: 14px;
            padding-top: 10px;
            margin-top: 10px;
            border-top: 2px solid #4F46E5;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            color: #6B7280;
            font-size: 9px;
            border-top: 1px solid #E5E7EB;
            padding-top: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 20px;
            color: #9CA3AF;
            font-style: italic;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>REPORTE DE INGRESOS Y EGRESOS</h1>
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
            <span class="info-label">Usuario:</span>
            <span>{{ $caja->user->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Período:</span>
            <span>{{ $caja->fecha_apertura?->format('d/m/Y H:i') ?? 'N/A' }}
                @if (!$caja->estado)
                    - {{ $caja->fecha_cierre?->format('d/m/Y H:i') ?? 'N/A' }}
                @endif
            </span>
        </div>
    </div>

    <!-- Sección INGRESOS -->
    <div class="section-title">INGRESOS</div>
    @php
        $ingresos = $caja->cashDocuments->filter(function ($doc) {
            return $doc->factura_id || $doc->recibo_id || $doc->venta_id;
        });
    @endphp

    @if ($ingresos->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 12%;">Tipo</th>
                    <th style="width: 15%;">Documento</th>
                    <th style="width: 12%;">Fecha</th>
                    <th style="width: 38%;">Cliente</th>
                    <th class="text-center" style="width: 8%;">Moneda</th>
                    <th class="text-right" style="width: 15%;">Monto PEN</th>
                </tr>
            </thead>
            <tbody>
                @php $totalIngresos = 0; @endphp
                @foreach ($ingresos as $documento)
                    @php
                        $doc = $documento->getDocumento();
                        $tipo = $documento->getTipoDocumento();
                        $moneda = $doc->moneda ?? 'PEN';
                        $monto = $doc->total_a_pagar ?? ($doc->total ?? 0);
                        $montoPen = $caja->convertirAPen($monto, $moneda);
                        $totalIngresos += $montoPen;
                    @endphp
                    <tr>
                        <td>{{ $tipo }}</td>
                        <td>{{ $doc->serie ?? 'N/A' }}-{{ $doc->numero ?? 'N/A' }}</td>
                        <td>{{ $doc->fecha_emision ?? ($doc->fecha ?? 'N/A') }}</td>
                        <td>{{ $doc->cliente_nombre ?? 'N/A' }}</td>
                        <td class="text-center">{{ $moneda }}</td>
                        <td class="text-right">S/ {{ number_format($montoPen, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal">
                    <td colspan="5" class="text-right"><strong>SUBTOTAL INGRESOS:</strong></td>
                    <td class="text-right"><strong>S/ {{ number_format($totalIngresos, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="empty-state">No hay ingresos registrados.</div>
    @endif

    <!-- Sección EGRESOS -->
    <div class="section-title egreso">EGRESOS</div>
    @php
        $egresos = $caja->cashDocuments->filter(function ($doc) {
            return $doc->expense_payment_id || $doc->compra_id;
        });
    @endphp

    @if ($egresos->count() > 0)
        <table class="egreso">
            <thead>
                <tr>
                    <th style="width: 12%;">Tipo</th>
                    <th style="width: 15%;">Documento</th>
                    <th style="width: 12%;">Fecha</th>
                    <th style="width: 38%;">Proveedor/Concepto</th>
                    <th class="text-center" style="width: 8%;">Moneda</th>
                    <th class="text-right" style="width: 15%;">Monto PEN</th>
                </tr>
            </thead>
            <tbody>
                @php $totalEgresos = 0; @endphp
                @foreach ($egresos as $documento)
                    @php
                        $doc = $documento->getDocumento();
                        $tipo = $documento->getTipoDocumento();
                        $moneda = $doc->moneda ?? 'PEN';
                        $monto = $doc->total_a_pagar ?? ($doc->total ?? 0);
                        $montoPen = $caja->convertirAPen($monto, $moneda);
                        $totalEgresos += $montoPen;
                    @endphp
                    <tr>
                        <td>{{ $tipo }}</td>
                        <td>{{ $doc->serie ?? 'N/A' }}-{{ $doc->numero ?? 'N/A' }}</td>
                        <td>{{ $doc->fecha ?? 'N/A' }}</td>
                        <td>{{ $doc->proveedor ?? ($doc->concepto ?? 'N/A') }}</td>
                        <td class="text-center">{{ $moneda }}</td>
                        <td class="text-right">S/ {{ number_format($montoPen, 2) }}</td>
                    </tr>
                @endforeach
                <tr class="subtotal">
                    <td colspan="5" class="text-right"><strong>SUBTOTAL EGRESOS:</strong></td>
                    <td class="text-right"><strong>S/ {{ number_format($totalEgresos, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="empty-state">No hay egresos registrados.</div>
    @endif

    <!-- Totales Generales -->
    <div class="totales">
        <div class="totales-table">
            <div class="totales-row">
                <div class="totales-label">Saldo Inicial:</div>
                <div class="totales-value">S/ {{ number_format($caja->saldo_inicial, 2) }}</div>
            </div>
            <div class="totales-row">
                <div class="totales-label">Total Ingresos:</div>
                <div class="totales-value" style="color: #065F46;">+ S/ {{ number_format($totales['ingresos'], 2) }}
                </div>
            </div>
            <div class="totales-row">
                <div class="totales-label">Total Egresos:</div>
                <div class="totales-value" style="color: #991B1B;">- S/ {{ number_format($totales['egresos'], 2) }}
                </div>
            </div>
            <div class="totales-row totales-final">
                <div class="totales-label">SALDO FINAL:</div>
                <div class="totales-value" style="color: #4F46E5;">
                    S/ {{ number_format($totales['saldo_final'], 2) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Documento generado automáticamente por {{ config('app.name') }}</p>
        <p>Fecha de impresión: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
