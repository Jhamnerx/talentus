<!DOCTYPE html>
<html>

<head>
    <title>Pagos Asociados - {{ $caja->nombre }}</title>
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

        .description {
            background: #FEF3C7;
            border-left: 4px solid #F59E0B;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background: #4F46E5;
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

        .method-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 600;
        }

        .method-efectivo {
            background: #D1FAE5;
            color: #065F46;
        }

        .method-tarjeta {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .method-transferencia {
            background: #FCE7F3;
            color: #9F1239;
        }

        .totales {
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
            padding: 30px;
            color: #9CA3AF;
            font-style: italic;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>PAGOS ASOCIADOS A CAJA</h1>
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

    <!-- Descripción -->
    <div class="description">
        <strong>Nota:</strong> Este reporte muestra todos los pagos asociados a documentos registrados en esta caja,
        incluyendo pagos en efectivo, tarjeta y transferencia.
    </div>

    <!-- Tabla de Pagos -->
    @if ($caja->cashDocumentPayments->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 12%;">Tipo Doc.</th>
                    <th style="width: 15%;">Documento</th>
                    <th style="width: 10%;">Fecha</th>
                    <th style="width: 30%;">Cliente/Proveedor</th>
                    <th class="text-center" style="width: 13%;">Método Pago</th>
                    <th class="text-right" style="width: 10%;">Monto</th>
                    <th class="text-right" style="width: 10%;">Monto PEN</th>
                </tr>
            </thead>
            <tbody>
                @php $totalGeneral = 0; @endphp
                @foreach ($caja->cashDocumentPayments as $docPayment)
                    @php
                        $payment = $docPayment->payment;
                        $doc = $docPayment->cashDocument->getDocumento();
                        $tipo = $docPayment->cashDocument->getTipoDocumento();

                        $metodoPago = 'Efectivo';
                        $badgeClass = 'method-efectivo';

                        if ($payment) {
                            if ($payment->payment_method_type_id == '02') {
                                $metodoPago = 'Tarjeta';
                                $badgeClass = 'method-tarjeta';
                            } elseif ($payment->payment_method_type_id == '03') {
                                $metodoPago = 'Transferencia';
                                $badgeClass = 'method-transferencia';
                            }
                        }

                        $moneda = $doc->moneda ?? 'PEN';
                        $monto = $payment->payment ?? 0;
                        $montoPen = $caja->convertirAPen($monto, $moneda);
                        $totalGeneral += $montoPen;
                    @endphp
                    <tr>
                        <td>{{ $tipo }}</td>
                        <td>{{ $doc->serie ?? 'N/A' }}-{{ $doc->numero ?? 'N/A' }}</td>
                        <td>{{ $payment->date_of_payment ?? 'N/A' }}</td>
                        <td>{{ $doc->cliente_nombre ?? ($doc->proveedor ?? 'N/A') }}</td>
                        <td class="text-center">
                            <span class="method-badge {{ $badgeClass }}">{{ $metodoPago }}</span>
                        </td>
                        <td class="text-right">{{ $moneda }} {{ number_format($monto, 2) }}</td>
                        <td class="text-right">S/ {{ number_format($montoPen, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totales -->
        <div class="totales">
            <div class="totales-row">
                <span>Total Documentos:</span>
                <span>{{ $caja->cashDocumentPayments->count() }}</span>
            </div>
            <div class="totales-row totales-final">
                <span>TOTAL PAGOS:</span>
                <span style="color: #4F46E5;">S/ {{ number_format($totalGeneral, 2) }}</span>
            </div>
        </div>
    @else
        <div class="empty-state">
            No hay pagos asociados registrados en esta caja.
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Documento generado automáticamente por {{ config('app.name') }}</p>
        <p>Fecha de impresión: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>
