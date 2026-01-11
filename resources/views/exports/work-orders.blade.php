<!DOCTYPE html>
<html lang="es">

<body>

    <table class="detalle" border="1">
        <tbody class="text-sm divide-y divide-slate-200">

            <tr>
                <td></td>
                <td></td>
                <td colspan="2">
                    <div class="text-center">
                        <strong>{{ $tecnico->name }}</strong>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Fecha Inicial</strong></td>
                <td>{{ \Carbon\Carbon::parse($fechas['fecha_inicial'])->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Fecha Final</strong></td>
                <td>{{ \Carbon\Carbon::parse($fechas['fecha_final'])->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Estado</strong></td>
                <td>{{ $estado ? ucfirst(str_replace('_', ' ', $estado)) : 'Todos' }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><strong>Total a Pagar (Finalizadas):</strong></td>
                <td>S/. {{ number_format($total_costo_finalizadas, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 20px;">

    </div>

    @if ($workOrders->count())
        @foreach ($workOrdersGrouped as $estadoKey => $ordenes)
            @php
                $estadoLabel = ucfirst(str_replace('_', ' ', $estadoKey));
                $totalEstado = $totales_por_estado[$estadoKey] ?? 0;
            @endphp

            {{-- Header del Estado --}}
            <table border="1" style="margin-top: 15px;">
                <tr style="background-color: #e5e7eb;">
                    <td colspan="7" style="padding: 8px;">
                        <strong style="font-size: 14px;">ESTADO: {{ strtoupper($estadoLabel) }}</strong>
                    </td>
                    <td colspan="6" style="padding: 8px; text-align: right;">
                        @if ($estadoKey === 'finalizado')
                            <strong>Total a Pagar: S/. {{ number_format($totalEstado, 2) }}</strong>
                        @else
                            <strong>{{ $ordenes->count() }} órdenes</strong>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Tabla de Órdenes por Estado --}}
            <table border="1">
                <thead>
                    <tr>
                        <td><strong>Código</strong></td>
                        <td><strong>Tipo de Orden</strong></td>
                        <td><strong>Cliente</strong></td>
                        <td><strong>Vehículo</strong></td>
                        <td><strong>Placa</strong></td>
                        <td><strong>Fecha Programada</strong></td>
                        <td><strong>Fecha Inicio</strong></td>
                        <td><strong>Fecha Finalización</strong></td>
                        <td><strong>IMEI</strong></td>
                        <td><strong>ICCID</strong></td>
                        <td><strong>Costo Base</strong></td>
                        <td><strong>Total</strong></td>
                        <td><strong>Observaciones</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordenes as $orden)
                        @php
                            $costo_base = floatval($orden->tipo_data['costo_base'] ?? 0);
                            $costo_accesorios = $orden->accessories->sum('subtotal');
                            $total = $costo_base + $costo_accesorios;
                        @endphp
                        <tr>
                            <td>{{ str_pad($orden->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $orden->tipo_data['nombre'] ?? $orden->tipo->nombre }}</td>
                            <td>{{ $orden->cliente->razon_social }}</td>
                            <td>{{ $orden->vehiculo->marca }} {{ $orden->vehiculo->modelo }}</td>
                            <td>{{ $orden->vehiculo->placa }}</td>
                            <td>{{ $orden->fecha_programada->format('d/m/Y H:i') }}</td>
                            <td>{{ $orden->fecha_inicio ? $orden->fecha_inicio->format('d/m/Y H:i') : '-' }}</td>
                            <td>{{ $orden->fecha_finalizacion ? $orden->fecha_finalizacion->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td>{{ $orden->imei ?? '-' }}</td>
                            <td>{{ $orden->iccid ?? '-' }}</td>
                            <td>S/. {{ number_format($costo_base, 2) }}</td>
                            <td>S/. {{ number_format($total, 2) }}</td>
                            <td>
                                @if ($orden->observaciones_inicial)
                                    <strong>Inicial:</strong> {{ $orden->observaciones_inicial }}<br>
                                @endif
                                @if ($orden->observaciones_tecnico)
                                    <strong>Técnico:</strong> {{ $orden->observaciones_tecnico }}<br>
                                @endif
                                @if ($orden->observaciones_final)
                                    <strong>Final:</strong> {{ $orden->observaciones_final }}
                                @endif
                                @if (!$orden->observaciones_inicial && !$orden->observaciones_tecnico && !$orden->observaciones_final)
                                    -
                                @endif
                            </td>
                        </tr>

                        {{-- Detalles de Accesorios si existen --}}
                        @if ($orden->accessories->count() > 0)
                            <tr>
                                <td colspan="13" style="background-color: #f3f4f6; padding-left: 20px;">
                                    <strong>Accesorios:</strong>
                                    @foreach ($orden->accessories as $accessory)
                                        {{ $accessory->nombre }} ({{ $accessory->cantidad }} x S/.
                                        {{ number_format($accessory->precio_unitario, 2) }}){{ $loop->last ? '' : ', ' }}
                                    @endforeach
                                </td>
                            </tr>
                        @endif

                        {{-- Detalles de Dispositivos si existen --}}
                        @if ($orden->deviceHistory->count() > 0)
                            <tr>
                                <td colspan="13" style="background-color: #f9fafb; padding-left: 20px;">
                                    <strong>Historial Dispositivos:</strong>
                                    @foreach ($orden->deviceHistory as $history)
                                        @if ($history->accion_imei !== 'ninguna')
                                            IMEI {{ $history->imei }}
                                            ({{ ucfirst($history->accion_imei) }})
                                            {{ $loop->last ? '' : ', ' }}
                                        @endif
                                        @if ($history->accion_sim !== 'ninguna')
                                            SIM {{ $history->numero_linea }}
                                            ({{ ucfirst($history->accion_sim) }}){{ $loop->last ? '' : ', ' }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    @endforeach

                    {{-- Subtotal por Estado --}}
                    @if ($estadoKey === 'finalizado')
                        <tr style="background-color: #fef3c7; font-weight: bold;">
                            <td colspan="11" style="text-align: right; padding: 8px;">SUBTOTAL
                                {{ strtoupper($estadoLabel) }}:</td>
                            <td colspan="2" style="padding: 8px;">S/. {{ number_format($totalEstado, 2) }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endforeach

        {{-- Resumen Final --}}
        <table border="1" style="margin-top: 20px;">
            <tr style="background-color: #10b981; color: white;">
                <td colspan="11" style="text-align: right; padding: 10px; font-size: 14px;">
                    <strong>TOTAL A PAGAR AL TÉCNICO (Solo Finalizadas):</strong>
                </td>
                <td colspan="2" style="padding: 10px; font-size: 14px;">
                    <strong>S/. {{ number_format($total_costo_finalizadas, 2) }}</strong>
                </td>
            </tr>
        </table>
    @else
        <table border="1">
            <tr>
                <td colspan="13" style="text-align: center; padding: 20px;">
                    No se encontraron órdenes de trabajo con los parámetros especificados
                </td>
            </tr>
        </table>
    @endif

</body>

</html>
