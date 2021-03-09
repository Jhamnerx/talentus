<?php

require_once "../controladores/flotas.controlador.php";
require_once "../modelos/flotas.modelo.php";
require_once "../controladores/persona.controlador.php";
require_once "../modelos/persona.modelo.php";

class TablaFlotas{

  /*=============================================
  MOSTRAR LA TABLA DE CATEGORÍAS
  =============================================*/ 

 	public function mostrarTabla(){	

 	$item = null;
 	$valor = null;

 	$flotas = ControladorFlotas::ctrMostrarFlotas($item, $valor);	
 	
 	if(count($flotas) == 0){

      $datosJson = '{ "data":[]}';

      echo $datosJson;

      return;

    }

 	$datosJson = '{
		 
		  "data": [ ';

	for($i = 0; $i < count($flotas); $i++){

			$item = "id";
		    $valor = $flotas[$i]["idcliente"];
		    $count = 1;

		    $cliente = ControladorPersona::ctrMostrarPersona($item, $valor, $count);
	
			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($flotas[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoFlota = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoFlota = 0;

			}

		 	$estado = "<button class='btn ".$colorEstado." btn-xs btnActivar' estadoFlota='".$estadoFlota."' idFlota='".$flotas[$i]["id"]."'>".$textoEstado."</button>";


			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/

  			if($flotas[$i]["estado"] == 0){

  				$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarFlota' idFlota='".$flotas[$i]["id"]."' data-toggle='modal' data-target='#modalEditarFlota'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarFlota idFlota".$flotas[$i]["id"]."' idFlota='".$flotas[$i]["id"]."' ><i class='fa fa-times'></i></button></div>";
  			}else{

  				$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarFlota' idFlota='".$flotas[$i]["id"]."' data-toggle='modal' data-target='#modalEditarFlota'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarFlota idFlota".$flotas[$i]["id"]."' disabled idFlota='".$flotas[$i]["id"]."' ><i class='fa fa-times'></i></button></div>";
  			}

	        if ($cliente["apellido"] == "null") {
	            $nombre_cliente = $cliente["nombre"];

	        }else{

	            $nombre_cliente = $cliente["nombre"]. " ".$cliente["apellido"];
	        }
	        
			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$flotas[$i]["nombre"].'",
				      "'.$nombre_cliente.'",
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
ACTIVAR TABLA DE CATEGORÍAS
=============================================*/ 
$activar = new TablaFlotas();
$activar -> mostrarTabla();