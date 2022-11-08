<!DOCTYPE html>
<html>

<head>

    <title>CERTIFICADO GPS {{ $certificado->vehiculo->placa }}
        {{ $certificado->ciudades->prefijo . '-' . $certificado->year . '-' . $certificado->numero }}</title>


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
            margin-top: -1rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 17px;
            color: #000;
            line-height: 1.7;
            // position: relative;

        }

        .certifica .acredita {
            margin-top: 2rem;
        }

        .descripcion {
            margin-top: 5rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 16px;
            color: #000;
            line-height: 1.7;
            text-align: left;
        }

        .descripcion span {
            font-size: 18px;
        }

        .tabla {
            padding: 0rem 7.2rem;
            text-align: left;
        }

        .footer {
            font-size: 16px;
            color: #000;
            width: 100%;

        }

        .footer .sello {
            margin-top: 3rem;
            width: 50%;
            text-align: center;
        }

        .data {
            margin-top: 8rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 16px;
            color: #000;
            line-height: 2.2;
            text-align: left;
        }

        .fecha {
            text-align: right;
            margin-top: -2rem;
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
            font-style:  !important;
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
            font-size: 22px;
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
            padding-top: 6rem;
            font-size: 12px;
        }
    </style>

</head>

@if ($certificado->fondo)

    <body background="data:image/jpeg;base64, {{ base64_encode(file_get_contents(asset('storage/' . $fondo))) }}">
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
        <div class=" title">
            <span>CERTIFICA</span>
        </div>
        <div class="qr">
            {{-- <img
                src="data:image/jpeg;base64, {{ base64_encode(
                    QrCode::format('png')->size(120)->gradient(10, 88, 147, 5, 44, 82, 'vertical')->style('square')->eye('circle')->encoding('UTF-8')->generate(
                            ' VEHICULO: ' .
                                $certificado->vehiculo->placa .
                                " \n CERTIFICADO VALIDO HASTA: " .
                                $certificado->fin_cobertura .
                                "
                                                                                                                        \nEXPEDIDO A: " .
                                $certificado->vehiculo->cliente->razon_social,
                        ),
                ) }}"> --}}

        </div>

    </div>


    <div class="certifica">
        <div>
            <span>
                <b>Que, el sistema localizador vía GPS/GPRS/GSM – TRACKER Modelo
                    {{ $certificado->vehiculo->dispositivos->modelo->modelo }}</b>
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
            <li>
                Localización : Mediante tecnología satelital GPS
            </li>
            <li>
                Transmisión de datos: Utilizando tecnología celular (SIM CARD) para determinar posición minuto
                al minuto del vehículo en tiempo real.
            </li>

            <li>
                Accesorios del equipo: botón de pánico y bloqueo del motor.
            </li>
        </ul>

    </div>

    <div class="data">

        <div class="valido">

        </div>
        El presente certificado es válido hasta el {{ $certificado->fin_cobertura->format('d-m-Y') }}, a partir de la
        fecha de
        expedición.
        <div class="cliente">
            Se expide el siguiente certificado a: {{ $certificado->vehiculo->cliente->razon_social }}
        </div>
        <div class="vehiculo">
            <b>Placa de la Unidad: {{ $certificado->vehiculo->placa }}</b>
        </div>

    </div>

    <div class="footer">
        <div class="sello">
            @if ($certificado->sello)
                <img src="data:image/jpeg;base64, {{ base64_encode(file_get_contents(asset('storage/' . $sello))) }}"
                    alt="">
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
