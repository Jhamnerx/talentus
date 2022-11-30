<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FACTURA #{{ $factura->serie_numero }}</title>

    <link rel="stylesheet" href="{{ asset('docs/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('docs/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('docs/factura/style.css') }}">

    <style type="text/css">
        .header-bottom .invoice-header table tbody td {
            padding: 20px;
            background: url("data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/arrow.png')) }}") no-repeat 20px top #052c52;

            font-size: 16px;
            color: #fff;
        }

        .header-bottom .invoice-header table .circle {
            background: url("data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/circle.png')) }}") no-repeat scroll 0 0/100% auto rgba(0, 0, 0, 0);
            height: 50px;
            padding: 10px 4px;
            text-align: center;
            width: 40px;
        }

        .footer {
            padding: 2px 0;

            background: url("data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/footer.png')) }}") no-repeat top;
            font-size: 14px;
            color: #ababab;
        }
    </style>
</head>

<body>


    <div>

        <div class="header row">

            <div class="medium-6 columns">

                <img
                    src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/logo.png')) }}">
            </div>

            <div class="medium-3 columns">
                <div class="header-contact">
                    <img class="icon-mail"
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/mail.png')) }}">
                    <p>gerencia@talentustechnology.com<br>
                        administracion@talentustechnology.com<br>
                        soporte@talentustechnology.com.com</p>
                </div>
            </div>

            <div class="medium-3 columns">
                <div class="header-contact">
                    <img class="icon-telephone"
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/phone.png')) }}">
                    <p>+51 977 794 338<br>
                        +51 944 299 794<br>
                        Lunes a Viernes<br>
                        9am a 7pm Lineas abiertas</p>
                </div>
            </div>


        </div>
        <!--header-->


        <div class="header-bottom row">

            <div class="large-5 medium-5 columns header-bottom-left">

                <h3><img class="icon-invoice"
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/invoice.png')) }}"></i>
                    FACTURA A:</h3>
                <h2>{{ $factura->clientes->razon_social }}</h2>
                <p style="margin-bottom:10px;line-height:22px;">{{ $factura->clientes->direccion }}<br>
                </p>

                <p style="margin-bottom:10px;"><img class="icon-mail"
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/mail.png')) }}"></i>{{ $factura->clientes->email }}
                </p>
                <p><img class="icon-mobile"
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/mobile.png')) }}"></i>{{ $factura->clientes->telefono }}
                </p>

            </div>

            <div class="large-7 medium-7 columns invoice-header">

                <h2>FACTURA</h2>

                <table>
                    <thead>
                        <tr>
                            <td>
                                <div class="circle"><img class="icon-dollar"
                                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/dollar.png')) }}">
                                </div>
                            </td>
                            <td>
                                <div class="circle"><img class="icon-calendar"
                                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/calendar.png')) }}">
                                </div>
                            </td>
                            <td>
                                <div class="circle"><img class="icon-calendar"
                                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/barcode.png')) }}">
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Monto Total:<br>
                                <strong>{{ $factura->divisa == 'PEN' ? 'S/. ' : '$' }}{{ $factura->total }}</strong>
                            </td>
                            <td>
                                Fecha Emisión:<br>
                                <strong>{{ $factura->fecha_emision->format('d/m/Y') }}</strong>
                            </td>
                            <td>
                                Factura #:<br>
                                <strong>{{ $factura->serie_numero }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
        <!--header-bottom-->

        <div class="row">
            <div class="large-12 columns">
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Producto/Servicio</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($factura->detalles as $detalle)
                            <tr>
                                <td>
                                    <p> {{ $detalle->producto }}</p>
                                    <p>{{ $detalle->descripcion }}</p>

                                </td>
                                <td>{{ $factura->divisa == 'PEN' ? 'S/. ' : '$' }}{{ $detalle->precio }}</td>
                                <td>{{ $detalle->cantidad }}</td>
                                <td>{{ $factura->divisa == 'PEN' ? 'S/. ' : '$' }}{{ $detalle->importe }}</td>
                            </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>


        <div class="row" style="margin-top: 2rem">
            <div class="large-5 medium-6 small-12 columns bottom-left ">
                <table>
                    <thead>
                        <tr>
                            <th><strong>Metodos de Pago:</strong> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p><strong>BCP SOLES: </strong>245-2172979-0-27 | CCI: 00224500217297902795</p>
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <p><strong>BCP USD: </strong>245-2126663-1-36 | CCI: 00224500216266313696</p>
                            </td>

                        </tr>
                        <tr>

                            <td>
                                <p><strong>BBVA: </strong>0011-0248-02-00393480 | CCI: 011-248-000200399480-25</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="medium-6 large-offset-3 columns totals">
                <table>
                    <tbody>
                        <tr>
                            <td>SUB TOTAL:</td>
                            <td>{{ $factura->divisa == 'PEN' ? 'S/. ' : '$' }}{{ $factura->subtotal }}
                            </td>
                        </tr>
                        <tr>
                            <td>IGV: 18%</td>
                            <td>{{ $factura->divisa == 'PEN' ? 'S/. ' : '$' }}{{ $factura->impuesto }}
                            </td>
                        </tr>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Monto Total:</td>
                            <td>{{ $factura->divisa == 'PEN' ? 'S/. ' : '$' }}{{ $factura->total }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>


        </div>

        @if (count($factura->detalles) > 2)
            <div class="footer" style="margin-top: 180px;"></div>
        @else
            <div class="footer" style="margin-top: 120px;"></div>
        @endif

        <div class="sub-footer row">
            <div class="large-5 medium-3 columns">
                <img
                    src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/factura/images/footer-logo.png')) }}">
            </div>
            <div class="large-2 medium-3 large-offset-1 columns">
                <p>+51 977 794 338<br>
                    +51 944 299 794</p>
            </div>

            <div class="large-2 medium-3 columns">
                <p>gerencia@talentustechnology.com</p>
            </div>

            <div class="large-2 medium-3 columns">
                <p style="border:none;">www.talentustechnology.com</p>
            </div>
        </div>
    </div>
    <!--screen-->



</body>

</html>
