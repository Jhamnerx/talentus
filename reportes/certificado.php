<?php 
require_once "../modelos/plantilla.modelo.php";
require_once "../modelos/certificado.modelo.php";
require_once "../modelos/persona.modelo.php";
require_once "../modelos/dispositivos.modelo.php";
require_once "../modelos/ciudad.modelo.php";
require_once "../modelos/vehiculos.modelo.php";

require_once "../controladores/certificado.controlador.php";
require_once "../controladores/persona.controlador.php";
require_once "../controladores/dispositivos.controlador.php";
require_once "../controladores/ciudad.controlador.php";
require_once "../controladores/vehiculos.controlador.php";
if (isset($_SERVER["REQUEST_URI"])) {
	
    /**
     * OBTENER ID CERTIFICADO
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

        $certificado = ControladorCertificados::ctrMostrarCertificado($item, $valor);

        $cliente = ControladorPersona::ctrMostrarPersona("id", $certificado["idcliente"], 1);

	    $dispositivo = ControladorDispositivos::ctrMostrarDispositivos("id", $certificado["modelo_gps"]);

	    $ciudad = ControladorCiudad::ctrMostrarCiudad("id",  $certificado["ciudad"]);

	    $vehiculo = ControladorVehiculos::ctrMostrarVehiculos("id", $certificado["idvehiculo"]);

        //var_dump($ciudad);

        $html.='
        	<head>
				<title>CERTIFICADO '.$cliente["nombre"].'</title>
				<meta http-equiv="content-type" content="text/html; charset=utf-8" />
				<meta charset="utf-8">
            	<script src="../../vistas/bower_components/jquery/dist/jquery.min.js"></script>
				<link rel="stylesheet" type="text/css" href="../../reportes/certificado.css">
				<meta name="theme-color" content="#052c52" />
            	<script src="../kendo.all.min.js"></script>
				<link rel="icon" href="../../ vistas/img/plantilla/icono.png">

				<script language = "Javascript">

				function ExportPdf(){ 
				kendo.drawing
				.drawDOM("#certificado", 
				{ 
					paperSize: "A4",
					margin: { top: "0cm", bottom: "0cm", left: "0cm" },
					scale: 0.75,
					height: 500
				})
					.then(function(group){
					kendo.drawing.pdf.saveAs(group, "certificado '.$cliente["nombre"].'.pdf")
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

               ExportPdf();
            });
				</script>
				</head>';

        if ($certificado["fondo"] == 1) {

        $fondo = $plantilla["fondoCertificado"];

        }else{

        $fondo = "";
        
        }

    //SELLO
        if($certificado["sello"] == 1) {

            $sello = '<div class="sello">
                    <img src="../../'.$plantilla["fondoFirma"].'" width="150px">
                </div>';

        }else{

            $sello = '<div class="sello"></>';
        }

    	//CODIGO
        $year = $certificado["year"];
        $codigo = "";

        if (strlen($certificado["num_certificado"])== 1) {

          $codigo = $ciudad["prefijo"]."-".$year."-00".$certificado["num_certificado"];

        }elseif(strlen($certificado["num_certificado"])== 2) {


          $codigo = $ciudad["prefijo"]."-".$year."-0".$certificado["num_certificado"];

        }elseif(strlen($certificado["num_certificado"])== 3) {


          $codigo = $ciudad["prefijo"]."-".$year."-".$certificado["num_certificado"];

        }else{

            $codigo = $ciudad["prefijo"]."-".$year."-".$certificado["num_certificado"];

        }



		$html.='

		<body>



				<div class="col-lg-8 col-xs-12 certificado" id="certificado" style="background-image: url(../../'.$fondo.')">
					<div class="numeracion" id="editor"> 
						'.$codigo.'
					</div>

					<div class="titulo">
						<center>
							<b> CERTIFICA</b>
						</center>
						 

					</div> 

					<div class="modelo">
							
						<p><b>Que, el sistema localizador vía GPS/GPRS/GSM – TRACKER</b></p>
						<p><b>Fabricado por ITRAC Modelo '.$dispositivo["modelo"].'</b></p>

					</div>




					<div class="acredita">
						
						<p><b>Acreditamos satisfactoriamente la evaluación técnica del sistema, del equipo y del</b></p>
						<p><b>funcionamiento.</b></p>

					</div>


					<div class="caracteristicas">
						<p>Con las siguientes características:</p>


					</div>


					<div class="caracteristicas_info">

						<table>
							<tr>
								<td height="40">- &nbsp;Localización    : Mediante tecnología satelital GPS</td>
							</tr>
							 <tr>
								<td height="40" style="width:170px">&nbsp;<p>- Transmisión de datos: Utilizando tecnología celular (SIM CARD) para determinar posición minuto al minuto del vehículo en tiempo real.</p></td>
							</tr>
							<tr>
								<td height="40">- &nbsp;Accesorios del equipo: botón de pánico y bloqueo del motor.</td>
							</tr>
							

						</table>    


					</div>

					<div class="info_cliente">

						<p>Se expide el siguiente certificado a: <b>'.$cliente["nombre"].' '.$cliente["apellido"].'</b></p>
						<br >
						<p><b>Placa de la Unidad: '.$vehiculo["placa"].'</b></p>


						


					</div>



					<div class="fin_cobertura">

						<p>El presente certificado es válido hasta el '.$certificado["fin_cobertura"].', a partir de la fecha de </p>
						<p>expedición.</p>
						


					</div>





						<div class="fecha">
						<p>'.$certificado["fecha"].'</p>


						</div>
						'.$sello.'
						
				</div>   
			</div>

			</body>';








    	$html .='

	            </body>

	        </html>
	        ';


		echo $html;





	}
}



 ?>