<table>
    <!-- Encabezados de columnas -->
    <tr>
        <th>Fecha</th>
        <th>Adquiriente</th>
        <th>Documento</th>
        <th>Detalle</th>
        <th>Moneda</th>
        <th>Destino</th>
        <th>Ingresos</th>
        <th>Gastos</th>
        <th>Saldo</th>
    </tr>

    <!-- Datos -->
    @foreach ($movimientos as $mov)
        <tr>
            <td>{{ $mov['date_time'] ?? '-' }}</td>
            <td>{{ $mov['person_name'] ?? '-' }}
                @if (!empty($mov['person_document']))
                    {{ $mov['person_document'] }}
                @endif
            </td>
            <td>{{ $mov['document_type'] ?? '-' }}
                @if (!empty($mov['document_number']))
                    {{ $mov['document_number'] }}
                @endif
            </td>
            <td>{{ $mov['detalle'] ?? '-' }}</td>
            <td>{{ $mov['moneda'] ?? 'PEN' }}</td>
            <td>{{ $mov['destination'] ?? '-' }}</td>
            <td>{{ isset($mov['ingresos']) && $mov['ingresos'] > 0 ? number_format($mov['ingresos'], 2) : '-' }}</td>
            <td>{{ isset($mov['gastos']) && $mov['gastos'] > 0 ? number_format($mov['gastos'], 2) : '-' }}</td>
            <td>{{ number_format($mov['saldo'] ?? 0, 2) }}</td>
        </tr>
    @endforeach

    <!-- Totales por moneda -->
    <tr>
        <td colspan="6">INGRESOS PEN:</td>
        <td>{{ number_format($totales['ingresos_pen'] ?? 0, 2) }}</td>
        <td>-</td>
        <td>-</td>
    </tr>
    <tr>
        <td colspan="6">INGRESOS USD:</td>
        <td>{{ number_format($totales['ingresos_usd'] ?? 0, 2) }}</td>
        <td>-</td>
        <td>-</td>
    </tr>
    <tr>
        <td colspan="6">EGRESOS PEN:</td>
        <td>-</td>
        <td>{{ number_format($totales['gastos_pen'] ?? 0, 2) }}</td>
        <td>-</td>
    </tr>
    <tr>
        <td colspan="6">EGRESOS USD:</td>
        <td>-</td>
        <td>{{ number_format($totales['gastos_usd'] ?? 0, 2) }}</td>
        <td>-</td>
    </tr>
    <tr>
        <td colspan="6">SALDO PEN:</td>
        <td>-</td>
        <td>-</td>
        <td>{{ number_format($totales['saldo_pen'] ?? 0, 2) }}</td>
    </tr>
    <tr>
        <td colspan="6">SALDO USD:</td>
        <td>-</td>
        <td>-</td>
        <td>{{ number_format($totales['saldo_usd'] ?? 0, 2) }}</td>
    </tr>
</table>
