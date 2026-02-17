<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte de Movimientos</title>
</head>

<body>
    <table>
        <!-- Header con info de empresa -->
        <tr>
            <td colspan="9" style="text-align: center; font-weight: bold; font-size: 16px;">
                {{ $company->razon_social ?? 'EMPRESA' }}
            </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center;">
                RUC: {{ $company->ruc ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center; font-weight: bold; font-size: 14px;">
                MOVIMIENTOS DE INGRESOS Y EGRESOS
            </td>
        </tr>
        <tr>
            <td colspan="9" style="text-align: center;">
                {{ $periodDescription ?? 'Todos los períodos' }}
            </td>
        </tr>
        @if (!empty($filters['cash_id']))
            @php
                $caja = \App\Models\Cash::find($filters['cash_id']);
            @endphp
            <tr>
                <td colspan="9" style="text-align: center;">
                    Caja: {{ $caja->nombre ?? 'N/A' }}
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="9"></td>
        </tr>

        <!-- Encabezados de columnas -->
        <tr style="font-weight: bold; background-color: #f3f4f6;">
            <td>Fecha</td>
            <td>Adquiriente</td>
            <td>Documento/Transacción</td>
            <td>Detalle</td>
            <td>Moneda</td>
            <td>Tipo</td>
            <td>Ingresos</td>
            <td>Gastos</td>
            <td>Saldo</td>
        </tr>

        <!-- Datos -->
        @foreach ($movements as $movimiento)
            <tr
                style="{{ isset($movimiento['is_saldo_inicial']) && $movimiento['is_saldo_inicial'] ? 'background-color: #dbeafe;' : '' }}">
                <td>{{ $movimiento['date_time'] ? \Carbon\Carbon::parse($movimiento['date_time'])->format('d/m/Y H:i') : '-' }}
                </td>
                <td>
                    {{ $movimiento['person_name'] ?: '-' }}
                    @if (!empty($movimiento['person_document']))
                        ({{ $movimiento['person_document'] }})
                    @endif
                </td>
                <td>
                    @if (!empty($movimiento['document_type']))
                        {{ $movimiento['document_type'] }}
                        @if (!empty($movimiento['document_number']))
                            - {{ $movimiento['document_number'] }}
                        @endif
                    @else
                        -
                    @endif
                </td>
                <td>{{ $movimiento['detalle'] ?: '-' }}</td>
                <td>{{ $movimiento['moneda'] }}</td>
                <td>{{ $movimiento['tipo'] ?: '-' }}</td>
                <td>{{ $movimiento['ingresos'] > 0 ? number_format($movimiento['ingresos'], 2) : '-' }}</td>
                <td>{{ $movimiento['gastos'] > 0 ? number_format($movimiento['gastos'], 2) : '-' }}</td>
                <td>{{ number_format($movimiento['saldo'], 2) }}</td>
            </tr>
        @endforeach

        <!-- Footer con totales -->
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr style="font-weight: bold; background-color: #f3f4f6;">
            <td colspan="6" style="text-align: right;">TOTALES:</td>
            <td>{{ number_format($totales['ingresos'], 2) }}</td>
            <td>{{ number_format($totales['gastos'], 2) }}</td>
            <td>{{ number_format($totales['saldo'], 2) }}</td>
        </tr>

        <!-- Info de filtros aplicados -->
        <tr>
            <td colspan="9"></td>
        </tr>
        @if (!empty($filters['type_movement']) || !empty($filters['search']))
            <tr>
                <td colspan="9" style="font-size: 10px; color: #666;">
                    <strong>Filtros aplicados:</strong>
                    @if (!empty($filters['type_movement']))
                        Tipo: {{ $filters['type_movement'] }} |
                    @endif
                    @if (!empty($filters['search']))
                        Búsqueda: {{ $filters['search'] }}
                    @endif
                </td>
            </tr>
        @endif

        <tr>
            <td colspan="9" style="font-size: 10px; color: #999; text-align: center;">
                Generado: {{ now()->format('d/m/Y H:i:s') }}
            </td>
        </tr>
    </table>
</body>

</html>
