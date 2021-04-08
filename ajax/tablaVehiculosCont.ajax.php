<?php

require_once "../controladores/vehiculos.controlador.php";
require_once "../controladores/flotas.controlador.php";
require_once "../controladores/dispositivos.controlador.php";
require_once "../modelos/vehiculos.modelo.php";
require_once "../modelos/flotas.modelo.php";
require_once "../modelos/dispositivos.modelo.php";

class TablaVehiculos{

  /*=============================================
  MOSTRAR LA TABLA DE VEHICULOS
  =============================================*/

 	public function mostrarTabla(){

	 	$item = null;
	 	$valor = null;

	 	$vehiculos = ControladorVehiculos::ctrMostrarVehiculos($item, $valor);


	 	if(count($vehiculos) == 0){

	      $datosJson = '{ "data":[]}';

	      echo $datosJson;

	      return;

	    }

	    $datosJson = '{

		  "data": [ ';

		for($i = 0; $i < count($vehiculos); $i++){

		 	$flota = ControladorFlotas::ctrMostrarFlotas("id", $vehiculos[$i]["flota"]);
		    /**
		     *	CREAR BOTON AGREGAR
		     *
		     */
		    $add = "agregarVehiculo(".$vehiculos[$i]["id"].")";

			$boton = "<button class='btn btn-warning' name='".$vehiculos[$i]["id"]."' value='".$vehiculos[$i]["placa"]."' idvehiculo='".$vehiculos[$i]["id"]."' onclick='".$add."'><span class='fa fa-plus'></span></button>";



		    //$dispositivo = ControladorDispositivos::ctrMostrarDispositivos("id", $vehiculos[$i]["dispositivo"]);
      if ($flota) {

        $nombreFlota=  $flota["nombre"];
        // code...
      }else {
        $nombreFlota = "<em>sin datos</em>";
      }

		    $datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$vehiculos[$i]["placa"].'",
				      "'.$vehiculos[$i]["marca"].'",
				      "'.$vehiculos[$i]["modelo"].'",
				      "'.$nombreFlota.'",
				      "'.$boton.'"
				    ],';



		}

		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']

		}';

		echo $datosJson;

 	}


}

/*=============================================
ACTIVAR TABLA DE SERVICIOS
=============================================*/

	$activar = new TablaVehiculos();
	$activar -> mostrarTabla();
 ?>
