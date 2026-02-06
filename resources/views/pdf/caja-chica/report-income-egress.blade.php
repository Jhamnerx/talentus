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

        .totales-table table {
            width: 100%;
            border: none;
            margin-bottom: 0;
        }

        .totales-table td {
            border: none;
            padding: 5px 0;
        }

        .totales-label {
            font-weight: 600;
            padding: 5px 0;
            width: 70%;
        }

        .totales-value {
            text-align: right;
            padding: 5px 0;
            font-weight: 600;
        }

        .totales-final td {
            font-size: 14px;
            padding-top: 10px;
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
        $ingresos = $caja
            ->globalDestination()
            ->with('payment.paymentable')
            ->get()
            ->filter(fn($gp) => $gp->type_movement === 'INGRESO');
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
                    <th class="text-right" style="width: 15%;">Monto</th>
                </tr>
            </thead>
            <tbody>
                @php $totalIngresos = 0; @endphp
                @foreach ($ingresos as $globalPayment)
                    @php
                        $payment = $globalPayment->payment;
                        $doc = $payment?->paymentable;
                        $monto = $payment?->monto ?? 0;
                        $totalIngresos += $monto;
                        $tipo = $globalPayment->payment_type_description;
                        $numero = $globalPayment->document_number;
                        $fecha = $payment?->fecha ?? $globalPayment->created_at->format('d/m/Y');
                        $cliente = $globalPayment->person_name;
                    @endphp
                    <tr>
                        <td>{{ $tipo }}</td>
                        <td>{{ $numero }}</td>
                        <td>{{ $fecha }}</td>
                        <td>{{ $cliente }}</td>
                        <td class="text-center">PEN</td>
                        <td class="text-right">S/ {{ number_format($monto, 2) }}</td>
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
        $egresos = $caja
            ->globalDestination()
            ->with('payment.paymentable')
            ->get()
            ->filter(fn($gp) => $gp->type_movement === 'EGRESO');
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
                    <th class="text-right" style="width: 15%;">Monto</th>
                </tr>
            </thead>
            <tbody>
                @php $totalEgresos = 0; @endphp
                @foreach ($egresos as $globalPayment)
                    @php
                        $payment = $globalPayment->payment;
                        $monto = $payment?->monto ?? 0;
                        $totalEgresos += $monto;
                        $tipo = $globalPayment->payment_type_description;
                        $numero = $globalPayment->document_number;
                        $fecha = $payment?->fecha ?? $globalPayment->created_at->format('d/m/Y');
                        $proveedor = $globalPayment->person_name;
                    @endphp
                    <tr>
                        <td>{{ $tipo }}</td>
                        <td>{{ $numero }}</td>
                        <td>{{ $fecha }}</td>
                        <td>{{ $proveedor }}</td>
                        <td class="text-center">PEN</td>
                        <td class="text-right">S/ {{ number_format($monto, 2) }}</td>
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
            <table>
                <tr>
                    <td class="totales-label">Saldo Inicial:</td>
                    <td class="totales-value">S/ {{ number_format($caja->saldo_inicial, 2) }}</td>
                </tr>
                <tr>
                    <td class="totales-label">Total Ingresos:</td>
                    <td class="totales-value" style="color: #065F46;">+ S/ {{ number_format($totales['ingresos'], 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="totales-label">Total Egresos:</td>
                    <td class="totales-value" style="color: #991B1B;">- S/ {{ number_format($totales['egresos'], 2) }}
                    </td>
                </tr>
                <tr class="totales-final">
                    <td class="totales-label">SALDO FINAL:</td>
                    <td class="totales-value" style="color: #4F46E5;">
                        S/ {{ number_format($totales['saldo_final'], 2) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Documento generado automáticamente por {{ config('app.name') }}</p>
        <p>Fecha de impresión: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
