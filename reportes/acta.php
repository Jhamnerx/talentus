<?php 


require_once "../modelos/plantilla.modelo.php";
require_once "../modelos/actas.modelo.php";
require_once "../controladores/actas.controlador.php";
require_once "../controladores/dispositivos.controlador.php";
require_once "../controladores/vehiculos.controlador.php";
require_once "../controladores/ciudad.controlador.php";
require_once "../controladores/flotas.controlador.php";


require_once "../modelos/vehiculos.modelo.php";
require_once "../modelos/dispositivos.modelo.php";
require_once "../modelos/ciudad.modelo.php";
require_once "../modelos/flotas.modelo.php";
require_once "../modelos/persona.modelo.php";

if (isset($_SERVER["REQUEST_URI"])) {
        /**
         * OBTENER ID ACTA
         * DESDE URL
         */
        $dir= $_SERVER["REQUEST_URI"];
        $url = explode("/", $dir);
        $html = "<!DOCTYPE html>
                    <html>";

    if (count($url) > 4) {
        

        /**
         * CONSULTAR
         * ACTA
         */
        $item = "id";
        $valor = $url[4];

        $plantilla = ModeloPlantilla::mdlSeleccionarPlantilla("plantilla");

        $acta = ControladorActas::ctrMostrarActa($item, $valor);

       // var_dump($acta);

        $vehiculo = ControladorVehiculos::ctrMostrarVehiculos("id", $acta["idvehiculo"]);

        //var_dump($vehiculo);


        $dispositivo = ControladorDispositivos::ctrMostrarDispositivos("id", $vehiculo["dispositivo"]);

        $ciudad = ModeloCiudad::mdlMostrarCiudad("ciudad", "id", $acta["ciudad"]);


        $flota =ControladorFlotas::ctrMostrarFlotas("id", $vehiculo["flota"]);

        //var_dump($flota);

        $cliente = ModeloPersona::mdlMostrarPersona("persona", "id", $flota["idcliente"], 1);



        $html.='
        <head>
            <title>ACTA '.$vehiculo["placa"].'['.$acta["num_acta"].']</title>

            <link rel="stylesheet" type="text/css" href="../../reportes/acta.css">
            <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext" rel="stylesheet" type="text/css">
            <!-- <link rel="stylesheet" href="sass/main.css" media="screen" charset="utf-8"/> -->
            <meta content="width=device-width, initial-scale=1.0" name="viewport">
            <meta http-equiv="content-type" content="text-html; charset=utf-8">
            <script src="../../vistas/bower_components/jquery/dist/jquery.min.js"></script>
            <script src="../kendo.all.min.js"></script>
            <script>

              function exportPDF() {
                kendo.drawing.drawDOM(".acta", {
                  forcePageBreak: ".new-page",
                  paperSize: "A4",
                  margin: {top: "0cm", bottom: "0cm", left: "0cm"},
                  scale: 0.75,
                  height: 500
                }).then(function(group){
                  kendo.drawing.pdf.saveAs(group, "ACTA '.$vehiculo["placa"].'['.$acta["num_acta"].']");
                });
              }
              kendo.pdf.defineFont({
                "DejaVu Sans"             : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans.ttf",
                "DejaVu Sans|Bold"        : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
                "DejaVu Sans|Bold|Italic" : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
                "DejaVu Sans|Italic"      : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
                "WebComponentsIcons"      : "https://kendo.cdn.telerik.com/2017.1.223/styles/fonts/glyphs/WebComponentsIcons.ttf"
            });


            $( document ).ready(function() {

               exportPDF();
            });
            </script>
        </head>
        ';



    //Establecemos los datos de la empresa

        $empresa = json_decode($plantilla["empresa"], true);
        $nombre = $empresa[0]["nombre"];

        $ruc = $empresa[0]["ruc"];
        $direccion = $empresa[0]["direccion"];
        $telefono = $empresa[0]["telefono"];
        $email = $empresa[0]["correo"];
        $cuenta = $empresa[0]["cuenta"];

        if ($acta["fondo"] == 1) {

        $fondo = $plantilla["fondoActa"];

        }else{

        $fondo = "";

        }
    //SELLO
        if($acta["sello"] == 1) {

            $sello = '<div class="sello">
                    <img src="../../'.$plantilla["fondoFirma"].'" width="150px">
                </div>';

        }else{

            $sello = '<div class="sello"></>';
        }


    //CODIGO
        $year = $acta["year"];
        $codigo = "";

        if (strlen($acta["num_acta"])== 1) {

          $codigo = $ciudad["prefijo"]."-".$year."-00".$acta["num_acta"];

        }elseif(strlen($acta["num_acta"])== 2) {


          $codigo = $ciudad["prefijo"]."-".$year."-0".$acta["num_acta"];

        }elseif(strlen($acta["num_acta"])== 3) {


          $codigo = $ciudad["prefijo"]."-".$year."-".$acta["num_acta"];

        }else{

            $codigo = $ciudad["prefijo"]."-".$year."-".$acta["num_acta"];

        }


    //TIPO CLIENTE

        if ($cliente["tipo_documento"] == "RUC"){

         $tipo_cliente=" con RUC ";

        }else{

            $tipo_cliente=" con DNI ";
        }
        $nombre_cliente = $cliente["nombre"];

        if ($cliente["apellido"] == "null") {

            $nombre_cliente = $cliente["nombre"];

        }else{

            $nombre_cliente = $cliente["nombre"]. " ".$cliente["apellido"];
        }

      $html.='
      <body>
      <div class="acta" style="background-image: url(../../'.$fondo.')">
        <div class="row">

            <div class="col-sm-6 col-xs-12" id="acta" >
                <div class="numeracion" id="editor">
                   '.$codigo.'
                </div>

                <div class="titulo">

                    <b>ACTA DE INSTALACIÓN DE EQUIPO GPS</b>

                </div>

                <div class="certifica">

                    <p align="justify"><b>TALENTUS TECHNOLOGY EIRL</b>, con RUC 20496172168, Certifica que nuestro cliente:
                    <b>'.$nombre_cliente.'</b>'.$tipo_cliente.' '.$cliente["num_documento"].', ha adquirido  equipo GPS,
                    <p>para la unidad que se detalla a continuación:</p>
                    <p>Así mismo a la fecha se encuentra transmitiendo a nuestra Plataforma de Monitoreo satelital en tiempo real.</p>

                </div>

                <table class="descripcion">

                        <thead>

                            <tr>
                                <td height="30">Fecha de Instalación</td>
                                <td height="30">:'.$acta["inicio_cobertura"].'</td>
                            </tr>


                            <tr>
                                <td height="30">Modelo GPS</td>
                                <td height="30">:'.strtoupper($dispositivo["modelo"]).'</td>
                            </tr>

                            <tr>
                                <td height="30">Imei</td>
                                <td height="30">:'.$vehiculo["idgps"].'</td>
                            </tr>

                            <tr>
                                <td height="30">Certificado de Homologación</td>
                                <td height="30">: '.strtoupper($dispositivo["certificado"]).' </td>
                            </tr>

                            <tr>
                                <td height="30">Placa</td>
                                <td height="30">:'.strtoupper($vehiculo["placa"]).'</td>
                            </tr>
                            <tr>
                                <td height="30">Marca</td>
                                <td height="30">:'.strtoupper($vehiculo["marca"]).'</td>
                            </tr>
                            <tr>
                                <td height="30">Modelo</td>
                                <td height="40">:'.strtoupper($vehiculo["modelo"]).'</td>

                            </tr>
                            <tr>
                                <td height="30">Tipo</td>
                                <td height="30">:'.strtoupper($vehiculo["tipo"]).'</td>

                            </tr>
                            <tr>
                                <td height="30">A&ntilde;o</td>
                                <td height="30">:'.strtoupper($vehiculo["year"]).'</td>
                            </tr>
                            <tr>
                                <td height="30">Color</td>
                                <td height="30">:'.strtoupper($vehiculo["color"]).'</td>
                            </tr>
                            <tr>
                                <td height="30">Motor</td>
                                <td height="30">:'.strtoupper($vehiculo["motor"]).'</td>
                            </tr>
                            <tr>
                                <td height="30">Serie</td>
                                <td height="30">:'.strtoupper($vehiculo["serie"]).'</td>
                            </tr>
                            <tr>
                                <td height="30">Inicio Cobertura</td>
                                <td height="30">:<b>'.$acta["inicio_cobertura"].'</b></td>

                            </tr>
                            <tr>
                                <td height="30">Fin de cobertura</td>
                                <td height="30">:<b>'.$acta["fin_cobertura"].'</b></td>
                            </tr>
                        </thead>
                </table>
                <div class="fecha">
                <p>'.$acta["fecha"].'</p>


                </div>
                        
                        '.$sello.'


            </div>

        </div>
    </div>
        ';

      $html .='

            </body>

        </html>
        ';


        echo $html;

    }else{

        echo "<b>NO EXISTE</b>";
    }
    
}



 ?>

