<!DOCTYPE html>
<html>

<head>
    <title>CERTIFICADO ANTIFATIGA {{ $certificado->vehiculo->placa }}
        {{ $certificado->ciudades->prefijo . '-' . $certificado->year . '-' . $certificado->numero }}</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {{ header('Content-type:application/pdf') }} <style type="text/css">
        /* -- Base -- */
        body {
            font-family: 'Arial', sans-serif;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            color: #333;
            height: 100%;
            width: 100%;
        }

        html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        /* Estructura principal */
        .certificado {
            display: flex;
            flex-wrap: wrap;
            overflow: hidden;
            margin: 0;
            width: 100%;
            background-color: transparent;
        }

        /* Contenido interno con margen */
        .contenido {
            width: calc(100% - 60px);
            margin: 80px 30px 30px 30px;
            padding-top: 30px;
            position: relative;
            box-sizing: border-box;
        }

        /* Cabecera con número de certificado */
        .header {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            padding-right: 2rem;
            margin-top: 1rem;
        }

        .numero {
            color: rgb(255, 255, 255);
            font-weight: bold;
            font-size: 26px;
            font-family: 'Arial', sans-serif;
            text-align: right;
            margin-right: 7rem;
        }

        /* Titulo */
        .titulo {
            width: 100%;
            display: block;
            margin-top: 3rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .title {
            font-weight: bold;
            font-size: 22px;
            display: inline-block;
            text-align: center;
            font-family: 'Arial', sans-serif;
            width: 100%;
        }

        /* Sección de certificación */
        .certifica {
            margin: 1rem 3rem;
            text-align: justify;
            font-size: 12px;
            line-height: 1.6;
        }

        .subtitulo {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }

        /* Tabla de datos */
        .descripcion,
        .datos-vehiculo {
            width: 100%;
            display: flex;
            justify-content: center;
            margin: 1.5rem 0 2.5rem 0;
        }

        .tabla {
            border-collapse: collapse;
            width: 80%;
            max-width: 650px;
            margin: 0 auto;
        }

        .descripcion .tabla,
        .datos-vehiculo .tabla {
            font-size: 11px;
        }

        .descripcion td,
        .datos-vehiculo td {
            padding: 6px 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        .descripcion td:first-child,
        .datos-vehiculo td:first-child {
            font-weight: 600;
            width: 40%;
            font-family: 'Arial', sans-serif;
            color: #444;
        }

        .descripcion td:last-child,
        .datos-vehiculo td:last-child {
            color: #333;
        }

        .descripcion span {
            font-weight: bold;
        }

        .texto,
        .observaciones {
            margin: 15px 0;
            line-height: 1.5;
        }

        /* Pie de página con sello y fecha */
        .footer {
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
            padding-right: 0;
        }

        .footer .sello {
            width: auto;
            text-align: right;
            margin-right: 6rem;
        }

        .sello img {
            width: 120px;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }

        .fecha {
            width: auto;
            text-align: right;
            font-size: 12px;
            padding-top: 1rem;
            margin-right: 6rem;
        }

        /* QR Code y Hash en la misma línea */
        .verification-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
            margin-top: 3rem;
            margin-bottom: 2rem;
            position: relative;
        }

        .qr {
            text-align: left;
            margin-left: 2rem;
            width: 140px;
            position: fixed;
            bottom: 60px;
            left: 74px;
            z-index: 10;
        }

        .qr img {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }

        /* Hash identificador */
        .hash {
            text-align: right;
            width: 100%;
            padding-right: 2rem;
            font-size: 10px;
            color: #666;
            position: fixed;
            bottom: 60px;
            right: 30px;
        }
    </style>
</head>

@if ($certificado->fondo)

    <body
        style="background-image: url('data:image/jpeg;base64, {{ base64_encode(Storage::get($fondo)) }}'); background-size: 100% 100%; background-repeat: no-repeat;">
    @else

        <body>
@endif

<div class="certificado">
    <div class="header">
        <div class="numero">
            {{ $certificado->ciudades->prefijo }}-{{ substr(date('Y'), -2) }}-{{ str_pad($certificado->id, 4, '0', STR_PAD_LEFT) }}
        </div>
    </div>

    <div class="contenido">
        <div class="titulo">
            <div class="title">
                <span>CERTIFICADO SISTEMA ANTIFATIGA, ANTICOLISIÓN Y GPS</span>
            </div>
        </div>

        <div class="certifica">
            <p>
                <strong>{{ $plantilla->razon_social }}</strong>, con RUC {{ $plantilla->ruc }}, certifica que nuestro
                cliente
                <strong>{{ $certificado->cliente ? $certificado->cliente['razon_social'] : $certificado->vehiculo->cliente->razon_social }}</strong>
                con DNI/RUC:
                {{ $certificado->cliente ? $certificado->cliente['numero_documento'] : ($certificado->vehiculo->cliente ? $certificado->vehiculo->cliente->numero_documento : 'N/A') }},
                ha adquirido un sistema antifatiga, anticolisión y GPS de la marca
                {{ $certificado->dispositivo->modelo->marca ?? 'No disponible' }},
                para la unidad que se detalla a continuación. Asimismo, se confirma que a la fecha, dicho equipo se
                encuentra transmitiendo
                en la Plataforma de gestión de flotas profesional en tiempo real.
            </p>
        </div>

        <div class="datos-vehiculo">
            <table class="tabla">
                <tr>
                    <td>Fecha de Instalación</td>
                    <td>: {{ \Carbon\Carbon::parse($certificado->fecha_instalacion)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Modelo</td>
                    <td>: HERO ME40 02 ADAS y DMS</td>
                </tr>
                <tr>
                    <td>IMEI</td>
                    <td>:
                        @if ($certificado->cambiar_imei)
                            {{ $certificado->imei_personalizado ?: 'No disponible' }}
                        @elseif ($certificado->dispositivo)
                            {{ $certificado->dispositivo->imei }}
                            ({{ optional($certificado->dispositivo->modelo)->modelo ?: 'Modelo no especificado' }})
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Certificado de Homologación</td>
                    <td>: {{ $certificado->dispositivo->modelo->certificado }}</td>
                </tr>
                <tr>
                    <td>Placa</td>
                    <td>: {{ $certificado->vehiculo->placa }}</td>
                </tr>
                <tr>
                    <td>Marca</td>
                    <td>: {{ $certificado->vehiculo->marca }}</td>
                </tr>
                <tr>
                    <td>Modelo</td>
                    <td>: {{ $certificado->vehiculo->modelo }}</td>
                </tr>
                <tr>
                    <td>Tipo</td>
                    <td>: {{ $certificado->vehiculo->tipo }}</td>
                </tr>
                <tr>
                    <td>Año</td>
                    <td>: {{ $certificado->vehiculo->year }}</td>
                </tr>
                <tr>
                    <td>Color</td>
                    <td>: {{ $certificado->vehiculo->color }}</td>
                </tr>
                <tr>
                    <td>Motor</td>
                    <td>: {{ $certificado->vehiculo->motor }}</td>
                </tr>
                <tr>
                    <td>Serie</td>
                    <td>: {{ $certificado->vehiculo->serie }}</td>
                </tr>
                <tr>
                    <td>Inicio Cobertura</td>
                    <td>: <strong>{{ \Carbon\Carbon::parse($certificado->inicio_cobertura)->format('d-m-Y') }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>Fin de cobertura</td>
                    <td>: <strong>{{ \Carbon\Carbon::parse($certificado->fin_cobertura)->format('d-m-Y') }}</strong>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <div class="sello">
                @if ($certificado->sello)
                    <img src="data:image/jpeg;base64, {{ base64_encode(Storage::get($sello)) }}"
                        alt="Sello de la empresa">
                @endif
            </div>
            <div class="fecha">
                <p>{{ $certificado->ciudades->nombre }},
                    {{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d') }} de
                    {{ \Carbon\Carbon::parse($certificado->fecha_emision)->locale('es')->isoFormat('MMMM') }} del
                    {{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('Y') }}</p>
            </div>
        </div>
    </div>
</div>

@php
    $qr = base64_encode(
        QrCode::format('png')
            ->size(140) // Tamaño adecuado para mejor calidad
            ->margin(0)
            ->errorCorrection('H') // Alta corrección de errores para mejor reconocimiento
            ->gradient(10, 88, 147, 5, 44, 82, 'vertical')
            ->style('square')
            ->eye('circle')
            ->encoding('UTF-8')
            ->generate(
                ' VEHICULO: ' .
                    $certificado->vehiculo->placa .
                    '|' .
                    " \n VALIDA: " .
                    \Carbon\Carbon::parse($certificado->inicio_cobertura)->format('d-m-Y') .
                    ' HASTA ' .
                    \Carbon\Carbon::parse($certificado->fin_cobertura)->format('d-m-Y') .
                    "\n IMEI: " .
                    ($certificado->cambiar_imei
                        ? $certificado->imei_personalizado
                        : ($certificado->dispositivo
                            ? $certificado->dispositivo->imei
                            : 'N/A')),
            ),
    );
@endphp

<div class="qr">
    <img src="data:image/jpeg;base64, {{ $qr }}">
</div>

<div class="verification-row">
    <div class="hash">
        Código de verificación: {{ $certificado->hash }}
    </div>
</div>

</body>

</html>
