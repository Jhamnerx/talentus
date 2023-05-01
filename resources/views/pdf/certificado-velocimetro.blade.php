<!DOCTYPE html>
<html>

<head>

    <title>CERTIFICADO VELOCIMETRO {{ $certificado->vehiculo->placa }}
        {{ $certificado->ciudades->prefijo . '-' . $certificado->year . '-' . $certificado->numero }}</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {{ header('Content-type:application/pdf') }}


    <style type="text/css">
        /* -- Base -- */
        body {

            font-family: "Arial, Helvetica, sans-serif";
            background-repeat: no-repeat;
            font-size: 10px;
            background-size: 100%;
            text-align: justify;
            text-justify: inter-word;
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
            margin-top: 0.3rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 14px;
            color: #000;
            line-height: 1.7;
            // position: relative;

        }

        .subtitulo {
            margin-top: 1rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 14px;
            color: #000;
            line-height: 1.7;
        }

        .descripcion {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 14px;
            color: #000;
            line-height: 1.7;
            text-align: left;
        }

        .texto {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 14px;
            color: #000;
            line-height: 1.7;
            text-align: left;
            text-align: justify;
            text-justify: inter-word;
        }

        .observaciones {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 14px;
            color: #000;
            line-height: 1.7;
            text-align: left;
            text-align: justify;
            text-justify: inter-word;
        }

        .datos-velocimetro {
            margin-top: 0.5rem;
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

        .descripcion table {}

        .tabla {
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            align-content: center;
        }

        .table {
            padding: 0rem 7.2rem;
            text-align: left;
            padding-top: 1rem;
        }

        .footer {
            color: #000;
            width: 100%;
            margin-top: 0.1rem;
            text-justify: auto;
            margin-left: 2rem;
            font-size: 14px;
            line-height: 1.7;
            text-align: right;
        }

        .footer .sello {

            text-align: right;
            padding-right: 4rem;
        }


        .fecha {
            text-align: right;
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
            color: #052c52;
            font-style:  !important;
            font-weight: bold;
            font-size: 24px;
            font-family: "DejaVu Sans";
            margin-left: 31rem;
            margin-top: -1rem;

        }


        .titulo {

            display: grid;
            grid-template-columns: 30% 70% 1fr;
            grid-template-rows: 1fr;
            gap: 0px 1em;
            height: 100px;

        }

        .qr {
            padding-left: 37rem;
            position: relative;
            top: -42px;
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
            top: 5px;
        }

        .hash {
            margin-bottom: 1rem;
            text-justify: auto;
            margin-right: 0.5rem;
            font-size: 12px;
            color: #000;
            line-height: 1.7;
            text-align: right;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            padding: 0.01rem 0.4rem;
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
    @php
        $cliente = $certificado->vehiculo->cliente ? $certificado->vehiculo->cliente->razon_social : '';
        $placa = $certificado->vehiculo ? $certificado->vehiculo->placa : '';
        $marca = $certificado->vehiculo ? $certificado->vehiculo->marca : '';
        $modelo = $certificado->vehiculo ? $certificado->vehiculo->modelo : '';
        $year = $certificado->vehiculo ? $certificado->vehiculo->year : '';
        $serie = $certificado->vehiculo ? $certificado->vehiculo->serie : '';
        $motor = $certificado->vehiculo ? $certificado->vehiculo->motor : '';
        $datos = $cliente . '|' . $placa . '|' . $marca . '|' . $modelo . '|' . $year . '|' . $serie . '|' . $motor;

    @endphp
    <div class="titulo">
        <div class="title">
            <span>
                CERTIFICADO DE LIMITADOR DE VELOCIDAD
            </span>
        </div>
        <div class="qr">
            <img
                src="data:image/jpeg;base64, {{ base64_encode(
                    QrCode::format('png')->size(110)->gradient(10, 88, 147, 5, 44, 82, 'vertical')->style('square')->eye('circle')->encoding('UTF-8')->generate($datos),
                ) }}">

        </div>

    </div>


    <div class="certifica">
        <div>
            <span>
                De acuerdo a lo establecido por la Octava Disposición Complementaria
                Transitoria del Reglamento Nacional de Administración de Transportes aprobado por Decreto
                Supremo N° 017-2009-MTC, <b>TALENTUS TECHNOLOGY EIRL</b>
            </span>

        </div>

    </div>
    <div class="subtitulo">
        <span>
            <b>
                CERTIFICA:

            </b>
        </span>
    </div>

    <div class="descripcion">
        <span>Que el vehículo materia de inspección y que consigna las siguientes características:</span>

        <table class="tabla" border="1">
            <tr>
                <td height="5" width="20">1</td>
                <td height="5">TITULAR:</td>
                <td height="5">
                    {{ $certificado->vehiculo->cliente ? $certificado->vehiculo->cliente->razon_social : 'SIN - DATOS' }}
                </td>
            </tr>
            <tr>
                <td height="5">2</td>
                <td height="5">PLACA:</td>
                <td height="5">{{ $certificado->vehiculo ? $certificado->vehiculo->placa : 'SIN DATOS' }}</td>
            </tr>
            <tr>
                <td height="5">3</td>
                <td height="5">CATEGORIA:</td>
                <td height="5">{{ $certificado->vehiculo ? $certificado->vehiculo->categoria : 'SIN DATOS' }}</td>
            </tr>
            <tr>
                <td height="5">4</td>
                <td height="5">MARCA:</td>
                <td height="5">{{ $certificado->vehiculo ? $certificado->vehiculo->marca : 'SIN DATOS' }}</td>
            </tr>
            <tr>
                <td height="5">5</td>
                <td height="5">MODELO:</td>
                <td height="5">{{ $certificado->vehiculo ? $certificado->vehiculo->modelo : 'SIN DATOS' }}</td>
            </tr>
            <tr>
                <td height="5">6</td>
                <td height="5">AÑO DE FABRICACIÓN:</td>
                <td height="5">{{ $certificado->vehiculo ? $certificado->vehiculo->year : 'SIN DATOS' }}</td>
            </tr>
            <tr>
                <td height="5">7</td>
                <td height="5">VIN/N° DE SERIE:</td>
                <td height="5">{{ $certificado->vehiculo ? $certificado->vehiculo->serie : 'SIN DATOS' }}</td>
            </tr>
            <tr>
                <td height="5">8</td>
                <td height="5">N° DE MOTOR:</td>
                <td height="5">{{ $certificado->vehiculo ? $certificado->vehiculo->motor : 'SIN DATOS' }}</td>
            </tr>

        </table>

    </div>

    <div class="texto">
        <span>Cuenta con una alarma sonora en la cabina del conductor y en el salón del vehículo que se activa cuando
            excede la velocidad máxima permitida por las normas de tránsito.
            Asimismo, mediante el presente documento certifica que el vehículo destinado al servicio de transporte
            terrestre de ámbito nacional o regional cuenta con sistema electrónico de inyección, ha sido calibrado para
            que el vehículo no desarrolle velocidades mayores a noventa (90) kilómetros por hora.
            El/los mismo(s) que se ha(n) colocado bajo los mecanismos de seguridad para que terceras personas no puedan
            acceder a la modificación de sus parámetros de ajuste.
        </span>


    </div>

    <div class="observaciones">
        <span>
            <b> OBSERVACIONES:

                {{ $certificado->observaciones
                    ? $certificado->observaciones
                    : 'La unidad cuenta con un dispositivo registrador de eventos y ocurrencias lo cual permite la
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        lectura en cualquier lugar, así mismo emite reportes impresos, de igual forma cuenta con medidas de
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        seguridad que impide su desconexión de acuerdo a la RD N° 843 -2010-MTC/15.' }}
            </b>
        </span>
    </div>
    <div class="datos-velocimetro">

        <table class="tabla" border="1">
            <tr>
                <td height="5"><b>MARCA:</b></td>
                <td height="5">
                    MICRODEV
                </td>
            </tr>
            <tr>
                <td height="5"> <b>MODELO:</b></td>
                <td height="5">{{ $certificado->velocimetro_modelo }}</td>
            </tr>


        </table>

    </div>
    <div class="footer">

        <div class="fecha">
            <p>Se expide el presente certificado en la ciudad de {{ $certificado->fecha }}</p>
        </div>

        <div class="sello">
            @if ($certificado->sello)
                <img src="data:image/jpeg;base64, {{ base64_encode(file_get_contents(asset('storage/' . $sello))) }}"
                    alt="">
            @endif

        </div>

    </div>

    <div class="hash">
        <span>{{ $certificado->unique_hash }}</span>

    </div>

</div>



</body>

</html>
