<div class="tabla_borde mb-4">
    <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tbody>
            <tr>
                <td align="left" class="bold" colspan="6">Información de la detracción</td>
            </tr>

            <tr class="border_top">
                <td align="left">Leyenda:</td>
                <td align="left" colspan="5">Operación sujeta al Sistema de Pago de Obligaciones Tributarias con el
                    Gobierno Central
                </td>
            </tr>

            <tr class="border_top">
                <td align="left">Bien o Servicio:</td>
                <td align="left" colspan="5">{{ $venta['detraccion']['codigo_detraccion'] }}
                    {{ $venta->detraccion ? $venta->detraccion->codigo->descripcion : '' }}
                </td>
            </tr>

            <tr class="border_top">
                <td align="left">Medio Pago:</td>
                <td align="left" colspan="5">{{ $venta->metodoPago->codigo }}
                    {{ $venta->metodoPago ? $venta->metodoPago->descripcion : '' }}
                </td>
            </tr>
            <tr class="border_top">
                <td align="left">
                    Nro. Cta. Banco de la
                    Nación:
                </td>
                <td align="left">
                    {{ $venta->detraccion ? $venta->detraccion->cuenta_bancaria : '' }}
                </td>
                <td>
                    Porcentaje de detracción:
                </td>
                <td>
                    {{ $venta->detraccion ? round($venta->detraccion->porcentaje, 2) : '' }}%
                </td>
                <td>
                    Monto detracción:
                </td>
                <td>
                    S/ {{ $venta->detraccion ? round($venta->detraccion->monto, 2) : '' }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
