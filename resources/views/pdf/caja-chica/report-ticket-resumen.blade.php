<!DOCTYPE html>
<html>

<head>
    <title>Ticket Resumen - {{ $caja->nombre }}</title>
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
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 8px;
        }

        .header h1 {
            font-size: 13px;
            margin-bottom: 3px;
        }

        .header p {
            margin: 2px 0;
            font-size: 9px;
        }

        .info-box {
            background: #f5f5f5;
            border: 1px solid #000;
            padding: 8px;
            margin-bottom: 10px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 9px;
        }

        .info-label {
            font-weight: bold;
        }

        .summary-section {
            margin: 10px 0;
            padding: 10px 0;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 10px;
        }

        .summary-row.highlight {
            font-weight: bold;
            font-size: 12px;
            padding: 5px 0;
            border-top: 1px dashed #000;
            margin-top: 8px;
        }

        .count-section {
            margin: 10px 0;
            font-size: 9px;
        }

        .count-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 8px;
            border-top: 1px dashed #000;
            padding-top: 8px;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <p>RESUMEN CAJA CHICA</p>
        <p>{{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Información de la Caja -->
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">CAJA:</span>
            <span>{{ $caja->nombre }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">USUARIO:</span>
            <span>{{ $caja->user->name ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">APERTURA:</span>
            <span>{{ $caja->fecha_apertura?->format('d/m/Y H:i') ?? 'N/A' }}</span>
        </div>
        @if (!$caja->estado)
            <div class="info-row">
                <span class="info-label">CIERRE:</span>
                <span>{{ $caja->fecha_cierre?->format('d/m/Y H:i') ?? 'N/A' }}</span>
            </div>
        @endif
        <div class="info-row">
            <span class="info-label">ESTADO:</span>
            <span>{{ $caja->estado ? 'ABIERTA' : 'CERRADA' }}</span>
        </div>
    </div>

    <!-- Conteo de Documentos -->
    <div class="count-section">
        <div class="count-row">
            <span class="info-label">Total Documentos:</span>
            <span>{{ $caja->cashDocuments->count() }}</span>
        </div>
        <div class="count-row">
            <span class="info-label">Ingresos:</span>
            <span>
                {{ $caja->cashDocuments->filter(function ($doc) {
                        return $doc->factura_id || $doc->recibo_id || $doc->venta_id;
                    })->count() }}
            </span>
        </div>
        <div class="count-row">
            <span class="info-label">Egresos:</span>
            <span>
                {{ $caja->cashDocuments->filter(function ($doc) {
                        return $doc->expense_payment_id || $doc->compra_id;
                    })->count() }}
            </span>
        </div>
    </div>

    <!-- Resumen Financiero -->
    <div class="summary-section">
        <div class="summary-row">
            <span>Saldo Inicial:</span>
            <span>S/ {{ number_format($caja->saldo_inicial, 2) }}</span>
        </div>
        <div class="summary-row">
            <span>Total Ingresos:</span>
            <span style="color: green;">+ S/ {{ number_format($totales['ingresos'], 2) }}</span>
        </div>
        <div class="summary-row">
            <span>Total Egresos:</span>
            <span style="color: red;">- S/ {{ number_format($totales['egresos'], 2) }}</span>
        </div>
        <div class="summary-row highlight">
            <span>SALDO FINAL:</span>
            <span>S/ {{ number_format($totales['saldo_final'], 2) }}</span>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>{{ config('app.name') }}</p>
        <p>Impreso: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
