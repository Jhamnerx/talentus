<?php

require_once "../controladores/lineas.controlador.php";
require_once "../modelos/lineas.modelo.php";

class TablaLineas{

  /*=============================================
  MOSTRAR LA TABLA DE LINEAS
  =============================================*/ 

 	public function mostrarTabla(){	

 	$item = null;
 	$valor = null;

 	$lineas = ControladorLineas::ctrMostrarLineas($item, $valor);	
 	
 	if(count($lineas) == 0){

      $datosJson = '{ "data":[]}';

      echo $datosJson;

      return;

    }

 	$datosJson = '{
		 
		  "data": [ ';

	for($i = 0; $i < count($lineas); $i++){
	
			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($lineas[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoLinea = 1;

			}if($lineas[$i]["estado"] == 1){

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoLinea = 2;

			}if($lineas[$i]["estado"] == 2){

				$colorEstado = "btn-warning";
				$textoEstado = "suspendido";
				$estadoLinea = 0;

			}

		 	$estado = "<button value=".$textoEstado." class='btn ".$colorEstado." btn-xs btnActivar' estadoLinea='".$estadoLinea."' idLinea='".$lineas[$i]["id"]."'>".$textoEstado."</button>";


			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/


			$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarLinea' idLinea='".$lineas[$i]["id"]."' data-toggle='modal' data-target='#modalEditarLinea'><i class='fa fa-pencil'></i></button></div>";


			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$lineas[$i]["numero"].'",
				      "'.$lineas[$i]["sim_card"].'",
				      "'.$lineas[$i]["placa"].'",
				      "'.$lineas[$i]["empresa"].'",
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
ACTIVAR TABLA DE LINEAS
=============================================*/ 
$activar = new TablaLineas();
$activar -> mostrarTabla();