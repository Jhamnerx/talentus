<!DOCTYPE html>
<html>

<head>
    <title>Reporte Simple - {{ $caja->nombre }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            padding: 15px;
            color: #333;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        .info {
            margin-bottom: 15px;
        }

        .info-row {
            margin: 3px 0;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        table thead {
            background: #333;
            color: white;
        }

        table th,
        table td {
            padding: 6px;
            text-align: left;
            border: 1px solid #000;
            font-size: 10px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totales {
            margin-top: 15px;
            padding: 10px;
            border: 2px solid #000;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
        }

        .total-row.final {
            font-weight: bold;
            font-size: 13px;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid #000;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 9px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>REPORTE SIMPLE - CAJA CHICA</h1>
        <p><strong>{{ config('app.name') }}</strong></p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Información -->
    <div class="info">
        <div class="info-row">
            <span class="info-label">Caja:</span>
            <span>{{ $caja->nombre }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Usuario:</span>
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
            <span class="info-label">Estado:</span>
            <span>{{ $caja->estado ? 'ABIERTA' : 'CERRADA' }}</span>
        </div>
    </div>

    <!-- Tabla Simple -->
    @if ($caja->cashDocuments->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Documento</th>
                    <th style="width: 35%;">Cliente/Proveedor</th>
                    <th class="text-center" style="width: 15%;">Fecha</th>
                    <th class="text-center" style="width: 10%;">Tipo</th>
                    <th class="text-right" style="width: 15%;">Monto</th>
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
                        <td>{{ $tipo }} {{ $doc->serie ?? 'N/A' }}-{{ $doc->numero ?? 'N/A' }}</td>
                        <td>{{ $doc->cliente_nombre ?? ($doc->proveedor ?? 'N/A') }}</td>
                        <td class="text-center">{{ $doc->fecha_emision ?? ($doc->fecha ?? 'N/A') }}</td>
                        <td class="text-center">{{ $esIngreso ? 'ING' : 'EGR' }}</td>
                        <td class="text-right">S/ {{ number_format($montoPen, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; padding: 20px;">No hay documentos registrados.</p>
    @endif

    <!-- Totales -->
    <div class="totales">
        <div class="total-row">
            <span>Saldo Inicial:</span>
            <span>S/ {{ number_format($caja->saldo_inicial, 2) }}</span>
        </div>
        <div class="total-row">
            <span>Total Ingresos:</span>
            <span>S/ {{ number_format($totales['ingresos'], 2) }}</span>
        </div>
        <div class="total-row">
            <span>Total Egresos:</span>
            <span>S/ {{ number_format($totales['egresos'], 2) }}</span>
        </div>
        <div class="total-row final">
            <span>SALDO FINAL:</span>
            <span>S/ {{ number_format($totales['saldo_final'], 2) }}</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>{{ config('app.name') }} - {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
