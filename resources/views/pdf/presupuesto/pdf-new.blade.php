<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>COTIZACION #{{ $presupuesto->serie_correlativo }}</title>

    <link rel="stylesheet" href="{{ public_path('docs/normalize.css') }}">
    <link rel="stylesheet" href="{{ public_path('docs/foundation.css') }}">

    <style type="text/css">
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 12px;
            color: #333;
            background: #fff;
        }

        /* -- CABECERA ------------------------------- */
        .header-wrapper {
            width: 100%;
            border-collapse: collapse;
            border: 0;
            margin-bottom: 14px;
        }

        .header-wrapper td {
            border: 0;
        }

        .header-logo {
            width: 28%;
            vertical-align: middle;
            padding-right: 12px;
        }

        .header-empresa {
            width: 42%;
            vertical-align: middle;
            text-align: center;
            padding: 0 10px;
        }

        .header-empresa .empresa-nombre {
            font-size: 13px;
            font-weight: bold;
            color: #0e2157;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .header-empresa .empresa-dir {
            font-size: 10px;
            color: #555;
            margin-bottom: 2px;
        }

        .header-empresa .empresa-tel {
            font-size: 10px;
            color: #555;
        }

        .header-doc {
            width: 30%;
            vertical-align: middle;
            text-align: center;
            padding-left: 12px;
        }

        .doc-box {
            border: 2px solid #0e2157;
            border-radius: 8px;
            padding: 10px 8px;
            background: #fff;
            line-height: 1.8;
        }

        .doc-box .doc-ruc {
            font-size: 11px;
            font-weight: bold;
            color: #0e2157;
            display: block;
        }

        .doc-box .doc-tipo {
            font-size: 11px;
            font-weight: bold;
            color: #0e2157;
            display: block;
            text-transform: uppercase;
        }

        .doc-box .doc-num {
            font-size: 13px;
            font-weight: bold;
            color: #122f71;
            display: block;
        }


        /* -- CONTENEDOR REDONDEADO ----------------- */
        .tabla-borde {
            border: 1px solid #0e2157;
            border-radius: 8px;
            margin-bottom: 14px;
            overflow: hidden;
        }

        /* -- TABLA PRODUCTOS ------------------------ */
        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table thead tr {
            background-color: #0e2157;
            color: #fff;
        }

        .products-table thead th {
            padding: 7px 8px;
            font-size: 10px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #0e2157;
            color: #fff;
        }

        .products-table thead th.th-desc {
            text-align: left;
        }

        .products-table tbody td {
            border: 0.5px solid #c5cde0;
            padding: 6px 8px;
            font-size: 11px;
            vertical-align: top;
            text-align: center;
        }

        .products-table tbody td.td-desc {
            text-align: left;
        }

        .products-table tbody tr:nth-child(even) td {
            background-color: #f7f9fc;
        }

        .producto-titulo {
            font-weight: bold;
            color: #0e2157;
            margin-bottom: 2px;
            font-size: 11px;
        }

        .descripcion {
            color: #444;
            white-space: pre-line;
            font-size: 10px;
            line-height: 1.4;
        }

        /* -- TOTALES -------------------------------- */
        .totales-tabla {
            width: 270px;
            border-collapse: collapse;
            float: right;
        }

        .totales-tabla td {
            padding: 5px 10px;
            font-size: 11px;
            border: 0.5px solid #c5cde0;
        }

        .totales-tabla td.lbl {
            background-color: #f0f3f9;
            color: #0e2157;
            font-weight: bold;
            text-align: left;
        }

        .totales-tabla td.val {
            text-align: right;
            color: #333;
        }

        .totales-tabla tr.total-row td {
            background-color: #0e2157;
            color: #fff;
            font-weight: bold;
            font-size: 12px;
        }

        .totales-tabla tr.total-row td.val {
            text-align: right;
        }

        /* -- TÉRMINOS ------------------------------- */
        .terminos-section {
            margin-top: 16px;
            clear: both;
        }

        .terminos-titulo {
            background-color: #122f71;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 4px 8px;
            margin-bottom: 6px;
        }

        .terminos-section ul {
            padding-left: 18px;
            margin-bottom: 6px;
        }

        .terminos-section li {
            font-size: 11px;
            color: #444;
            margin-bottom: 3px;
            line-height: 1.5;
        }

        .terminos-section .nota {
            font-size: 11px;
            margin-top: 6px;
            color: #333;
        }

        /* -- PIE DE PÁGINA ------------------------- */
        .footer-wrapper {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            border-top: 3px solid #0e2157;
            padding: 4px 6px;
        }

        .footer-bar {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-bar td {
            font-size: 10px;
            color: #898989;
            vertical-align: middle;
            padding: 2px 6px;
            white-space: nowrap;
        }

        /* -- FEATURES PAGE ------------------------- */
        .page-break {
            page-break-after: always;
        }

        .contenedor-caracteristicas {
            padding: 1rem 1.5rem;
            font-size: 12px;
            max-width: 95%;
            margin: 1rem auto;
        }
    </style>
</head>

<body>
    <div style="padding: 8mm 6mm 20mm 6mm;">

        {{-- ------------------------------------------
         CABECERA: LOGO | EMPRESA | DOCUMENTO
    ------------------------------------------ --}}
        @php
            $dir = $plantilla->direccion;
            $dirTexto = is_array($dir) ? implode(', ', array_filter($dir)) : $dir;
            $simbolo = $presupuesto->divisa == 'PEN' ? 'S/. ' : '$ ';
            $totalDoc = $presupuesto->comision
                ? floatval($presupuesto->total) + floatval($presupuesto->comision)
                : floatval($presupuesto->total);
        @endphp

        <table class="header-wrapper">
            <tr>
                {{-- Logo --}}
                <td class="header-logo">
                    <img src="data:image/jpeg;base64, {{ base64_encode(Storage::get($plantilla->logo)) }}"
                        style="max-width:150px; max-height:70px;">
                </td>

                {{-- Datos empresa --}}
                <td class="header-empresa">
                    <div class="empresa-nombre">{{ $plantilla->razon_social }}</div>
                    <div class="empresa-dir">{{ $dirTexto }}</div>
                    @if ($plantilla->telefono)
                        <div class="empresa-tel">Telf: {{ $plantilla->telefono }}</div>
                    @endif
                </td>

                {{-- RUC + Tipo + Número --}}
                <td class="header-doc">
                    <div class="doc-box">
                        <span class="doc-ruc">R.U.C. {{ $plantilla->ruc }}</span>
                        <span class="doc-tipo">Cotización</span>
                        <span class="doc-num">{{ $presupuesto->serie_correlativo }}</span>
                    </div>
                </td>
            </tr>
        </table>

        {{-- ------------------------------------------
         DATOS DEL CLIENTE
    ------------------------------------------ --}}
        <div class="tabla-borde">
            <table width="100%" border="0" cellpadding="7" cellspacing="0">
                <tbody>
                    <tr>
                        <td width="60%" style="font-size:11px; border-bottom: 0.5px solid #e4e9f0;">
                            <strong style="color:#0e2157;">Razón Social:</strong>
                            {{ $presupuesto->clientes->razon_social }}
                        </td>
                        <td width="40%"
                            style="font-size:11px; border-bottom: 0.5px solid #e4e9f0; border-left: 0.5px solid #e4e9f0;">
                            <strong style="color:#0e2157;">
                                {{ $presupuesto->clientes->tipoDocumento->descripcion ?? 'Doc.' }}:
                            </strong>
                            {{ $presupuesto->clientes->numero_documento ?? '—' }}
                        </td>
                    </tr>
                    <tr>
                        <td width="60%" style="font-size:11px; border-bottom: 0.5px solid #e4e9f0;">
                            <strong style="color:#0e2157;">Fecha Emisión:</strong>
                            {{ $presupuesto->fecha->format('d/m/Y') }}
                        </td>
                        <td width="40%"
                            style="font-size:11px; border-bottom: 0.5px solid #e4e9f0; border-left: 0.5px solid #e4e9f0;">
                            <strong style="color:#0e2157;">Dirección:</strong>
                            {{ $presupuesto->clientes->direccion ?? '—' }}
                        </td>
                    </tr>
                    <tr>
                        <td width="60%" style="font-size:11px;">
                            <strong style="color:#0e2157;">Fecha Vencimiento:</strong>
                            {{ $presupuesto->fecha_caducidad->format('d/m/Y') }}
                        </td>
                        <td width="40%" style="font-size:11px; border-left: 0.5px solid #e4e9f0;">
                            <strong style="color:#0e2157;">Tipo Moneda:</strong>
                            {{ $presupuesto->divisa == 'PEN' ? 'SOLES' : 'DÓLARES' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- ------------------------------------------
         TABLA DE PRODUCTOS/SERVICIOS
    ------------------------------------------ --}}
        <div class="tabla-borde">
            <table class="products-table">
                <thead>
                    <tr>
                        <th style="width:8%;">CANTIDAD</th>
                        <th style="width:10%;">CÓDIGO</th>
                        <th class="th-desc" style="width:50%;">DESCRIPCIÓN</th>
                        <th style="width:16%;">VALOR UNITARIO</th>
                        <th style="width:16%;">VALOR TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($presupuesto->detalles as $detalle)
                        @php
                            $descLineas = $detalle->descripcion ? explode("\n", trim($detalle->descripcion)) : [];
                            $productNombre = trim($detalle->info_producto->descripcion ?? '');
                            // Si la primera línea de descripcion es igual al nombre del producto, omitirla
                            $extraLineas =
                                !empty($descLineas) && trim($descLineas[0]) === $productNombre
                                    ? array_slice($descLineas, 1)
                                    : $descLineas;
                            $detalleExtra = ltrim(implode("\n", $extraLineas));
                        @endphp
                        <tr>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>{{ $detalle->codigo }}</td>
                            <td class="td-desc">
                                <p class="producto-titulo">{{ $detalle->info_producto->descripcion }}</p>
                                @if ($detalleExtra)
                                    <p class="descripcion">{{ $detalleExtra }}</p>
                                @endif
                            </td>
                            <td>{{ $simbolo }}{{ number_format($detalle->valor_unitario, 2) }}</td>
                            <td>{{ $simbolo }}{{ number_format($detalle->sub_total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>{{-- fin tabla items --}}

        {{-- ------------------------------------------
         TOTALES
    ------------------------------------------ --}}
        @if ($presupuesto->divisa == 'USD')
            {{-- USD --}}
            <table class="totales-tabla">
                <tr>
                    <td class="lbl">Sub Total</td>
                    <td class="val">$ {{ number_format($presupuesto->sub_total, 2) }}</td>
                </tr>
                <tr>
                    <td class="lbl">IGV 18%</td>
                    <td class="val">$ {{ number_format($presupuesto->igv, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td class="lbl" style="color:#fff;">Monto Total</td>
                    <td class="val">$ {{ number_format($totalDoc, 2) }}</td>
                </tr>
            </table>

            @if ($presupuesto->total_soles)
                <table class="totales-tabla" style="margin-top:4px;">
                    <tr>
                        <td class="lbl" style="color:#122f71;">Tipo de Cambio</td>
                        <td class="val">{{ $presupuesto->tipo_cambio ?? '—' }}</td>
                    </tr>
                    <tr class="total-row">
                        <td class="lbl" style="color:#fff;">Total Soles</td>
                        <td class="val">S/. {{ number_format($presupuesto->total_soles, 2) }}</td>
                    </tr>
                </table>
            @endif
        @else
            {{-- PEN --}}
            <table class="totales-tabla">
                <tr>
                    <td class="lbl">Sub Total</td>
                    <td class="val">S/. {{ number_format($presupuesto->sub_total, 2) }}</td>
                </tr>
                <tr>
                    <td class="lbl">IGV 18%</td>
                    <td class="val">S/. {{ number_format($presupuesto->igv, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td class="lbl" style="color:#fff;">Monto Total</td>
                    <td class="val">S/. {{ number_format($totalDoc, 2) }}</td>
                </tr>
            </table>
        @endif

        {{-- ------------------------------------------
         TÉRMINOS Y CONDICIONES
    ------------------------------------------ --}}
        <div class="terminos-section">
            <div class="terminos-titulo">Términos y Condiciones</div>
            @if ($presupuesto->terminos && $presupuesto->terminos->isNotEmpty())
                <ul>
                    @foreach ($presupuesto->terminos as $termino)
                        <li>{{ $termino }}</li>
                    @endforeach
                </ul>
            @else
                <ul>
                    <li>Esta cotización es válida hasta su fecha de caducidad.</li>
                    <li>El tiempo de entrega es inmediata, previa solicitud con anticipación.</li>
                </ul>
            @endif

            @if ($presupuesto->nota)
                <p class="nota"><strong>Nota:</strong> {{ $presupuesto->nota }}.</p>
            @endif

            @if ($presupuesto->comentario)
                <p class="nota"><strong>Comentario:</strong> {{ $presupuesto->comentario }}</p>
            @endif
        </div>

    </div>{{-- fin wrapper principal --}}

    {{-- ------------------------------------------
     PIE DE PÁGINA (sub-footer) — fuera del wrapper para position:fixed
------------------------------------------ --}}
    <div class="footer-wrapper">
        <table class="footer-bar">
            <tr>
                <td style="width:22%;">
                    <img style="max-height:28px; max-width:90px;"
                        src="data:image/jpeg;base64, {{ base64_encode(Storage::get($plantilla->logo)) }}">
                </td>
                <td>+51 977 794 338 &nbsp;|&nbsp; +51 944 299 794</td>
                <td>gerencia@talentustechnology.com</td>
                <td style="text-align:right;">www.talentustechnology.com</td>
            </tr>
        </table>
    </div>

    {{-- ------------------------------------------
     HOJA DE CARACTERÍSTICAS (página 2)
------------------------------------------ --}}
    @if ($presupuesto->features)
        <div class="page-break"></div>

        <p style="text-align:center; margin-bottom:20px; padding:0;">
            <strong style="font-size:16px; color:#0e2157;">NUESTROS PRINCIPALES DIFERENCIALES</strong>
        </p>

        <div class="contenedor-caracteristicas">

            <p style="text-align:justify; margin-bottom:10px; line-height:1.5;">
                <span style="color:#0e2157; font-weight:bold; font-size:15px;">•</span>
                <strong>Homologación oficial</strong>
                por SUTRAN, OSINERGMIN, MININTER y Cia Minera Buenaventura en Los Proyectos De Coimolache Y Minera La
                Zanja.
            </p>

            <p style="text-align:justify; margin-bottom:10px; line-height:1.5;">
                <span style="color:#0e2157; font-weight:bold; font-size:15px;">•</span>
                <strong>Equipos europeos Teltonika,</strong> de alta precisión y durabilidad.
            </p>

            <p style="text-align:justify; margin-bottom:10px; line-height:1.5;">
                <span style="color:#0e2157; font-weight:bold; font-size:15px;">•</span>
                <strong>Distribuidores oficiales Teltonika</strong> en Perú.
            </p>

            <p style="text-align:justify; margin-bottom:10px; line-height:1.5;">
                <span style="color:#0e2157; font-weight:bold; font-size:15px;">•</span>
                <strong>Soporte técnico inmediato y especializado,</strong> con atención en línea o presencial.
            </p>

            <p style="text-align:justify; margin-bottom:10px; line-height:1.5;">
                <span style="color:#0e2157; font-weight:bold; font-size:15px;">•</span>
                <strong>Atención personalizada,</strong> orientada a las necesidades de cada cliente y tipo de flota.
            </p>

            <p style="text-align:justify; margin-bottom:10px; line-height:1.5;">
                <span style="color:#0e2157; font-weight:bold; font-size:15px;">•</span>
                <strong>Reportes automatizados,</strong> generados a través de bots inteligentes o programación avanzada
                de la plataforma, configurados según los indicadores del cliente.
            </p>

            <p style="text-align:justify; margin-bottom:10px; line-height:1.5;">
                <span style="color:#0e2157; font-weight:bold; font-size:15px;">•</span>
                <strong>Alertas y notificaciones inteligentes,</strong> en tiempo real, vía plataforma, correo o
                WhatsApp.
            </p>

            <p style="text-align:justify; margin-bottom:10px; line-height:1.5;">
                <span style="color:#0e2157; font-weight:bold; font-size:15px;">•</span>
                <strong>Monitoreo 24/7,</strong> con personal técnico calificado y respuesta rápida ante cualquier
                eventualidad.
            </p>

            <p
                style="text-align:justify; margin-top:15px; padding:10px;
                  background-color:#f0f3f9; border-left:4px solid #0e2157; line-height:1.5;">
                <em>Con <strong>Talentus Technology</strong>, no solo adquiere un GPS, sino una
                    <strong>solución tecnológica completa, segura y certificada</strong>,
                    respaldada por una empresa autorizada y homologada por las principales entidades del país.</em>
            </p>

            <p>&nbsp;</p>

            {{-- FMC920 --}}
            <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
                <tr>
                    <td style="width:35%; vertical-align:top; padding-right:16px;">
                        <img width="220"
                            src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('images/fmc920-side-840xAuto.png')) }}"
                            alt="FMC920">
                    </td>
                    <td style="vertical-align:top;">
                        <p style="font-size:14px; font-weight:bold; color:#0e2157; margin-bottom:6px;">FMC920 - 4G</p>
                        <p style="font-size:11px; color:#898989; margin-bottom:8px;">Teltonika — Características</p>
                        <ul style="list-style-type:disc; padding-left:16px;">
                            <li style="font-size:11px; margin-bottom:3px;">Cobertura 4G con respaldo 2G</li>
                            <li style="font-size:11px; margin-bottom:3px;">Memoria de 128 MB</li>
                            <li style="font-size:11px; margin-bottom:3px;">Buzzer o pánico</li>
                            <li style="font-size:11px; margin-bottom:3px;">Condiciones de manejo: frenado, aceleración
                                y giro brusco (plataforma premium)</li>
                            <li style="font-size:11px; margin-bottom:3px;">Detección de Jumping</li>
                            <li style="font-size:11px; margin-bottom:3px;">Reportes variados: paradas, alertas,
                                kilometrajes (plataforma premium)</li>
                            <li style="font-size:11px; margin-bottom:3px;">Geocercas con reglas de velocidad
                                (plataforma premium)</li>
                        </ul>
                        <p style="font-size:10px; margin-top:8px; color:#555;">
                            Más info: <a
                                href="https://talentustechnology.com/servicios/venta-de-equipos/">talentustechnology.com</a>
                        </p>
                    </td>
                </tr>
            </table>

            {{-- FMC130 --}}
            <table style="width:100%; border-collapse:collapse;">
                <tr>
                    <td style="width:35%; vertical-align:top; padding-right:16px;">
                        <img width="220"
                            src="data:image/jpeg;base64, {{ base64_encode(file_get_contents('images/fmc130-840xAuto.png')) }}"
                            alt="FMC130">
                    </td>
                    <td style="vertical-align:top;">
                        <p style="font-size:14px; font-weight:bold; color:#0e2157; margin-bottom:6px;">FMC130 - 4G</p>
                        <p style="font-size:11px; color:#898989; margin-bottom:8px;">Teltonika — Características</p>
                        <ul style="list-style-type:disc; padding-left:16px;">
                            <li style="font-size:11px; margin-bottom:3px;">Cobertura 4G</li>
                            <li style="font-size:11px; margin-bottom:3px;">Memoria de 128 MB</li>
                            <li style="font-size:11px; margin-bottom:3px;">Corte de motor, buzzer, pánico, apertura de
                                puertas</li>
                            <li style="font-size:11px; margin-bottom:3px;">Condiciones de manejo: frenado, aceleración
                                y giro brusco</li>
                            <li style="font-size:11px; margin-bottom:3px;">Detección de Jumping</li>
                            <li style="font-size:11px; margin-bottom:3px;">Reportes variados: paradas, alertas,
                                kilometrajes</li>
                            <li style="font-size:11px; margin-bottom:3px;">Geocercas con reglas de velocidad</li>
                            <li style="font-size:11px; margin-bottom:3px;">Buzzer o pánico</li>
                        </ul>
                        <p style="font-size:10px; margin-top:8px; color:#555;">
                            Más info: <a
                                href="https://talentustechnology.com/servicios/venta-de-equipos/">talentustechnology.com</a>
                        </p>
                    </td>
                </tr>
            </table>

        </div>
    @endif

</body>

</html>
