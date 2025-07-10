<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>COTIZACION #{{ $presupuesto->serie_correlativo }}</title>

    <link rel="stylesheet" href="{{ public_path('docs/normalize.css') }}">
    <link rel="stylesheet" href="{{ public_path('docs/foundation.css') }}">
    <link rel="stylesheet" href="{{ public_path('docs/presupuesto/style.css') }}">

    <style type="text/css">
        .page-break {
            page-break-after: always;
        }

        .footer {
            padding-top: 2rem;
        }

        .header-bottom .invoice-header table tbody td {
            padding: 20px;
            background-color: #ed832f;
            background-image: url("data:image/jpeg;base64, {{ base64_encode(file_get_contents(public_path('docs/presupuesto/images/arrow.png'))) }}");
            background-repeat: no-repeat;
            background-position: 20px top;
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

        .contenedor-caracteristicas {
            padding: 2rem, 2rem;
            font-size: 12px;
            display: block;
            flex-wrap: wrap;
            overflow: hidden;

            margin-top: 3.8rem;
            margin-left: 2.8rem;
            margin-right: 6rem;
            margin-bottom: 3.8rem;
            padding-bottom: 1rem;
        }

        .producto-titulo {
            font-size: 16px;
        }

        .descripcion {
            font-size: 15px;
        }
    </style>
</head>

<body>


    <div>

        <div class="header row">

            <div class="medium-6 columns">

                <img src="data:image/jpeg;base64, {{ base64_encode(Storage::get($plantilla->logo)) }}">

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

                <h2>COTIZACION: #{{ $presupuesto->serie_correlativo }}</h2>

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
                            @php
                                $total = $presupuesto->comision
                                    ? floatval($presupuesto->total + $presupuesto->comision)
                                    : floatval($presupuesto->total);
                            @endphp
                            <td>
                                Monto Total:<br>
                                <strong>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ $total }}</strong>
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
                            <th>codigo</th>
                            <th>Cantidad</th>
                            <th>Valor unitario</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($presupuesto->detalles as $detalle)
                            <tr>
                                <td>
                                    <p class="producto-titulo"><b>{{ $detalle->info_producto->descripcion }}</b>.
                                    </p>
                                    <p class="descripcion">{{ $detalle->descripcion }}</p>
                                </td>
                                <td>{{ $detalle->unit }}
                                </td>
                                <td>{{ $detalle->cantidad }}

                                </td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ round($detalle->valor_unitario, 2) }}
                                </td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ round($detalle->sub_total, 2) }}
                                </td>
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
                        @if ($plantilla->empresa_id == 1)
                            <tbody>
                                <tr>
                                    <td>
                                        <p><strong>METODOS DE PAGO NACIONAL</strong></p>
                                    </td>
                                </tr>
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
                                        <p><strong>BBVA: </strong>0011-0248-02-00393480 | CCI: 011-248-000200399480-25
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p><strong>METODOS DE PAGO INTERNACIONAL</strong></p>
                                    </td>
                                </tr>
                                <tr>

                                    <td>
                                        <p><strong>CODIGO SWIF: BCONPEPL </strong>
                                            CUENTA: 00110248 26 0200481886</p>
                                    </td>
                                </tr>
                            </tbody>
                        @elseif ($plantilla->empresa_id == 2)
                            <tbody>
                                <tr>
                                    <td>
                                        <p>KATARY SERVICIOS GENERALES</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p><strong>BCP CTA CTE SOLES: </strong>245-2669042-0-66</p>
                                    </td>
                                </tr>
                                <tr>

                                    <td>
                                        <p><strong>BCP CCI SOLES: </strong>00224500266904206691</p>
                                    </td>

                                </tr>
                                <tr>

                                    <td>
                                        <p><strong>BCP CTA DOLARES: </strong>245-2663487-1-64 | CCI:
                                            00224500266348716499</p>
                                    </td>
                                </tr>
                                <tr>

                                    <td>
                                        <p><strong>CODIGO SWIF: BCONPEPL </strong>
                                            CUENTA: 00110248 26 0200481886</p>
                                    </td>
                                </tr>
                            </tbody>
                        @endif

                    </table>
                </div>
                <div class="medium-4 large-offset-3 columns totals">
                    <table>
                        <tbody>
                            <tr>
                                <td>SUB TOTAL:</td>
                                <td>S/. {{ number_format($presupuesto->sub_total_soles, 2) }}</td>
                            </tr>
                            @if ($presupuesto->descuento)
                                <tr>
                                    <td>DESCUENTO:</td>
                                    <td>S/. {{ number_format($presupuesto->descuento, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>IGV: 18%</td>
                                <td>S/. {{ number_format($presupuesto->igv_soles, 2) }}</td>
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
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->igv, 2) }}
                                </td>
                            </tr>
                            @if ($presupuesto->comision)
                                <tr>
                                    <td>COMISION EXTRAJERO: </td>
                                    <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->comision, 2) }}
                                    </td>
                                </tr>
                            @endif


                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Monto Total:</td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->total + $presupuesto->comision, 2) }}
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
                        @if ($plantilla->empresa_id == 1)
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
                                        <p><strong>BBVA: </strong>0011-0248-02-00393480 | CCI: 011-248-000200399480-25
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        @elseif ($plantilla->empresa_id == 2)
                            <tbody>
                                <tr>
                                    <td>
                                        <p>KATARY SERVICIOS GENERALES</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p><strong>BCP CTA CTE SOLES: </strong>245-2669042-0-66</p>
                                    </td>
                                </tr>
                                <tr>

                                    <td>
                                        <p><strong>BCP CCI SOLES: </strong>00224500266904206691</p>
                                    </td>

                                </tr>
                                <tr>

                                    <td>
                                        <p><strong>BCP CTA DOLARES: </strong>245-2663487-1-64</p>
                                    </td>

                                </tr>
                                <tr>

                                    <td>
                                        <p><strong>BCP CCI DOLARES: </strong>00224500266348716499 </p>
                                    </td>

                                </tr>
                            </tbody>
                        @endif
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
                            @if ($presupuesto->descuento)
                                <tr>
                                    <td>DESCUENTO:</td>
                                    <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}
                                        {{ number_format($presupuesto->descuento, 2) }}</td>
                                </tr>
                            @endif
                            @if ($presupuesto->op_gravadas)
                                <tr>
                                    <td>OP. GRAVADAS:</td>
                                    <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}
                                        {{ number_format($presupuesto->op_gravadas, 2) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>IGV: 18%</td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->igv, 2) }}
                                </td>
                            </tr>
                            @if ($presupuesto->comision)
                                <tr>
                                    <td>COMISION EXTRAJERO: </td>
                                    <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->comision, 2) }}
                                    </td>
                                </tr>
                            @endif


                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Monto Total:</td>
                                <td>{{ $presupuesto->divisa == 'PEN' ? 'S/. ' : '$' }}{{ number_format($presupuesto->total + $presupuesto->comision, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif

        </div>

        <div class="row terms">
            <div class="large-12 columns">

                @if ($presupuesto->terminos)
                    <p><strong>Terminos:</strong></p>
                    <ul>

                        @foreach ($presupuesto->terminos as $termino)
                            <li>{{ $termino }}</li>
                        @endforeach



                    </ul>
                @else
                    <p><strong>Terminos:</strong></p>
                    <ul>
                        <li>Esta cotizacion es valida hasta su fecha de caducidad</li>
                        <li>El tiempo de entrega es inmediata previa solicitud con anticipación</li>

                    </ul>
                @endif

            </div>
        </div>
        @if ($presupuesto->nota)
            <div class="row terms">
                <div class="large-12 columns">
                    <p><strong>Nota:</strong> {{ $presupuesto->nota }}.</p>
                </div>
            </div>
        @endif
        @if (count($presupuesto->detalles) > 2)
            <div class="footer" style="margin-top: 180px;"></div>
        @else
            <div class="footer" style="margin-top: 120px;"></div>
        @endif
        <div class="sub-footer row">
            <div class="large-5 medium-3 columns">
                <img style="margin-top: -25px"
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



    </div>
    <!--screen-->

    @if ($presupuesto->features)
        <div class="page-break"></div>

        <p style="text-align:center;"><strong>Ofrecemos una solución PERSONALIZABLE y ESCALABLE para la gestión de su
                flota de vehículos, con las siguientes características.</strong></p>
        <div class="row contenedor-caracteristicas">

            <p style="text-align:justify;"><span style="color:black;">1. Visualización en tiempo real de la ubicación de
                    sus
                    vehículos en todo el territorio nacional.</span></p>
            <p style="text-align:justify;"><span style="color:black;">2. Transmisión/Actualización de la posición según
                    plan
                    seleccionado cuando el vehículo se encuentre en movimiento, en caso no haya eventos (1min).</span>
            </p>
            <p style="text-align:justify;"><span style="color:black;">3. Rutas recorridas por cada unidad.</span></p>
            <p style="text-align:justify;"><span style="color:black;">4. Velocidad durante estos desplazamientos.</span>
            </p>
            <p style="text-align:justify;"><span style="color:black;">5. Tiempo y lugar de cada una de sus
                    paradas.</span>
            </p>
            <p style="text-align:justify;"><span style="color:black;">6. <strong>Geocercas, sólo plataforma
                        premium</strong></span></p>
            <p style="text-align:justify;"><span style="color:black;">7. Alerta de Velocidad con Zumbador en Cabina
                    (opcional)</span></p>
            <p style="text-align:justify;"><span style="color:black;">8. Soporte técnico ilimitado para absolución de
                    dudas
                    y consultas en línea&nbsp;</span></p>
            <p style="text-align:justify;"><span style="color:black;">9. Consulta de Reportes hasta 30 días de
                    almacenamiento de la unidad.</span></p>
            <p style="text-align:justify;"><span style="color:black;">10. Central de Monitoreo las 24 horas del día los
                    365
                    días del año.</span></p>
            <p>&nbsp;</p>

            <main id="main" class="site-main" style="margin-top: 20rem">
                {{-- FMB920 --}}
                <div class="ast-woocommerce-container">
                    <div class="woocommerce-notices-wrapper"></div>
                    <div id="product-312"
                        class="ast-article-single ast-woo-product-no-review desktop-align-left tablet-align-left mobile-align-left product type-product post-312 status-publish first instock product_cat-feminine-deodorants has-post-thumbnail shipping-taxable purchasable product-type-simple">
                        <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images"
                            data-columns="4" style="opacity: 1; transition: opacity 0.25s ease-in-out 0s;">
                            <figure class="image">
                                <img width="350px"
                                    src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('images/fmb920-840xAuto.png')) }}"
                                    alt="fmb920.png">
                            </figure>
                        </div>
                        <div class="summary entry-summary">
                            <span class="single-product-category">
                                <a rel="tag">Teltonika</a>
                            </span>
                            <h1 class="product_title entry-title">FMB920 -2G</h1>
                            <p class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                            class="woocommerce-Price-currencySymbol">-
                                        </span>Características</bdi></span></p>

                            <div class="woocommerce-product-details__short-description">
                                <ul style="list-style-type:disc;">
                                    <li style="text-align:justify;"><span style="color:black;">Cobertura 2G</span>
                                    </li>
                                    <li style="text-align:justify;"><span style="color:black;">Memoria de
                                            128mg.</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Buzzer o pánico.</span>
                                    </li>
                                    <li style="text-align:justify;"><span style="color:black;">Condiciones de manejo:
                                            Frenado
                                            aceleración
                                            y
                                            giro brusco (en plataforma premium)</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Detección de
                                            Jumping</span>
                                    </li>
                                    <li style="text-align:justify;"><span style="color:black;">Diferentes tipos de
                                            reportes:
                                            (Paradas,
                                            Alertas, kilometrajes, etc, en plataforma premium)</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Geo cercas amarradas a
                                            reglas
                                            de velocidad
                                            (en
                                            plataforma premium)</span></li>
                                </ul>
                            </div>

                            <div class="product_meta">
                                <span class="posted_in">Mas info:
                                    <a href="https://talentustechnology.com/servicios/venta-de-equipos/"
                                        rel="tag">
                                        Click Aquí
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FMC920 --}}
                <div class="ast-woocommerce-container">
                    <div class="woocommerce-notices-wrapper"></div>
                    <div id="product-312"
                        class="ast-article-single ast-woo-product-no-review desktop-align-left tablet-align-left mobile-align-left product type-product post-312 status-publish first instock product_cat-feminine-deodorants has-post-thumbnail shipping-taxable purchasable product-type-simple">
                        <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images"
                            data-columns="4" style="opacity: 1; transition: opacity 0.25s ease-in-out 0s;">
                            <figure class="image">
                                <img width="350px"
                                    src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('images/fmc920-side-840xAuto.png')) }}"
                                    alt="fmb920.png">
                            </figure>
                        </div>
                        <div class="summary entry-summary">
                            <span class="single-product-category">
                                <a rel="tag">Teltonika</a>
                            </span>
                            <h1 class="product_title entry-title">FMC920 - 4G</h1>
                            <p class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                            class="woocommerce-Price-currencySymbol">-
                                        </span>Características</bdi></span></p>

                            <div class="woocommerce-product-details__short-description">
                                <ul style="list-style-type:disc;">
                                    <li style="text-align:justify;"><span style="color:black;">Cobertura 4G con
                                            respaldo 2G</span>
                                    </li>
                                    <li style="text-align:justify;"><span style="color:black;">Memoria de
                                            128mg.</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Buzzer o pánico.</span>
                                    </li>
                                    <li style="text-align:justify;"><span style="color:black;">Condiciones de manejo:
                                            Frenado
                                            aceleración
                                            y
                                            giro brusco (en plataforma premium)</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Detección de
                                            Jumping</span>
                                    </li>
                                    <li style="text-align:justify;"><span style="color:black;">Diferentes tipos de
                                            reportes:
                                            (Paradas,
                                            Alertas, kilometrajes, etc, en plataforma premium)</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Geo cercas amarradas a
                                            reglas
                                            de velocidad
                                            (en
                                            plataforma premium)</span></li>
                                </ul>
                            </div>

                            <div class="product_meta">
                                <span class="posted_in">Mas info:
                                    <a href="https://talentustechnology.com/servicios/venta-de-equipos/"
                                        rel="tag">
                                        Click Aquí
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- FMC130 --}}
                <div class="ast-woocommerce-container">
                    <div class="woocommerce-notices-wrapper"></div>
                    <div id="product-312"
                        class="ast-article-single ast-woo-product-no-review desktop-align-left tablet-align-left mobile-align-left product type-product post-312 status-publish first instock product_cat-feminine-deodorants has-post-thumbnail shipping-taxable purchasable product-type-simple">
                        <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images"
                            data-columns="4" style="opacity: 1; transition: opacity 0.25s ease-in-out 0s;">
                            <figure class="image">
                                <img width="350px"
                                    src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('images/fmc130-840xAuto.png')) }}"
                                    alt="fmc130.png">
                            </figure>
                        </div>
                        <div class="summary entry-summary">
                            <span class="single-product-category">
                                <a rel="tag">Teltonika</a>
                            </span>
                            <h1 class="product_title entry-title">FMC130-4G</h1>
                            <p class="price"><span class="woocommerce-Price-amount amount"><bdi><span
                                            class="woocommerce-Price-currencySymbol">-
                                        </span>Características</bdi></span></p>

                            <div class="woocommerce-product-details__short-description">
                                <ul style="list-style-type:disc;">
                                    <li style="text-align:justify;"><span style="color:black;">Cobertura 4G</span>
                                    </li>
                                    <li style="text-align:justify;"><span style="color:black;">Memoria de
                                            128mg.</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Corte de motor, buzzer,
                                            pánico,
                                            apertura de
                                            puertas</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Condiciones de manejo:
                                            Frenado
                                            aceleración
                                            y
                                            giro brusco.</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Detección de
                                            Jumping.</span>
                                    </li>
                                    <li style="text-align:justify;"><span style="color:black;">Diferentes tipos de
                                            reportes:
                                            (Paradas,
                                            Alertas, kilometrajes, etc)</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Geo cercas amarradas a
                                            reglas
                                            de
                                            velocidad</span></li>
                                    <li style="text-align:justify;"><span style="color:black;">Buzzer o pánico.</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="product_meta">
                                <span class="posted_in">Mas info:
                                    <a href="https://talentustechnology.com/servicios/venta-de-equipos/"
                                        rel="tag">
                                        Click Aquí
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    @endif

</body>

</html>
