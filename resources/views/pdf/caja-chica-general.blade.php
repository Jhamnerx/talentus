<!DOCTYPE html>
<html>

<head>
    <title>Reporte General - {{ $fecha }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{ header('Content-type:application/pdf') }}
    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 11px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #F59E0B;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #F59E0B;
            margin: 0;
            font-size: 24px;
        }

        .resumen {
            background: #FEF3C7;
            border: 2px solid #F59E0B;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 30px;
        }

        .resumen-grid {
            display: flex;
            justify-content: space-around;
            text-align: center;
        }

        .resumen-item {
            flex: 1;
        }

        .resumen-item .label {
            font-size: 10px;
            color: #78350F;
            margin-bottom: 5px;
        }

        .resumen-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #92400E;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background: #F59E0B;
            color: white;
        }

        table th,
        table td {
            padding: 8px;
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

        .status-open {
            background: #D1FAE5;
            color: #065F46;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        .status-closed {
            background: #E5E7EB;
            color: #374151;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>📊 Reporte General del Día</h1>
        <p><strong>{{ \Carbon\Carbon::parse($fecha)->format('d \d\e F \d\e Y') }}</strong></p>
    </div>

    <div class="resumen">
        <div class="resumen-grid">
            <div class="resumen-item">
                <div class="label">CAJAS OPERADAS</div>
                <div class="value">{{ $cajas->count() }}</div>
            </div>
            <div class="resumen-item">
                <div class="label">SALDO INICIAL</div>
                <div class="value">S/ {{ number_format($totalGeneral['saldo_inicial'], 2) }}</div>
            </div>
            <div class="resumen-item">
                <div class="label">INGRESOS</div>
                <div class="value">S/ {{ number_format($totalGeneral['ingresos'], 2) }}</div>
            </div>
            <div class="resumen-item">
                <div class="label">EGRESOS</div>
                <div class="value">S/ {{ number_format($totalGeneral['egresos'], 2) }}</div>
            </div>
            <div class="resumen-item">
                <div class="label">SALDO FINAL</div>
                <div class="value">S/ {{ number_format($totalGeneral['saldo_final'], 2) }}</div>
            </div>
        </div>
    </div>

    <h2 style="color: #F59E0B; margin-top: 30px; margin-bottom: 15px;">Detalle por Caja</h2>

    @if ($cajas->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Estado</th>
                    <th class="text-right">Saldo Inicial</th>
                    <th class="text-right">Saldo Actual</th>
                    <th class="text-right">Docs</th>
                    <th>Apertura</th>
                    <th>Cierre</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cajas as $caja)
                    <tr>
                        <td><strong>{{ $caja->nombre }}</strong></td>
                        <td>{{ $caja->user->name }}</td>
                        <td>
                            <span class="{{ $caja->estado ? 'status-open' : 'status-closed' }}">
                                {{ $caja->estado ? 'ABIERTA' : 'CERRADA' }}
                            </span>
                        </td>
                        <td class="text-right">S/ {{ number_format($caja->saldo_inicial, 2) }}</td>
                        <td class="text-right">S/ {{ number_format($caja->saldo_actual, 2) }}</td>
                        <td class="text-right">{{ $caja->cashDocuments->count() }}</td>
                        <td>{{ $caja->fecha_apertura->format('H:i') }}</td>
                        <td>{{ $caja->fecha_cierre ? $caja->fecha_cierre->format('H:i') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #6B7280; padding: 30px;">
            No se operaron cajas en esta fecha
        </p>
    @endif

    <div
        style="margin-top: 30px; text-align: center; color: #6B7280; font-size: 10px; border-top: 1px solid #E5E7EB; padding-top: 15px;">
        <p>Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Sistema de Gestión - Talentus</p>
    </div>
</body>

</html>
