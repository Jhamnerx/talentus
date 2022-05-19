<!DOCTYPE html>
<html>

<head>
    <title>ACTA {{$acta->vehiculos->placa}} {{$acta->ciudades->prefijo."-".$acta->year."-".$acta->numero}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


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

        .acta {
            display: flex;
            flex-wrap: wrap;
            overflow: hidden;
            padding: 2rem;
            // margin: 0rem 4rem;

        }

        .header {
            color: rgb(238, 34, 34);
            font-style:  !important;
            font-weight: bold;
            font-size: 30px;
            margin-bottom: 1rem;
            font-family: "DejaVu Sans";

        }

        .header .numero {
            text-align: right;
            padding-top: 1rem;
        }

        .titulo {
            margin-bottom: 1rem;
            margin-top: 2rem;
            margin-left: 4rem;
        }

        .titulo span {

            font-weight: bold;
            font-size: 22px;
            text-align: center;
            margin-left: 8rem;

        }

        .certifica {
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            text-justify: auto;

            margin-left: 5rem;
            font-size: 16px;
            color: #000;
            line-height: 1.7;
        }

        .descripcion {
            margin-top: 2rem;
            margin-bottom: 1rem;
            text-justify: auto;

            margin-left: 5rem;
            font-size: 16px;
            color: #000;

        }

        .tabla {
            padding: 0rem 3rem;
            text-align: left;
        }

        .footer {
            font-size: 16px;
            color: #000;

        }

        .footer .sello {
            margin-top: 2rem;
            width: 50%;
            text-align: center;
        }

        .fecha {
            text-align: right;
            margin-top: -3rem;
            padding-right: 4rem;
        }

        .sello img {
            width: 150px;
        }
    </style>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/style.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body background="{{asset('images/'.$plantilla->img_documentos)}}">

    <div class="acta">

        <div class="header">
            <div class="numero">
                {{$acta->ciudades->prefijo."-".$acta->year."-".$acta->numero}}
            </div>
        </div>
        <div class="titulo">
            <!-- Column Content -->
            <span>ACTA DE INSTALACIÓN DE EQUIPO GPS</span>
        </div>

        <div class="certifica">
            <div>
                <span>
                    <b>{{$plantilla->razon_social}}</b>, con RUC {{$plantilla->ruc}}, Certifica que nuestro cliente:
                    <b>{{strtoupper($acta->vehiculos->flotas->clientes->razon_social)}}</b>
                    con DNI/RUC: {{$acta->vehiculos->flotas->clientes->numero_documento}}, ha adquirido un equipo GPS,
                    para la unidad que se detalla a continuación:
                    Así mismo a la fecha se encuentra transmitiendo a nuestra Plataforma de Monitoreo Satelital en
                    tiempo real.
                </span>
            </div>
        </div>

        <div class="descripcion">
            <table class="tabla">
                <tr>
                    <td height="25">Fecha de Instalación</td>
                    <td height="25">:{{$acta->created_at->format('d-m-Y')}}</td>
                </tr>


                <tr>
                    <td height="25">Modelo GPS</td>
                    <td height="25">:{{$acta->vehiculos->dispositivos->modelo->modelo}}</td>
                </tr>

                <tr>
                    <td height="25">Imei</td>
                    <td height="25">:{{$acta->vehiculos->dispositivos->imei}}</td>
                </tr>

                <tr>
                    <td height="25">Certificado de Homologación</td>
                    <td height="25">: {{$acta->vehiculos->dispositivos->modelo->certificado}} </td>
                </tr>

                <tr>
                    <td height="25">Placa</td>
                    <td height="25">:{{$acta->vehiculos->placa}}</td>
                </tr>
                <tr>
                    <td height="25">Marca</td>
                    <td height="25">:{{$acta->vehiculos->marca}}</td>
                </tr>
                <tr>
                    <td height="25">Modelo</td>
                    <td height="30">:{{$acta->vehiculos->modelo}}</td>

                </tr>
                <tr>
                    <td height="25">Tipo</td>
                    <td height="25">:{{$acta->vehiculos->tipo}}</td>

                </tr>
                <tr>
                    <td height="25">A&ntilde;o</td>
                    <td height="25">:{{$acta->vehiculos->year}}</td>
                </tr>
                <tr>
                    <td height="25">Color</td>
                    <td height="25">:{{$acta->vehiculos->color}}</td>
                </tr>
                <tr>
                    <td height="25">Motor</td>
                    <td height="25">:{{$acta->vehiculos->motor}}</td>
                </tr>
                <tr>
                    <td height="25">Serie</td>
                    <td height="25">:{{$acta->vehiculos->serie}}</td>
                </tr>
                <tr>
                    <td height="25">Inicio Cobertura</td>
                    <td height="30">:<b>{{$acta->inicio_cobertura}}</b></td>

                </tr>
                <tr>
                    <td height="30">Fin de cobertura</td>
                    <td height="30">:<b>{{date($acta->fin_cobertura)}}</b></td>
                </tr>
            </table>

        </div>

        <div class="footer">
            <div class="sello">

                <img src="{{asset('images/'.$plantilla->img_firma)}}" alt="">
            </div>
            <div class="fecha">
                <p>{{$acta->fecha}}</p>
            </div>
        </div>

    </div>



</body>

</html>