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

			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($vehiculos[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoVehiculo = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoVehiculo = 0;

			}

		 	$estado = "<button value='".$textoEstado."' class='btn ".$colorEstado." btn-xs btnActivar' estadoVehiculo='".$estadoVehiculo."' idVehiculo='".$vehiculos[$i]["id"]."'>".$textoEstado."</button>";
		 	
		 	/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/
	    
		    $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarVehiculo' idVehiculo='".$vehiculos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarVehiculo'><i class='fa fa-pencil'></i></button></div>";

		    $flota = ControladorFlotas::ctrMostrarFlotas("id", $vehiculos[$i]["flota"]);
		    $dispositivo = ControladorDispositivos::ctrMostrarDispositivos("id", $vehiculos[$i]["dispositivo"]);

		    $datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$acciones.'",
				      "'.$vehiculos[$i]["placa"].'",
				      "'.$vehiculos[$i]["marca"].'",
				      "'.$vehiculos[$i]["modelo"].'",
				      "'.$vehiculos[$i]["tipo"].'",
				      "'.$vehiculos[$i]["year"].'",
				      "'.$flota["nombre"].'",
				      "'.$vehiculos[$i]["sim"].'",
				      "'.$dispositivo["modelo"].'",
				      "'.$estado.'"
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