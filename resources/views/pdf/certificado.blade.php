<!DOCTYPE html>
<html>

<head>

    <title>CERTIFICADO GPS {{ $certificado->vehiculo->placa }}
        {{ $certificado->codigo }}</title>


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {{ header('Content-type:application/pdf') }}
    <style type="text/css">
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

        .certifica {
            margin: 1rem 3rem;
            text-align: justify;
            font-size: 12px;
            line-height: 1.6;
        }

        .certifica .acredita {
            margin-top: 2rem;
        }

        .descripcion {
            width: 100%;
            display: flex;
            justify-content: center;
            margin: 1.5rem 0 2.5rem 0;
            font-size: 12px;
            color: #333;
        }

        .descripcion span {
            font-size: 14px;
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

        /* Estilo para los cuadrados destacados */
        .descripcion tr.destacado {
            margin-top: 15px;
        }

        .descripcion tr.destacado td {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            font-weight: bold;
            text-align: center;
            padding: 8px;
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
            image-rendering: crisp-edges;
        }

        .fecha {
            width: auto;
            text-align: right;
            font-size: 12px;
            padding-top: 1rem;
            margin-right: 6rem;
        }

        .data {
            width: 100%;
            display: flex;
            justify-content: center;
            margin: 1.5rem 0 2.5rem 0;
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
        .qr {
            text-align: left;
            margin-left: 2rem;
            width: 140px;
            position: fixed;
            bottom: 60px;
            left: 74px;
            z-index: 10;
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

        .verification-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
            margin-top: 3rem;
            margin-bottom: 2rem;
            position: relative;
        }

        .qr img {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
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
            {{ $certificado->codigo }}
        </div>
    </div>

    <div class="contenido">
        <div class="titulo">
            <div class="title">
                <span>CERTIFICADO DE INSTALACIÓN</span>
            </div>
        </div>

        @php
            $qr = base64_encode(
                QrCode::format('png')
                    ->size(140)
                    ->margin(0)
                    ->errorCorrection('H')
                    ->gradient(10, 88, 147, 5, 44, 82, 'vertical')
                    ->style('square')
                    ->eye('circle')
                    ->encoding('UTF-8')
                    ->generate(
                        ' VEHICULO: ' .
                            $certificado->vehiculo->placa .
                            '|' .
                            " \nVALIDO HASTA: " .
                            $certificado->fin_cobertura .
                            '|' .
                            "\nEXPEDIDO A: " .
                            $certificado->vehiculo->cliente->razon_social,
                    ),
            );
        @endphp
        <div class="certifica">
            <p>
                <strong>TALENTUS TECHNOLOGY EIRL</strong>, con RUC: 20496172168, registro N° 6260 autorizada y
                Homologada por el
                MTC como empresa Prestadora de servicios de Valor añadido.
                <strong>CERTIFICA</strong> que la empresa:
                <strong>{{ $certificado->vehiculo->cliente->razon_social }}</strong>
                cuenta con el sistema localizador vía
                GPS/GPRS/GSM, con el Modelo Standar de equipo GPS

                @php
                    // Obtenemos el dispositivo principal (is_principal = 1)
                    $dispositivoPrincipal = $certificado->vehiculo->dispositivos->where('is_principal', 1)->first();
                @endphp

                {{ $dispositivoPrincipal && $dispositivoPrincipal->dispositivo && $dispositivoPrincipal->dispositivo->modelo
                    ? $dispositivoPrincipal->dispositivo->modelo->modelo
                    : 'Registrar dispositivo' }}
            </p>

            </span>
            <span class="acredita">
                <b>
                    Acreditamos satisfactoriamente la evaluación técnica del sistema, del equipo y del

                    funcionamiento.
                </b>
            </span>
        </div>
    </div>
    <div class="descripcion">
        <table class="tabla">
            @php
                // Obtenemos el dispositivo principal (is_principal = 1) si no se definió antes
                if (!isset($dispositivoPrincipal)) {
                    $dispositivoPrincipal = $certificado->vehiculo->dispositivos->where('is_principal', 1)->first();
                }
            @endphp

            <!-- Características del Dispositivo en un cuadrado destacado -->
            <tr class="destacado">
                <td colspan="2"
                    style="text-align: center; background-color: #f5f5f5; border: 1px solid #ddd; padding: 8px;">
                    <strong>CARACTERÍSTICAS DEL DISPOSITIVO</strong>
                </td>
            </tr>

            @if ($dispositivoPrincipal && $dispositivoPrincipal->dispositivo && $dispositivoPrincipal->dispositivo->modelo)
                @if ($dispositivoPrincipal->dispositivo->modelo->caracteristicas)
                    @foreach ($dispositivoPrincipal->dispositivo->modelo->caracteristicas as $caracteristica)
                        <tr>
                            <td>{{ $loop->index == 0 ? 'Características' : '' }}</td>
                            <td>: {{ $caracteristica['text'] }}</td>
                        </tr>
                    @endforeach
                @endif
            @else
                <tr>
                    <td>Dispositivo</td>
                    <td>: <span style="color: red">Añadir Dispositivo</span></td>
                </tr>
            @endif

            <!-- Destacar Fecha de Instalación en un cuadrado -->
            <tr class="destacado">
                <td colspan="2"
                    style="text-align: center; background-color: #f5f5f5; border: 1px solid #ddd; padding: 8px; margin-top: 15px;">
                    <strong>FECHA DE INSTALACIÓN</strong>
                </td>
            </tr>
            <tr>
                <td>Fecha</td>
                <td>: <strong>{{ $certificado->fecha_instalacion->format('d-m-Y') }}</strong></td>
            </tr>

            <!-- Placa del vehículo -->
            <tr class="destacado">
                <td colspan="2"
                    style="text-align: center; background-color: #f5f5f5; border: 1px solid #ddd; padding: 8px; margin-top: 15px;">
                    <strong>VEHÍCULO</strong>
                </td>
            </tr>
            <tr>
                <td>Placa</td>
                <td>: <strong>{{ $certificado->vehiculo->placa }}</strong></td>
            </tr>

            @if (!$certificado->accesorios->isEmpty())
                <tr>
                    <td>Accesorios</td>
                    <td>:
                        @php
                            $accesoriosTexto = [];
                            foreach ($certificado->accesorios as $accesorio) {
                                if (
                                    is_array($accesorio) &&
                                    isset($accesorio['nombre']) &&
                                    $accesorio['nombre'] === 'BUZZER'
                                ) {
                                    $buzzerTexto = 'BUZZER';
                                    if (!empty($accesorio['detalle'])) {
                                        $buzzerTexto .= ' (' . $accesorio['detalle'] . ')';
                                    }
                                    $accesoriosTexto[] = $buzzerTexto;
                                } else {
                                    $accesoriosTexto[] = is_array($accesorio) ? $accesorio['nombre'] : $accesorio;
                                }
                            }
                        @endphp
                        {{ implode(', ', $accesoriosTexto) }}
                    </td>
                </tr>
            @endif
            <tr>
                <td>Fin de Cobertura</td>
                <td>: <strong>{{ $certificado->fin_cobertura->format('d-m-Y') }}</strong></td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div class="sello">
            @if ($certificado->sello)
                <img src="data:image/jpeg;base64, {{ base64_encode(Storage::get($sello)) }}" alt="">
            @endif
        </div>
        <div class="fecha">
            <p>{{ $certificado->fecha }}</p>
        </div>
    </div>

    @php
        $qr = base64_encode(
            QrCode::format('png')
                ->size(140)
                ->margin(0)
                ->errorCorrection('H')
                ->gradient(10, 88, 147, 5, 44, 82, 'vertical')
                ->style('square')
                ->eye('circle')
                ->encoding('UTF-8')
                ->generate(
                    ' VEHICULO: ' .
                        $certificado->vehiculo->placa .
                        '|' .
                        " \nVALIDO HASTA: " .
                        $certificado->fin_cobertura->format('d-m-Y') .
                        '|' .
                        "\nEXPEDIDO A: " .
                        $certificado->vehiculo->cliente->razon_social,
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
        Código de verificación: {{ $certificado->unique_hash }}
    </div>
</div>

</body>

</html>
