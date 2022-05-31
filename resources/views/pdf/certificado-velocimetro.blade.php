<!DOCTYPE html>
<html>

<head>

    <title>CERTIFICADO VELOCIMETRO {{$certificado->vehiculos->placa}}
        {{$certificado->ciudades->prefijo."-".$certificado->year."-".$certificado->numero}}</title>


    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    {{header("Content-type:application/pdf");}}


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
            margin-top: 2rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 17px;
            color: #000;
            line-height: 1.7;
            // position: relative;

        }

        .subtitulo {
            margin-top: 2rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 17px;
            color: #000;
            line-height: 1.7;
        }

        .descripcion {
            margin-top: 3.2rem;
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

        .descripcion table {}

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
            margin-top: 6rem;
            width: 50%;
            text-align: center;
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
            color: #052c52;
            font-style:  !important;
            font-weight: bold;
            font-size: 26px;
            font-family: "DejaVu Sans";
            margin-left: 32rem;
            margin-top: -1rem;

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
            top: 60px;
        }

        .hash {
            padding-left: 31rem;
            padding-top: 6rem;
            font-size: 12px;
        }
    </style>

</head>

@if ($certificado->fondo)

<body background="data:image/jpeg;base64, {{base64_encode(file_get_contents('images/'.$fondo))}}">
    @else

    <body>
        @endif


        <div class="certificado">

            <div class="header">



                <div class="numero">
                    {{$certificado->codigo}}
                </div>

            </div>
            <div class="titulo">
                <div class=" title">
                    <span>CERTIFICADO DE INSTALACIÓN DE
                        LIMITADOR DE VELOCIDAD</span>
                </div>
                <div class="qr">
                    <img src="data:image/jpeg;base64, {{ base64_encode(QrCode::format('png')->size(120)
->gradient(22,125,127,73,125,173,'vertical')
->style('square')->eye('circle')->encoding('UTF-8')
->generate(" VEHICULO: " .$certificado->vehiculos->placa." \n CERTIFICADO DE INSTALACION LIMITADOR DE VELOCIDAD
                        \nEXPEDIDO A: ".$certificado->vehiculos->flotas->clientes->razon_social)) }}">

                </div>

            </div>


            <div class="certifica">
                <div>
                    <span>
                        <b>{{$plantilla->razon_social}}</b>, Certifica que la EMPRESA
                        {{$certificado->vehiculos->flotas->clientes->razon_social}}, con DNI/RUC:
                        {{$certificado->vehiculos->flotas->clientes->numero_documento}}
                    </span>

                </div>

            </div>
            <div class="subtitulo">
                <span>
                    <b>
                        Ha adquirido un equipo LIMITADOR DE VELOCIDAD SATELITAL, modelo VEL4D-G, implementado con
                        alerta de Exceso de Velocidad Mayor A 90KM/H
                    </b>
                </span>
            </div>

            <div class="descripcion">
                <span>El mismo que se encuentra instalado en el vehículo con:</span>

                <table>
                    <tr>
                        <td>Placa: </td>
                        <td> <b>{{$certificado->vehiculos->placa}}</b></td>
                    </tr>

                </table>
                <table class="tabla">
                    <tr>
                        <td height="20">Color de Led</td>
                        <td height="20">:Rojo Intenso</td>
                    </tr>
                    <tr>
                        <td height="20">Velocidad</td>
                        <td height="20">:KM/H</td>
                    </tr>
                    <tr>
                        <td height="20">Potencia</td>
                        <td height="20">:3 Watts.</td>
                    </tr>
                    <tr>
                        <td height="20">Tipo de Visualizacion</td>
                        <td height="20">:Digital</td>
                    </tr>
                    <tr>
                        <td height="20">Rango del Factor de Velocidad</td>
                        <td height="20">:2000-4000 Pulson/Km, adicional reloj satelital</td>
                    </tr>
                    <tr>
                        <td height="20">Peso</td>
                        <td height="20">:370gr</td>
                    </tr>

                </table>

            </div>

            <div class="footer">
                <div class="sello">
                    @if ($certificado->sello)


                    <img src="data:image/jpeg;base64, {{base64_encode(file_get_contents('images/'.$sello))}}" alt="">
                    @endif

                </div>
                <div class="fecha">
                    <p>{{$certificado->fecha}}</p>
                </div>
            </div>

            <div class="hash">
                {{$certificado->unique_hash}}
            </div>

        </div>



    </body>

</html>