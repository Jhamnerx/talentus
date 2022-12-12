<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>COTIZACION #{{ $presupuesto->numero }}</title>


    {{-- <link rel="stylesheet" href="{{ ltrim(public_path('presupuesto/normalize.css'), '/') }}" />
    <link rel="stylesheet" href="{{ ltrim(public_path('presupuesto/foundation.css'), '/') }}" />
    <link rel="stylesheet" href="{{ ltrim(public_path('presupuesto/style.css'), '/') }}" /> --}}

    <link rel="stylesheet" href="{{ asset('docs/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('docs/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('docs/presupuesto/style.css') }}">

    <style type="text/css">
        .footer {
            padding-top: 2rem;
        }

        .header-bottom .invoice-header table tbody td {
            padding: 20px;
            background: url("data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/arrow.png')) }}") no-repeat 20px top #ed832f;

            font-size: 16px;
            color: #fff;
        }

        .header-bottom .invoice-header table .circle {
            background: url("data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/circle.png')) }}") no-repeat scroll 0 0/100% auto rgba(0, 0, 0, 0);
            height: 50px;
            padding: 10px 4px;
            text-align: center;
            width: 40px;
        }

        .footer {
            padding: 30px 0;
            background: url("data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/footer.png')) }}") no-repeat top;

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
                    src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/logo.png')) }}">
            </div>

            <div class="medium-3 columns">
                <div class="header-contact">
                    <img class="icon-mail"
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/mail.png')) }}">
                    <p>gerencia@talentustechnology.com<br>
                        administracion@talentustechnology.com<br>
                        soporte@talentustechnology.com.com</p>
                </div>
            </div>

            <div class="medium-3 columns">
                <div class="header-contact">
                    <img class="icon-telephone"
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/phone.png')) }}">
                    <p>+51 977 794 338<br>
                        Lunes a Viernes<br>
                        9am a 7pm Lineas abiertas</p>
                </div>
            </div>


        </div>
        <!--header-->


        <div class="header-bottom row">

            <div class="large-5 medium-5 columns header-bottom-left">

                <h3><img class="icon-invoice"
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/invoice.png')) }}"></i>
                    COTIZACION A:</h3>
                <h2>{{ $presupuesto->clientes->razon_social }}</h2>
                <p style="margin-bottom:10px;line-height:22px;">{{ $presupuesto->clientes->direccion }}<br>
                </p>

                <p style="margin-bottom:10px;"><img class="icon-mail"
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/mail.png')) }}"></i>{{ $presupuesto->clientes->email }}
                </p>
                <p><img class="icon-mobile"
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/mobile.png')) }}"></i>{{ $presupuesto->clientes->telefono }}
                </p>

            </div>

            <div class="large-7 medium-7 columns invoice-header">

                <h2>COTIZACION: #{{ $presupuesto->numero }}</h2>

                <table>
                    <thead>
                        <tr>
                            <td>
                                <div class="circle"><img class="icon-dollar"
                                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/dollar.png')) }}">
                                </div>
                            </td>
                            <td>
                                <div class="circle"><img class="icon-calendar"
                                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/calendar.png')) }}">
                                </div>
                            </td>
                            <td>
                                <div class="circle"><img class="icon-calendar"
                                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/calendar.png')) }}">
                                </div>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                Monto Total:<br>
                                <strong>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ $presupuesto->total }}</strong>
                            </td>
                            <td>
                                Fecha Emisión:<br>
                                <strong>{{ $presupuesto->fecha->format('d/m/Y') }}</strong>
                            </td>
                            <td>
                                Fecha Venc.:<br>
                                <strong>{{ $presupuesto->fecha_caducidad->format('d/m/Y') }}</strong>
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

                        @foreach ($presupuesto->detalles as $detalle)
                            <tr>
                                <td>
                                    <p>{{ $detalle->producto }}.</p>
                                    <p>{{ $detalle->descripcion }}</p>
                                </td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ $detalle->precio }}</td>
                                <td>{{ $detalle->cantidad }}</td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ $detalle->total }}</td>
                            </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>


        <div class="row" style="margin-top: 4rem">

            @if ($presupuesto->divisa == 'USD')
                <div class="medium-3 columns bottom-left show-for-medium-up ">
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
                <div class="medium-4 large-offset-3 columns totals">
                    <table>
                        <tbody>
                            <tr>
                                <td>SUB TOTAL:</td>
                                <td>S/. {{ number_format($presupuesto->sub_total_soles, 2) }}</td>
                            </tr>
                            <tr>
                                <td>IGV: 18%</td>
                                <td>S/. {{ number_format($presupuesto->impuesto_soles, 2) }}</td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Monto Total:</td>
                                <td>S/. {{ number_format($presupuesto->total_soles, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="medium-4 large-offset-3 columns totals">
                    <table>
                        <tbody>
                            <tr>
                                <td>SUB TOTAL:</td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->sub_total, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>IGV: 18%</td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->impuesto, 2) }}
                                </td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Monto Total:</td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->total, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="medium-6 columns bottom-left show-for-medium-up ">
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
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->sub_total, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>IGV: 18%</td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->impuesto, 2) }}
                                </td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Monto Total:</td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->total, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif

        </div>

        <div class="row terms">
            <div class="large-12 columns">
                <p><strong>Terminos:</strong> Esta cotizacion es valida hasta su fecha de caducidad.</p>
            </div>
        </div>
        @if (count($presupuesto->detalles) > 6)
            <div class="footer row">
                <div class="medium-2 columns">
                    <img
                        src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('docs/presupuesto/images/footer-logo.png')) }}">
                </div>
                <div class="medium-3 large-offset-1 columns">
                    <p>+51 977 794 338<br>
                </div>

                <div class="medium-3 columns">
                    <p style="border:none;">www.talentustechnology.com</p>
                </div>
            </div>
        @endif

    </div>
    <!--screen-->



</body>

</html>
