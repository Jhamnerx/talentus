<!DOCTYPE html>
<html>

<head>
    <title>Ticket - {{ $caja->nombre }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            padding: 5px;
            color: #000;
            font-size: 9px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
        }

        .header h1 {
            font-size: 12px;
            margin-bottom: 3px;
        }

        .header p {
            margin: 2px 0;
            font-size: 8px;
        }

        .info-section {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 8px;
        }

        .info-label {
            font-weight: bold;
        }

        .info-value {
            text-align: right;
        }

        .doc-item {
            border-bottom: 1px dotted #ccc;
            padding: 5px 0;
            font-size: 8px;
        }

        .doc-header {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .doc-detail {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
            font-size: 7px;
        }

        .tipo-badge {
            display: inline-block;
            padding: 1px 4px;
            font-size: 7px;
            font-weight: bold;
        }

        .totales {
            margin-top: 10px;
            border-top: 2px solid #000;
            padding-top: 8px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 9px;
        }

        .total-row.final {
            font-weight: bold;
            font-size: 11px;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid #000;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 7px;
            border-top: 1px dashed #000;
            padding-top: 8px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <p>REPORTE CAJA CHICA</p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Información de la Caja -->
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">CAJA:</span>
            <span class="info-value">{{ $caja->nombre }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">USUARIO:</span>
            <span class="info-value">{{ $caja->user->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">F. APERTURA:</span>
            <span class="info-value">{{ $caja->fecha_apertura?->format('d/m/Y H:i') ?? 'N/A' }}</span>
        </div>
        @if (!$caja->estado)
            <div class="info-row">
                <span class="info-label">F. CIERRE:</span>
                <span class="info-value">{{ $caja->fecha_cierre?->format('d/m/Y H:i') ?? 'N/A' }}</span>
            </div>
        @endif
        <div class="info-row">
            <span class="info-label">ESTADO:</span>
            <span class="info-value">{{ $caja->estado ? 'ABIERTA' : 'CERRADA' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">SALDO INICIAL:</span>
            <span class="info-value">S/ {{ number_format($caja->saldo_inicial, 2) }}</span>
        </div>
    </div>

    <!-- Documentos -->
    @php
        $movimientos = $caja->globalDestination()->with('paymentable')->get();
    @endphp
    @if ($movimientos->count() > 0)
        @foreach ($movimientos as $payment)
            @php
                $paymentable = $payment->paymentable;
                $tipo = $payment->payment_type_description;
                $numero = $payment->document_number;
                $persona = $payment->person_name;
                $tipoMov = $payment->type_movement;
            @endphp
            <div class="doc-item">
                <div class="doc-header">
                    <span>{{ $tipo }} {{ $numero }}</span>
                    <span class="tipo-badge">{{ $tipoMov === 'INGRESO' ? 'ING' : 'EGR' }}</span>
                </div>
                <div class="doc-detail">
                    <span>{{ Str::limit($doc->cliente_nombre ?? ($doc->proveedor ?? 'N/A'), 25) }}</span>
                </div>
                <div class="doc-detail">
                    <span>{{ $doc->fecha_emision ?? ($doc->fecha ?? 'N/A') }}</span>
                    <span>{{ $moneda }} {{ number_format($monto, 2) }}</span>
                </div>
                @if ($moneda != 'PEN')
                    <div class="doc-detail">
                        <span>Equiv. PEN:</span>
                        <span>S/ {{ number_format($montoPen, 2) }}</span>
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="text-center" style="padding: 15px 0;">
            Sin documentos
        </div>
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
        <p>{{ config('app.name') }}</p>
        <p>{{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
