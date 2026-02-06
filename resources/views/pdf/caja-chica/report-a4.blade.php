<!DOCTYPE html>
<html>

<head>
    <title>Reporte Caja Chica - CAJA GENERAL</title>
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
            width: 100%;
        }

        .info-grid table {
            width: 100%;
            border: none;
            margin-bottom: 0;
        }

        .info-grid td {
            border: none;
            padding: 4px 0;
        }

        .info-label {
            font-weight: bold;
            color: #374151;
            padding: 4px 10px 4px 0;
            width: 25%;
        }

        .info-value {
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
            color: #374151;
            padding: 5px 10px 5px 0;
            width: 70%;
        }

        .totales-value {
            color: #1F2937;
            text-align: right;
            padding: 5px 0;
            font-weight: 600;
        }

        .totales-final td {
            font-size: 13px;
            padding-top: 8px;
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
            <table>
                <tr>
                    <td class="info-label">Caja:</td>
                    <td class="info-value"><strong>CAJA GENERAL</strong></td>
                </tr>
                <tr>
                    <td class="info-label">Usuario:</td>
                    <td class="info-value">{{ $caja->user->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Fecha Apertura:</td>
                    <td class="info-value">{{ $caja->fecha_apertura?->format('d/m/Y H:i') ?? 'N/A' }}</td>
                </tr>
                @if (!$caja->estado)
                    <tr>
                        <td class="info-label">Fecha Cierre:</td>
                        <td class="info-value">{{ $caja->fecha_cierre?->format('d/m/Y H:i') ?? 'N/A' }}</td>
                    </tr>
                @endif
                <tr>
                    <td class="info-label">Estado:</td>
                    <td class="info-value">
                        <span class="status {{ $caja->estado ? 'status-open' : 'status-closed' }}">
                            {{ $caja->estado ? 'ABIERTA' : 'CERRADA' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Saldo Inicial:</td>
                    <td class="info-value"><span class="moneda">S/ {{ number_format($caja->saldo_inicial, 2) }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Tabla de Documentos -->
    @php
        // Obtener documentos desde cash_documents (como FactuPRO)
        $cashDocuments = $caja
            ->cashDocuments()
            ->with(['recibo.payments.paymentMethod', 'recibo.cliente', 'venta.payments.paymentMethod', 'venta.cliente'])
            ->get();

        // Convertir a estructura compatible con el reporte
        $movimientos = collect();

        foreach ($cashDocuments as $cashDoc) {
            $documento = $cashDoc->recibo ?? $cashDoc->venta;

            if (!$documento) {
                continue;
            }

            foreach ($documento->payments as $payment) {
                $movimientos->push(
                    (object) [
                        'type_movement' => 'INGRESO',
                        'date_time' => $payment->created_at->format('d/m/Y H:i'),
                        'document_type' => $documento instanceof \App\Models\Recibos ? 'Recibo' : 'Factura',
                        'document_number' => $documento->numero ?? '-',
                        'person_name' => $documento->cliente->nombre_comercial ?? '-',
                        'payment_method' => $payment->paymentMethod->descripcion ?? '-',
                        'monto' => $payment->monto,
                    ],
                );
            }
        }
    @endphp
    @if ($movimientos->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Documento</th>
                    <th style="width: 12%;">Fecha</th>
                    <th style="width: 30%;">Cliente</th>
                    <th style="width: 18%;">Método Pago</th>
                    <th class="text-right" style="width: 15%;">Monto</th>
                    <th style="width: 10%;">Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movimientos as $movimiento)
                    <tr>
                        <td>{{ $movimiento->document_type }}<br><small>{{ $movimiento->document_number }}</small></td>
                        <td>{{ $movimiento->date_time }}</td>
                        <td>{{ $movimiento->person_name }}</td>
                        <td>{{ $movimiento->payment_method }}</td>
                        <td class="text-right">
                            <strong class="moneda">S/ {{ number_format($movimiento->monto, 2) }}</strong>
                        </td>
                        <td class="text-center">
                            <span class="tipo-badge tipo-ingreso">Ingreso</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <p>No se encontraron movimientos registrados en esta caja</p>
        </div>
    @endif

    <!-- Totales -->
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
                    <td class="totales-value" style="color: #4F46E5; font-size: 14px;">
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
