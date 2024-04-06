<div class="tabla_borde">
    <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tbody>
            <tr>
                <td align="left" class="bold" colspan="3">Información del crédito</td>
            </tr>
            <tr class="border_top">
                <td align="left">Monto neto pendiente de pago:</td>
                <td align="left" colspan="2">{{ round($venta['total'], 4) }}</td>
            </tr>
            <tr class="border_top border_bottom">
                <td align="left">Total de Cuotas: </td>
                <td align="left" colspan="2">{{ $venta['numero_cuotas'] }}</td>
            </tr>
            {{ count($venta['detalle_cuotas']) }}

            @if ($venta['detalle_cuotas'] > 3)
                si
            @endif
            <tr class="">
                <td colspan="3" align="left" class="v100">
                    <table class="v100 tabla_cuotas">
                        <tbody>

                            @if (count($venta['detalle_cuotas']) > 0 && count($venta['detalle_cuotas']) <= 3)
                                <tr>
                                    @for ($i = 0; $i < count($venta['detalle_cuotas']); $i++)
                                        <td align="left">
                                            <table class="tabla-credito">
                                                <tbody>
                                                    <tr>
                                                        <th>N° Cuota</th>
                                                        <th>Fec. Venc.</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['fecha'] }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['importe'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endfor
                                </tr>
                            @endif


                            @if (count($venta['detalle_cuotas']) > 3 && count($venta['detalle_cuotas']) <= 6)
                                <tr>
                                    @for ($i = 0; $i < 3; $i++)
                                        <td align="left">
                                            <table class="tabla-credito">
                                                <tbody>
                                                    <tr>
                                                        <th>N° Cuota</th>
                                                        <th>Fec. Venc.</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['fecha'] }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['importe'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endfor
                                </tr>

                                <tr>
                                    @for ($i = 3; $i < count($venta['detalle_cuotas']); $i++)
                                        <td align="left">
                                            <table class="tabla-credito">
                                                <tbody>
                                                    <tr>
                                                        <th>N° Cuota</th>
                                                        <th>Fec. Venc.</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['fecha'] }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['importe'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endfor
                                </tr>
                            @endif
                            //3 LINEAS
                            @if (count($venta['detalle_cuotas']) > 6 && count($venta['detalle_cuotas']) <= 9)
                                <tr>
                                    @for ($i = 0; $i < 3; $i++)
                                        <td align="left">
                                            <table class="tabla-credito">
                                                <tbody>
                                                    <tr>
                                                        <th>N° Cuota</th>
                                                        <th>Fec. Venc.</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['fecha'] }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['importe'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endfor
                                </tr>

                                <tr>
                                    @for ($i = 3; $i < 6; $i++)
                                        <td align="left">
                                            <table class="tabla-credito">
                                                <tbody>
                                                    <tr>
                                                        <th>N° Cuota</th>
                                                        <th>Fec. Venc.</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['fecha'] }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['importe'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endfor
                                </tr>
                                <tr>
                                    @for ($i = 6; $i < count($venta['detalle_cuotas']); $i++)
                                        <td align="left">
                                            <table class="tabla-credito">
                                                <tbody>
                                                    <tr>
                                                        <th>N° Cuota</th>
                                                        <th>Fec. Venc.</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['fecha'] }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['importe'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endfor
                                </tr>
                            @endif
                            //4 LINEAS

                            //3 LINEAS
                            @if (count($venta['detalle_cuotas']) > 9 && count($venta['detalle_cuotas']) <= 12)
                                <tr>
                                    @for ($i = 0; $i < 3; $i++)
                                        <td align="left">
                                            <table class="tabla-credito">
                                                <tbody>
                                                    <tr>
                                                        <th>N° Cuota</th>
                                                        <th>Fec. Venc.</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['fecha'] }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['importe'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endfor
                                </tr>

                                <tr>
                                    @for ($i = 3; $i < 6; $i++)
                                        <td align="left">
                                            <table class="tabla-credito">
                                                <tbody>
                                                    <tr>
                                                        <th>N° Cuota</th>
                                                        <th>Fec. Venc.</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['fecha'] }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['importe'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endfor
                                </tr>
                                <tr>
                                    @for ($i = 6; $i < 9; $i++)
                                        <td align="left">
                                            <table class="tabla-credito">
                                                <tbody>
                                                    <tr>
                                                        <th>N° Cuota</th>
                                                        <th>Fec. Venc.</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['fecha'] }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['importe'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endfor
                                </tr>
                                <tr>
                                    @for ($i = 9; $i < count($venta['detalle_cuotas']); $i++)
                                        <td align="left">
                                            <table class="tabla-credito">
                                                <tbody>
                                                    <tr>
                                                        <th>N° Cuota</th>
                                                        <th>Fec. Venc.</th>
                                                        <th>Monto</th>

                                                    </tr>
                                                    <tr>
                                                        <td>{{ $i + 1 }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['fecha'] }}</td>
                                                        <td>{{ $venta['detalle_cuotas'][$i]['importe'] }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    @endfor
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>
