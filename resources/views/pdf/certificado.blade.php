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

            font-family: "Arial, Helvetica, sans-serif";
            background-repeat: no-repeat;
            background-size: 100%;

        }

        html {
            margin: 0px;
            padding: 0px;

        }

        .certificado {
            display: flex;
            flex-wrap: wrap;
            overflow: hidden;
            padding: 2rem;
            // margin: 0rem 4rem;

        }




        .certifica {
            margin-top: -2.2rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 14px;
            color: #000;
            line-height: 1.7;
            // position: relative;

        }

        .certifica .acredita {
            margin-top: 2rem;
        }

        .descripcion {
            margin-top: 1.1rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 14px;
            color: #000;
            line-height: 1.7;
            text-align: left;
        }

        .descripcion span {
            font-size: 14px;
        }

        .tabla {
            padding: 0rem 7.2rem;
            text-align: left;
        }

        .footer {
            font-size: 14px;
            color: #000;
            width: 100%;

        }

        .footer .sello {
            margin-top: 2rem;
            width: 50%;
            text-align: center;
        }

        .data {
            margin-top: 3rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 14px;
            color: #000;
            line-height: 2.2;
            text-align: left;
        }

        .fecha {
            text-align: right;
            margin-top: -2.4rem;
            padding-right: 4rem;
        }

        .sello img {
            width: 150px;
        }



        .header {
            display: flex;
            flex-wrap: wrap;
            overflow: hidden;
            margin-left: 5rem;
            margin-top: 2rem;

        }

        .numero {
            width: 100%;
            overflow: hidden;
            color: rgb(238, 34, 34);
            font-style: !important;
            font-weight: bold;
            font-size: 26px;
            font-family: "DejaVu Sans";
            margin-left: 31rem;
            margin-top: -1.4rem;

        }

        .titulo {
            display: grid;
            grid-template-columns: 30% 70% 1fr;
            grid-template-rows: 1fr;
            gap: 0px 7em;
            height: 160px;

        }


        .qr {
            padding-left: 37rem;
            position: relative;
            top: -22px;
        }


        .title {

            font-weight: bold;
            font-size: 20px;
            text-align: center;
            justify-content: center;
            width: 50%;
            padding-left: 12.5rem;
            position: relative;
        }

        .title span {
            position: relative;
            top: 50px;
        }

        .hash {
            padding-left: 31rem;
            padding-top: 3rem;
            font-size: 12px;
        }
    </style>

</head>

@if ($certificado->fondo)

    <body background="data:image/jpeg;base64, {{ base64_encode(Storage::get($fondo)) }}">
    @else

        <body>
@endif


<div class="certificado">

    <div class="header">

        <div class="numero">
            {{ $certificado->codigo }}
        </div>

    </div>
    <div class="titulo">
        <div class="title">
            <span>CERTIFICADO DE INSTALACION</span>
        </div>

        @php
            $qr = base64_encode(
                QrCode::format('png')
                    ->size(120)
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

        <div class="qr">
            <img src="data:image/jpeg;base64, {{ $qr }}">

        </div>

    </div>


    <div class="certifica">
        <div>
            <span>TALENTUS TECHNOLOGY EIRL con RUC: 20496172168, registro N° 6260 autorizada y Homologa por el
                MTC como
                empresa Prestadora de servicios de Valor añadido.</span>
            <span>
                <p>
                    <b>CERTIFICA</b> que la empresa: <b>{{ $certificado->vehiculo->cliente->razon_social }}</b>
                    cuenta
                    con el
                    sistema localizador vía
                    GPS/GPRS/GSM, con el Modelo Standar de equipo GPS

                    {{ $certificado->vehiculo->dispositivos
                        ? $certificado->vehiculo->dispositivos->modelo->modelo
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
        <span>Con las siguientes características:</span>
        <ul>
            @if ($certificado->vehiculo->dispositivos)
                @if ($certificado->vehiculo->dispositivos->modelo->caracteristicas)
                    @foreach ($certificado->vehiculo->dispositivos->modelo->caracteristicas as $caracteristica)
                        <li>
                            {{ $caracteristica['text'] }}
                        </li>
                    @endforeach
                @else
                    <li>No existen caracteristicas</li>
                @endif
            @else
                <li style="color: red">Añadir Dispositivo</li>
            @endif

            @if (!$certificado->accesorios->isEmpty())
                <li>Accesorios Instalados: {{ implode(',', $certificado->accesorios->toArray()) }}</li>
            @endif

            <li style="padding-top: 10px;  font-size: 16px">
                <b>Placa de la unidad: {{ $certificado->vehiculo->placa }}</b>
            </li>
        </ul>

    </div>

    <div class="data">

        <div class="vehiculo">
            <table style="border: 1px solid">
                <tr style="border: 1px solid">
                    <td style="border: 1px solid">
                        <span style="padding-left: 2px; padding-right: 4px">
                            Fecha de Instalación
                        </span>
                    </td>
                    <td style="border: 1px solid">
                        <span style="padding-left: 2px; padding-right: 4px">
                            {{ $certificado->fecha_instalacion->format('d-m-Y') }}
                        </span>
                    </td>
                </tr>
                {{-- <tr style="border: 1px solid">
                    <td style="border: 1px solid">
                        <span style="padding-left: 2px; padding-right: 4px">
                            Fecha de Vencimiento
                        </span>
                    </td>
                    <td style="border: 1px solid">
                        <span style="padding-left: 2px; padding-right: 4px">
                            {{ $certificado->fin_cobertura->format('d-m-Y') }}
                        </span>

                    </td>
                </tr> --}}
            </table>
        </div>

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

    <div class="hash">
        {{ $certificado->unique_hash }}
    </div>

</div>



</body>

</html>
