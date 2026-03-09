<html>

<head>
    <style type="text/css">
        body,
        div,
        table,
        thead,
        tbody,
        tfoot,
        tr,
        th,
        td,
        p {
            font-family: "Calibri";
            font-size: x-small
        }
    </style>
</head>

<body>
    <table cellspacing="0" border="0">
        <colgroup width="120"></colgroup>
        <colgroup width="120"></colgroup>
        <colgroup width="250"></colgroup>
        <colgroup width="120"></colgroup>
        <colgroup width="150"></colgroup>
        <colgroup width="100"></colgroup>
        <colgroup width="100"></colgroup>
        <colgroup width="100"></colgroup>
        <colgroup width="100"></colgroup>
        <colgroup width="100"></colgroup>
        <colgroup width="100"></colgroup>
        <colgroup width="150"></colgroup>
        <colgroup width="100"></colgroup>

        <tr style="color: #fff">
            <td style="border: 2px solid #dee2e6" height="21" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">FECHA EMISIÓN</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">F. VENCIMIENTO</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">PROVEEDOR</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">RUC/DNI</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">COMPROBANTE</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">SERIE-CORR</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">FORMA PAGO</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">N° CUOTAS</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">DIVISA</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">SUB TOTAL</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">IGV</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">TOTAL</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">PAGADO</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">SALDO</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">ESTADO</font>
                </b>
            </td>
            <td style="border: 2px solid #dee2e6" align="center" valign="center" bgcolor="#052c52">
                <b>
                    <font face="Arial" size=1 color="#FFFFFF">OBSERVACIÓN</font>
                </b>
            </td>
        </tr>

        @foreach ($compras as $compra)
            <tr>
                <td style="border: 1px solid #dee2e6" align="center">
                    {{ $compra->fecha_emision->format('d/m/Y') }}
                </td>
                <td style="border: 1px solid #dee2e6" align="center">
                    {{ $compra->fecha_vencimiento ? $compra->fecha_vencimiento->format('d/m/Y') : '-' }}
                </td>
                <td style="border: 1px solid #dee2e6" align="left">
                    {{ $compra->proveedor->razon_social }}
                </td>
                <td style="border: 1px solid #dee2e6" align="center">
                    {{ $compra->proveedor->numero_documento }}
                </td>
                <td style="border: 1px solid #dee2e6" align="left">
                    {{ $compra->tipoComprobante ? $compra->tipoComprobante->descripcion : '-' }}
                </td>
                <td style="border: 1px solid #dee2e6" align="center">
                    {{ $compra->serie_correlativo }}
                </td>
                <td style="border: 1px solid #dee2e6" align="center">
                    {{ $compra->forma_pago }}
                </td>
                <td style="border: 1px solid #dee2e6" align="center">
                    {{ $compra->numero_cuotas > 0 ? $compra->numero_cuotas : '-' }}
                </td>
                <td style="border: 1px solid #dee2e6" align="center">
                    {{ $compra->divisa }}
                </td>
                <td style="border: 1px solid #dee2e6" align="right">
                    {{ number_format($compra->sub_total, 2) }}
                </td>
                <td style="border: 1px solid #dee2e6" align="right">
                    {{ number_format($compra->igv, 2) }}
                </td>
                <td style="border: 1px solid #dee2e6" align="right">
                    {{ number_format($compra->total, 2) }}
                </td>
                <td style="border: 1px solid #dee2e6" align="right">
                    {{ number_format($compra->total_pagado, 2) }}
                </td>
                <td style="border: 1px solid #dee2e6" align="right">
                    {{ number_format($compra->saldo_pendiente, 2) }}
                </td>
                <td style="border: 1px solid #dee2e6" align="center">
                    @if ($compra->estado == 'ANULADO')
                        ANULADO
                    @elseif($compra->isPaid())
                        PAGADO
                    @elseif($compra->total_pagado > 0)
                        PARCIAL
                    @else
                        PENDIENTE
                    @endif
                </td>
                <td style="border: 1px solid #dee2e6" align="left">
                    {{ $compra->observacion ?? '' }}
                </td>
            </tr>
        @endforeach

        <!-- Fila de totales -->
        <tr style="background-color: #f8f9fa; font-weight: bold;">
            <td colspan="9" style="border: 2px solid #dee2e6" align="right">
                <b>TOTALES:</b>
            </td>
            <td style="border: 2px solid #dee2e6" align="right">
                <b>{{ number_format($compras->sum('sub_total'), 2) }}</b>
            </td>
            <td style="border: 2px solid #dee2e6" align="right">
                <b>{{ number_format($compras->sum('igv'), 2) }}</b>
            </td>
            <td style="border: 2px solid #dee2e6" align="right">
                <b>{{ number_format($compras->sum('total'), 2) }}</b>
            </td>
            <td style="border: 2px solid #dee2e6" align="right">
                <b>{{ number_format($compras->sum('total_pagado'), 2) }}</b>
            </td>
            <td style="border: 2px solid #dee2e6" align="right">
                <b>{{ number_format($compras->sum('saldo_pendiente'), 2) }}</b>
            </td>
            <td colspan="2" style="border: 2px solid #dee2e6"></td>
        </tr>
    </table>
</body>

</html>
