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




        .certifica {
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 16px;
            color: #000;
            line-height: 1.7;
            position: relative;
            top: -80px;
        }

        .descripcion {
            margin-top: -4rem;
            margin-bottom: 1rem;
            text-justify: auto;
            margin-left: 5rem;
            font-size: 14.5px;
            color: #000;
            text-align: center;
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
            margi-top: -2rem;

        }



        .titulo {


            display: grid;
            grid-template-columns: 30% 70% 1fr;
            grid-template-rows: 1fr;
            gap: 0px 7em;
            height: 150px;

        }


        .qr {
            padding-left: 4.5rem;
            position: relative;
            top: -30px;
        }



        .title {

            font-weight: bold;
            font-size: 22px;
            text-align: center;
            padding-left: 6.5rem;


        }

        .title span {
            position: relative;
            top: -110px;
        }

        .hash {
            padding-left: 28rem;
            padding-top: 8rem;
        }
    </style>

</head>

<body background="{{asset('images/'.$plantilla->img_documentos)}}">

    <div class="acta">

        <div class="header">



            <div class="numero">
                {{$acta->ciudades->prefijo."-".$acta->year."-".$acta->numero}}
            </div>

        </div>
        <div class="titulo">
            <div class="qr">
                <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(120)
                ->gradient(22,125,127,73,125,173,'vertical')
                ->merge(asset('images/'.$plantilla->img_icono),
                                                        .3, true)
                                                        ->style('square')->eye('circle')->encoding('UTF-8')
                                                        ->generate(" VEHICULO: ".$acta->vehiculos->placa." \n ACTA
                    VALIDA HASTA: ".$acta->fin_cobertura." CONSULTAR VALIDEZ EN:" )) }}">

            </div>

            <div class=" title">
                <span>ACTA DE INSTALACIÓN DE EQUIPO GPS</span>
            </div>
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
                    <td height="20">Fecha de Instalación</td>
                    <td height="20">:{{$acta->created_at->format('d-m-Y')}}</td>
                </tr>


                <tr>
                    <td height="20">Modelo GPS</td>
                    <td height="20">:{{$acta->vehiculos->dispositivos->modelo->modelo}}</td>
                </tr>

                <tr>
                    <td height="20">Imei</td>
                    <td height="20">:{{$acta->vehiculos->dispositivos->imei}}</td>
                </tr>

                <tr>
                    <td height="20">Certificado de Homologación</td>
                    <td height="20">: {{$acta->vehiculos->dispositivos->modelo->certificado}} </td>
                </tr>

                <tr>
                    <td height="20">Placa</td>
                    <td height="20">:{{$acta->vehiculos->placa}}</td>
                </tr>
                <tr>
                    <td height="20">Marca</td>
                    <td height="20">:{{$acta->vehiculos->marca}}</td>
                </tr>
                <tr>
                    <td height="20">Modelo</td>
                    <td height="30">:{{$acta->vehiculos->modelo}}</td>

                </tr>
                <tr>
                    <td height="20">Tipo</td>
                    <td height="20">:{{$acta->vehiculos->tipo}}</td>

                </tr>
                <tr>
                    <td height="20">A&ntilde;o</td>
                    <td height="20">:{{$acta->vehiculos->year}}</td>
                </tr>
                <tr>
                    <td height="20">Color</td>
                    <td height="20">:{{$acta->vehiculos->color}}</td>
                </tr>
                <tr>
                    <td height="20">Motor</td>
                    <td height="20">:{{$acta->vehiculos->motor}}</td>
                </tr>
                <tr>
                    <td height="20">Serie</td>
                    <td height="20">:{{$acta->vehiculos->serie}}</td>
                </tr>
                <tr>
                    <td height="20">Inicio Cobertura</td>
                    <td height="20">:<b>{{$acta->inicio_cobertura}}</b></td>

                </tr>
                <tr>
                    <td height="20">Fin de cobertura</td>
                    <td height="20">:<b>{{date($acta->fin_cobertura)}}</b></td>
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

        <div class="hash">
            {{$acta->unique_hash}}
        </div>

    </div>



</body>

</html>