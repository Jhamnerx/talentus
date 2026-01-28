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
            <td colspan="13" style="text-align: center; font-weight: bold; font-size: 16px;">
                {{ $company->razon_social ?? 'EMPRESA' }}
            </td>
        </tr>
        <tr>
            <td colspan="13" style="text-align: center;">
                RUC: {{ $company->ruc ?? '-' }}
            </td>
        </tr>
        <tr>
            <td colspan="13" style="text-align: center; font-weight: bold; font-size: 14px;">
                MOVIMIENTOS DE INGRESOS Y EGRESOS
            </td>
        </tr>
        @if ($dateStart && $dateEnd)
            <tr>
                <td colspan="13" style="text-align: center;">
                    Desde: {{ \Carbon\Carbon::parse($dateStart)->format('d/m/Y') }}
                    - Hasta: {{ \Carbon\Carbon::parse($dateEnd)->format('d/m/Y') }}
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="13"></td>
        </tr>

        <!-- Encabezados de columnas -->
        <tr style="font-weight: bold; background-color: #f3f4f6;">
            <td>#</td>
            <td>Fecha</td>
            <td>Tipo</td>
            <td>Documento</td>
            <td>Persona</td>
            <td>N° Documento</td>
            <td>Método Pago</td>
            <td>Destino</td>
            <td>Tipo Destino</td>
            <td>Referencia</td>
            <td>Moneda</td>
            <td>Ingreso</td>
            <td>Egreso</td>
            <td>Saldo</td>
        </tr>

        <!-- Datos -->
        @php
            $index = 1;
            $balance = 0;
            $totalIngresos = 0;
            $totalEgresos = 0;
        @endphp

        @foreach ($records as $record)
            @php
                $monto = $record->monto;
                $isIngreso = $record->type_movement === 'INGRESO';

                if ($isIngreso) {
                    $balance += $monto;
                    $totalIngresos += $monto;
                } else {
                    $balance -= $monto;
                    $totalEgresos += $monto;
                }

                // Obtener persona y documento
                $persona = $record->person_name;
                $numeroDocumento = '';
                if ($record->payment && $record->payment->paymentable) {
                    $paymentable = $record->payment->paymentable;
                    if ($paymentable->cliente) {
                        $numeroDocumento = $paymentable->cliente->numero_documento ?? '';
                    } elseif ($paymentable->proveedor) {
                        $numeroDocumento = $paymentable->proveedor->numero_documento ?? '';
                    }
                }

                // Tipo de destino
                $tipoDestino = 'Sin destino';
                $referencia = '-';
                if ($record->destination_type === 'App\Models\Cash') {
                    $tipoDestino = 'CAJA';
                } elseif ($record->destination_type === 'App\Models\BankAccount') {
                    $tipoDestino = 'BANCO';
                    $referencia = $record->destination?->cci ?? '-';
                }
            @endphp
            <tr>
                <td>{{ $index++ }}</td>
                <td>{{ $record->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $record->instance_type_description }}</td>
                <td>{{ $record->document_number }}</td>
                <td>{{ $persona }}</td>
                <td>{{ $numeroDocumento }}</td>
                <td>{{ $record->payment?->payment_method?->nombre ?? '-' }}</td>
                <td>{{ $record->destination_description }}</td>
                <td>{{ $tipoDestino }}</td>
                <td>{{ $referencia }}</td>
                <td>{{ $record->moneda }}</td>
                <td>{{ $isIngreso ? number_format($monto, 2) : '-' }}</td>
                <td>{{ !$isIngreso ? number_format($monto, 2) : '-' }}</td>
                <td>{{ number_format($balance, 2) }}</td>
            </tr>
        @endforeach

        <!-- Footer con totales -->
        <tr>
            <td colspan="14"></td>
        </tr>
        <tr style="font-weight: bold; background-color: #f3f4f6;">
            <td colspan="11" style="text-align: right;">TOTALES:</td>
            <td>{{ number_format($totalIngresos, 2) }}</td>
            <td>{{ number_format($totalEgresos, 2) }}</td>
            <td>{{ number_format($balance, 2) }}</td>
        </tr>

        <!-- Info de filtros aplicados -->
        <tr>
            <td colspan="14"></td>
        </tr>
        @if (!empty($filters['tipo']) || !empty($filters['destination_type']) || !empty($filters['search']))
            <tr>
                <td colspan="14" style="font-size: 10px; color: #666;">
                    <strong>Filtros aplicados:</strong>
                    @if (!empty($filters['tipo']))
                        Tipo: {{ ucfirst($filters['tipo']) }} |
                    @endif
                    @if (!empty($filters['destination_type']))
                        Destino: {{ $filters['destination_type'] === 'cash' ? 'Caja' : 'Banco' }} |
                    @endif
                    @if (!empty($filters['search']))
                        Búsqueda: {{ $filters['search'] }}
                    @endif
                </td>
            </tr>
        @endif

        <tr>
            <td colspan="14" style="font-size: 10px; color: #999; text-align: right;">
                Generado: {{ now()->format('d/m/Y H:i:s') }}
            </td>
        </tr>
    </table>
</body>

</html>
