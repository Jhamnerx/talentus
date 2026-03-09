<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Compras</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 9px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #052c52;
        }

        .header h1 {
            font-size: 18px;
            color: #052c52;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10px;
            color: #666;
        }

        .filters {
            background-color: #f8f9fa;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 8px;
        }

        .filters strong {
            color: #052c52;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        thead {
            background-color: #052c52;
            color: white;
        }

        th {
            padding: 6px 4px;
            text-align: center;
            font-size: 8px;
            font-weight: bold;
            border: 1px solid #dee2e6;
        }

        td {
            padding: 5px 4px;
            border: 1px solid #dee2e6;
            font-size: 8px;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:hover {
            background-color: #e9ecef;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .totals {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .totals td {
            padding: 8px 4px;
            border: 2px solid #052c52;
        }

        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
            display: inline-block;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 8px;
            color: #666;
        }

        .anulado {
            opacity: 0.5;
            text-decoration: line-through;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>REPORTE DE COMPRAS</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    @if ($filters)
        <div class="filters">
            <strong>Filtros aplicados:</strong>
            @if (!empty($filters['search']))
                Búsqueda: "{{ $filters['search'] }}" |
            @endif
            @if (!empty($filters['formaPago']))
                Forma de Pago: {{ $filters['formaPago'] }} |
            @endif
            @if (!empty($filters['estadoPago']))
                Estado de Pago: {{ ucfirst($filters['estadoPago']) }}
            @endif
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 7%;">F. EMISIÓN</th>
                <th style="width: 7%;">F. VENC.</th>
                <th style="width: 18%;">PROVEEDOR</th>
                <th style="width: 8%;">RUC/DNI</th>
                <th style="width: 8%;">COMPROBANTE</th>
                <th style="width: 6%;">F. PAGO</th>
                <th style="width: 5%;">CUOTAS</th>
                <th style="width: 5%;">DIV</th>
                <th style="width: 8%;">SUB TOTAL</th>
                <th style="width: 7%;">IGV</th>
                <th style="width: 8%;">TOTAL</th>
                <th style="width: 7%;">PAGADO</th>
                <th style="width: 6%;">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @forelse($compras as $compra)
                <tr class="{{ $compra->estado == 'ANULADO' ? 'anulado' : '' }}">
                    <td class="text-center">{{ $compra->fecha_emision->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @if ($compra->fecha_vencimiento)
                            {{ $compra->fecha_vencimiento->format('d/m/Y') }}
                            @if ($compra->forma_pago == 'CREDITO' && !$compra->isPaid() && now()->greaterThan($compra->fecha_vencimiento))
                                <br><span class="badge badge-danger">VENCIDO</span>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-left">{{ $compra->proveedor->razon_social }}</td>
                    <td class="text-center">{{ $compra->proveedor->numero_documento }}</td>
                    <td class="text-center">{{ $compra->serie_correlativo }}</td>
                    <td class="text-center">
                        @if ($compra->forma_pago == 'CREDITO')
                            <span class="badge badge-warning">CRÉDITO</span>
                        @else
                            <span class="badge badge-success">CONTADO</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $compra->numero_cuotas > 0 ? $compra->numero_cuotas : '-' }}</td>
                    <td class="text-center">{{ $compra->divisa }}</td>
                    <td class="text-right">{{ number_format($compra->sub_total, 2) }}</td>
                    <td class="text-right">{{ number_format($compra->igv, 2) }}</td>
                    <td class="text-right">{{ number_format($compra->total, 2) }}</td>
                    <td class="text-right">{{ number_format($compra->total_pagado, 2) }}</td>
                    <td class="text-center">
                        @if ($compra->estado == 'ANULADO')
                            <span class="badge badge-danger">ANULADO</span>
                        @elseif($compra->isPaid())
                            <span class="badge badge-success">PAGADO</span>
                        @elseif($compra->total_pagado > 0)
                            <span class="badge badge-warning">PARCIAL</span>
                        @else
                            <span class="badge badge-danger">PENDIENTE</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="13" class="text-center">No hay registros para mostrar</td>
                </tr>
            @endforelse
        </tbody>
        @if ($compras->count() > 0)
            <tfoot class="totals">
                <tr>
                    <td colspan="8" class="text-right"><strong>TOTALES GENERALES:</strong></td>
                    <td class="text-right"><strong>{{ number_format($compras->sum('sub_total'), 2) }}</strong></td>
                    <td class="text-right"><strong>{{ number_format($compras->sum('igv'), 2) }}</strong></td>
                    <td class="text-right"><strong>{{ number_format($compras->sum('total'), 2) }}</strong></td>
                    <td class="text-right"><strong>{{ number_format($compras->sum('total_pagado'), 2) }}</strong></td>
                    <td class="text-center">-</td>
                </tr>
                <tr>
                    <td colspan="8" class="text-right"><strong>SALDO PENDIENTE:</strong></td>
                    <td colspan="3" class="text-right">
                        <strong>{{ number_format($compras->sum('saldo_pendiente'), 2) }}</strong>
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer">
        <p>Total de registros: {{ $compras->count() }}</p>
        <p>Reporte generado por Talentus - Sistema de Gestión Empresarial</p>
    </div>
</body>

</html>
