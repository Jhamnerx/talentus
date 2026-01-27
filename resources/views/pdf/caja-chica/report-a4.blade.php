<!DOCTYPE html>
<html>

<head>
    <title>Reporte Caja Chica - {{ $caja->nombre }}</title>
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
            margin-bottom: 15px;
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
            font-weight: bold;
            color: #374151;
            padding: 4px 10px 4px 0;
            width: 25%;
        }

        .info-value {
            display: table-cell;
            color: #1F2937;
            padding: 4px 0;
        }

        .status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }

        .status-open {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-closed {
            background: #E5E7EB;
            color: #374151;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table thead {
            background: #4F46E5;
            color: white;
        }

        table th {
            padding: 8px 5px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid #3730A3;
        }

        table td {
            padding: 6px 5px;
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

        .tipo-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 600;
        }

        .tipo-ingreso {
            background: #D1FAE5;
            color: #065F46;
        }

        .tipo-egreso {
            background: #FEE2E2;
            color: #991B1B;
        }

        .totales {
            background: #EEF2FF;
            border: 2px solid #4F46E5;
            border-radius: 5px;
            padding: 12px;
            margin-top: 15px;
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
            color: #374151;
            padding: 5px 10px 5px 0;
            width: 70%;
        }

        .totales-value {
            display: table-cell;
            color: #1F2937;
            text-align: right;
            padding: 5px 0;
            font-weight: 600;
        }

        .totales-final {
            font-size: 13px;
            padding-top: 8px;
            margin-top: 8px;
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

        .moneda {
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 30px;
            color: #9CA3AF;
            font-style: italic;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>REPORTE DE CAJA CHICA</h1>
        <p><strong>{{ config('app.name') }}</strong></p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Información de la Caja -->
    <div class="info-box">
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Caja:</div>
                <div class="info-value"><strong>{{ $caja->nombre }}</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Usuario:</div>
                <div class="info-value">{{ $caja->user->name ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Fecha Apertura:</div>
                <div class="info-value">{{ $caja->fecha_apertura?->format('d/m/Y H:i') ?? 'N/A' }}</div>
            </div>
            @if (!$caja->estado)
                <div class="info-row">
                    <div class="info-label">Fecha Cierre:</div>
                    <div class="info-value">{{ $caja->fecha_cierre?->format('d/m/Y H:i') ?? 'N/A' }}</div>
                </div>
            @endif
            <div class="info-row">
                <div class="info-label">Estado:</div>
                <div class="info-value">
                    <span class="status {{ $caja->estado ? 'status-open' : 'status-closed' }}">
                        {{ $caja->estado ? 'ABIERTA' : 'CERRADA' }}
                    </span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Saldo Inicial:</div>
                <div class="info-value"><span class="moneda">S/ {{ number_format($caja->saldo_inicial, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Documentos -->
    @if ($caja->cashDocuments->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">Tipo</th>
                    <th style="width: 15%;">Documento</th>
                    <th style="width: 12%;">Fecha</th>
                    <th style="width: 25%;">Cliente/Proveedor</th>
                    <th style="width: 8%;">Moneda</th>
                    <th class="text-right" style="width: 12%;">Monto</th>
                    <th class="text-right" style="width: 12%;">Monto PEN</th>
                    <th style="width: 8%;">Tipo Mov.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($caja->cashDocuments as $documento)
                    @php
                        $doc = $documento->getDocumento();
                        $esIngreso =
                            $documento->factura_id || $documento->recibo_id || $documento->venta_id ? true : false;
                        $tipo = $documento->getTipoDocumento();
                        $moneda = $doc->moneda ?? 'PEN';
                        $monto = $doc->total_a_pagar ?? ($doc->total ?? 0);
                        $montoPen = $caja->convertirAPen($monto, $moneda);
                    @endphp
                    <tr>
                        <td class="text-center">{{ $tipo }}</td>
                        <td>{{ $doc->serie ?? 'N/A' }}-{{ $doc->numero ?? 'N/A' }}</td>
                        <td>{{ $doc->fecha_emision ?? ($doc->fecha ?? 'N/A') }}</td>
                        <td>{{ $doc->cliente_nombre ?? ($doc->proveedor ?? 'N/A') }}</td>
                        <td class="text-center">{{ $moneda }}</td>
                        <td class="text-right">{{ number_format($monto, 2) }}</td>
                        <td class="text-right">{{ number_format($montoPen, 2) }}</td>
                        <td class="text-center">
                            <span class="tipo-badge {{ $esIngreso ? 'tipo-ingreso' : 'tipo-egreso' }}">
                                {{ $esIngreso ? 'INGRESO' : 'EGRESO' }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            No hay documentos registrados en esta caja.
        </div>
    @endif

    <!-- Totales -->
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
                <div class="totales-value" style="color: #4F46E5; font-size: 14px;">
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
