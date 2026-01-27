<!DOCTYPE html>
<html>

<head>
    <title>Reporte Caja Chica - {{ $caja->nombre }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{ header('Content-type:application/pdf') }}
    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #4F46E5;
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .info-box {
            background: #F3F4F6;
            border: 1px solid #D1D5DB;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .info-label {
            font-weight: bold;
            color: #374151;
        }

        .info-value {
            color: #1F2937;
        }

        .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
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
            margin-bottom: 20px;
        }

        table thead {
            background: #4F46E5;
            color: white;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #D1D5DB;
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

        .totales {
            background: #EEF2FF;
            border: 2px solid #4F46E5;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .totales-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #C7D2FE;
        }

        .totales-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid #4F46E5;
        }

        .totales-label {
            font-weight: 600;
            color: #374151;
        }

        .totales-value {
            color: #1F2937;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #6B7280;
            font-size: 10px;
            border-top: 1px solid #E5E7EB;
            padding-top: 15px;
        }

        .tipo-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
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
    </style>
</head>

<body>
    <div class="header">
        <h1>📊 Reporte de Caja Chica</h1>
        <p><strong>{{ $caja->nombre }}</strong></p>
        @if ($caja->descripcion)
            <p>{{ $caja->descripcion }}</p>
        @endif
    </div>

    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Estado:</span>
            <span class="info-value">
                <span class="status {{ $caja->estado ? 'status-open' : 'status-closed' }}">
                    {{ $caja->estado ? 'ABIERTA' : 'CERRADA' }}
                </span>
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Responsable:</span>
            <span class="info-value">{{ $caja->user->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Fecha Apertura:</span>
            <span class="info-value">{{ $caja->fecha_apertura->format('d/m/Y H:i') }}</span>
        </div>
        @if ($caja->fecha_cierre)
            <div class="info-row">
                <span class="info-label">Fecha Cierre:</span>
                <span class="info-value">{{ $caja->fecha_cierre->format('d/m/Y H:i') }}</span>
            </div>
        @endif
        <div class="info-row">
            <span class="info-label">Moneda:</span>
            <span class="info-value">{{ $caja->moneda }}</span>
        </div>
    </div>

    <h2 style="color: #4F46E5; margin-top: 30px; margin-bottom: 15px;">Documentos Registrados</h2>

    @if ($caja->cashDocuments->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tipo</th>
                    <th>Documento</th>
                    <th>Fecha</th>
                    <th>Cliente/Proveedor</th>
                    <th class="text-right">Monto</th>
                    <th class="text-center">Tipo Mov.</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($caja->cashDocuments as $index => $documento)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $documento->getTipoDocumento->descripcion ?? '-' }}</td>
                        <td>{{ $documento->serie_numero ?? '-' }}</td>
                        <td>{{ $documento->fecha_emision ? \Carbon\Carbon::parse($documento->fecha_emision)->format('d/m/Y') : '-' }}
                        </td>
                        <td>{{ $documento->cliente_nombre ?? '-' }}</td>
                        <td class="text-right">{{ $caja->moneda }}
                            {{ number_format($documento->total, 2) }}</td>
                        <td class="text-center">
                            @if ($documento->getDocumento)
                                @php
                                    $esIngreso = method_exists($documento->getDocumento, 'isIncome')
                                        ? $documento->getDocumento->isIncome()
                                        : in_array($documento->document_type, [
                                            'App\Models\Recibos',
                                            'App\Models\Ventas',
                                        ]);
                                @endphp
                                <span class="tipo-badge {{ $esIngreso ? 'tipo-ingreso' : 'tipo-egreso' }}">
                                    {{ $esIngreso ? 'INGRESO' : 'EGRESO' }}
                                </span>
                            @else
                                <span class="tipo-badge tipo-ingreso">INGRESO</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #6B7280; padding: 30px;">No hay documentos registrados en esta caja
        </p>
    @endif

    <div class="totales">
        <div class="totales-row">
            <span class="totales-label">Saldo Inicial:</span>
            <span class="totales-value">{{ $caja->moneda }} {{ number_format($caja->saldo_inicial, 2) }}</span>
        </div>
        <div class="totales-row">
            <span class="totales-label">Total Ingresos:</span>
            <span class="totales-value">{{ $caja->moneda }} {{ number_format($totales['ingresos'], 2) }}</span>
        </div>
        <div class="totales-row">
            <span class="totales-label">Total Egresos:</span>
            <span class="totales-value">{{ $caja->moneda }} {{ number_format($totales['egresos'], 2) }}</span>
        </div>
        <div class="totales-row">
            <span class="totales-label">Saldo Final:</span>
            <span class="totales-value">{{ $caja->moneda }} {{ number_format($totales['saldo_final'], 2) }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Sistema de Gestión - Talentus</p>
    </div>
</body>

</html>
