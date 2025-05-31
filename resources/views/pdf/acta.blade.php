<!DOCTYPE html>
<html>

<head>
    @if ($acta->vehiculo && $acta->ciudades)
        <title>
            {{ 'ACTA ' . $acta->vehiculo->placa . ' ' . $acta->ciudades->prefijo . '-' . $acta->year . '-' . $acta->numero }}
        </title>
    @else
        <title>Faltan datos en esta acta, por favor corrigelas</title>
    @endif




    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {{ header('Content-type:application/pdf') }}
    <style type="text/css">
        /* -- Base -- */
        body {
            font-family: 'Arial', sans-serif;
            background-repeat: no-repeat;
            background-size: cover;
            /* Cambiado de 100% a cover para mejor escalado */
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
        .acta {
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
            /* Aumentado de 50px a 80px el margen superior */
            padding-top: 30px;
            /* Aumentado de 20px a 30px el padding superior */
            position: relative;
            box-sizing: border-box;
        }

        /* Cabecera con número de acta */
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

        /* Título y QR */
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
            /* Ajustado al nuevo tamaño */
            position: fixed;
            bottom: 60px;
            /* Posición fija desde abajo */
            left: 74px;
            /* Posición desde la izquierda */
            z-index: 10;
            /* Para asegurar que esté por encima del fondo */
        }

        .qr img {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }

        /* Sección de certificación */
        .certifica {
            margin: 1rem 3rem;
            text-align: justify;
            font-size: 12px;
            line-height: 1.6;
        }

        /* Tabla de datos */
        .descripcion {
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

        .descripcion .tabla {
            font-size: 11px;
        }

        .descripcion td {
            padding: 6px 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        .descripcion td:first-child {
            font-weight: 600;
            width: 40%;
            font-family: 'Arial', sans-serif;
            color: #444;
        }

        .descripcion td:last-child {
            color: #333;
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
            /* Mejora la calidad de la imagen */
            image-rendering: crisp-edges;
        }

        .fecha {
            width: auto;
            text-align: right;
            font-size: 12px;
            padding-top: 1rem;
            margin-right: 6rem;
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

@if ($acta->fondo)

    <body
        style="background-image: url('data:image/jpeg;base64, {{ base64_encode(Storage::get($fondo)) }}'); background-size: 100% 100%; background-repeat: no-repeat;">
    @else

        <body>
@endif


<div class="acta">
    <div class="header">
        <div class="numero">
            {{ $acta->codigo }}
        </div>
    </div>

    <div class="contenido">
        <div class="titulo">
            <div class="title">
                <span>ACTA DE INSTALACIÓN DE EQUIPO GPS</span>
            </div>
        </div>
        <div class="certifica">
            <p>
                <strong>{{ $plantilla->razon_social }}</strong>, con RUC {{ $plantilla->ruc }}, certifica que nuestro
                cliente
                <strong>{{ $acta->vehiculo->cliente ? strtoupper($acta->vehiculo->cliente->razon_social) : 'NO REGISTRADO' }}</strong>
                con DNI/RUC: {{ $acta->vehiculo->cliente ? $acta->vehiculo->cliente->numero_documento : 'PENDIENTE' }},
                ha adquirido un equipo GPS para la unidad que se detalla a continuación.
                Asimismo, se confirma que a la fecha, dicho equipo se encuentra transmitiendo a nuestra Plataforma de
                Monitoreo Satelital en tiempo real.
            </p>
        </div>
        <div class="descripcion">
            <table class="tabla">
                <tr>
                    <td>Fecha de Instalación</td>
                    <td>: {{ $acta->fecha_instalacion ? $acta->fecha_instalacion->format('d-m-Y') : 'Pendiente' }}</td>
                </tr>
                <tr>
                    <td>Modelo GPS</td>
                    <td>:
                        {{ $acta->vehiculo->dispositivoPrincipal ? $acta->vehiculo->dispositivoPrincipal->dispositivo->modelo->modelo : 'Pendiente' }}
                    </td>
                </tr>
                <tr>
                    <td>IMEI</td>
                    <td>:
                        {{ $acta->vehiculo->dispositivoPrincipal ? $acta->vehiculo->dispositivoPrincipal->imei : 'Pendiente' }}
                    </td>
                </tr>
                <tr>
                    <td>Certificado de Homologación</td>
                    <td>:
                        {{ $acta->vehiculo->dispositivoPrincipal ? $acta->vehiculo->dispositivoPrincipal->dispositivo->modelo->certificado : 'Pendiente' }}
                    </td>
                </tr>
                <tr>
                    <td>Placa</td>
                    <td>: {{ $acta->vehiculo->placa }}</td>
                </tr>
                <tr>
                    <td>Marca</td>
                    <td>: {{ $acta->vehiculo->marca }}</td>
                </tr>
                <tr>
                    <td>Modelo</td>
                    <td>: {{ $acta->vehiculo->modelo }}</td>
                </tr>
                <tr>
                    <td>Tipo</td>
                    <td>: {{ $acta->vehiculo->tipo }}</td>
                </tr>
                <tr>
                    <td>Año</td>
                    <td>: {{ $acta->vehiculo->year }}</td>
                </tr>
                <tr>
                    <td>Color</td>
                    <td>: {{ $acta->vehiculo->color }}</td>
                </tr>
                <tr>
                    <td>Motor</td>
                    <td>: {{ $acta->vehiculo->motor }}</td>
                </tr>
                <tr>
                    <td>Serie</td>
                    <td>: {{ $acta->vehiculo->serie }}</td>
                </tr>
                <tr>
                    <td>Plataforma</td>
                    <td>: <strong>{{ ucfirst($acta->plataforma) }}</strong></td>
                </tr>
                <tr>
                    <td>Inicio Cobertura</td>
                    <td>: <strong>{{ $acta->inicio_cobertura->format('d-m-Y') }}</strong></td>
                </tr>
                <tr>
                    <td>Fin de Cobertura</td>
                    <td>: <strong>{{ $acta->fin_cobertura->format('d-m-Y') }}</strong></td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <div class="sello">
                @if ($acta->sello)
                    <img src="data:image/jpeg;base64, {{ base64_encode(Storage::get($sello)) }}"
                        alt="Sello de la empresa">
                @endif
            </div>
            <div class="fecha">
                <p>{{ $acta->fecha }}</p>
            </div>
        </div> @php
            $qr = base64_encode(
                QrCode::format('png')
                    ->size(140) // Aumentado el tamaño para mejor calidad
                    ->margin(0)
                    ->errorCorrection('H') // Alta corrección de errores para mejor reconocimiento
                    ->gradient(10, 88, 147, 5, 44, 82, 'vertical')
                    ->style('square')
                    ->eye('circle')
                    ->encoding('UTF-8')
                    ->generate(
                        ' VEHICULO: ' .
                            $acta->vehiculo->placa .
                            '|' .
                            " \n VALIDA: " .
                            $acta->inicio_cobertura->format('d-m-Y') .
                            ' HASTA ' .
                            $acta->fin_cobertura->format('d-m-Y') .
                            "
            \nCONSULTAR VALIDEZ EN: " .
                            route('consulta.actas', $acta->codigo),
                    ),
            );
        @endphp

    </div> <!-- Cierre del div de contenido -->
</div>

<div class="qr">
    <img src="data:image/jpeg;base64, {{ $qr }}">
</div>
<div class="verification-row">
    <div class="hash">
        Código de verificación: {{ $acta->unique_hash }}
    </div>
</div>
</body>

</html>
