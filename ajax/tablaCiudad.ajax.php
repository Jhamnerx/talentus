<?php

require_once "../controladores/ciudad.controlador.php";
require_once "../modelos/ciudad.modelo.php";

class TablaCiudads{

  /*=============================================
  MOSTRAR LA TABLA DE CIUDAD
  =============================================*/ 

 	public function mostrarTabla(){	

 	$item = null;
 	$valor = null;

 	$ciudad = ControladorCiudad::ctrMostrarCiudad($item, $valor);	
 	
 	if(count($ciudad) == 0){

      $datosJson = '{ "data":[]}';

      echo $datosJson;

      return;

    }

 	$datosJson = '{
		 
		  "data": [ ';

	for($i = 0; $i < count($ciudad); $i++){
	
			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($ciudad[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoCiudad = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoCiudad = 0;

			}

		 	$estado = "<button value=".$textoEstado." class='btn ".$colorEstado." btn-xs btnActivar' estadoCiudad='".$estadoCiudad."' idCiudad='".$ciudad[$i]["id"]."'>".$textoEstado."</button>";


			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/

  				$acciones = "<div class='btn-group'><button  class='btn btn-warning btnEditarCiudad' idCiudad='".$ciudad[$i]["id"]."' data-toggle='modal' data-target='#modalEditarCiudad'><i class='fa fa-pencil'></i></button></div>";

	    
			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$ciudad[$i]["nombre"].'",
				      "'.$ciudad[$i]["prefijo"].'",
				      "'. $estado.'",
				      "'.$acciones.'"
				    ],';

	}

	$datosJson = substr($datosJson, 0, -1);

	$datosJson.=  ']
		  
	}'; 

	echo $datosJson;


 	}


}

/*=============================================
ACTIVAR TABLA DE CIUDAD
=============================================*/ 
$activar = new TablaCiudads();
$activar -> mostrarTabla();