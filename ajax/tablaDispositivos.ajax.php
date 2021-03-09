<?php

require_once "../controladores/dispositivos.controlador.php";
require_once "../modelos/dispositivos.modelo.php";

class TablaDispositivos{

  /*=============================================
  MOSTRAR LA TABLA DE DISPOSITIVOS
  =============================================*/ 

 	public function mostrarTabla(){	

 	$item = null;
 	$valor = null;

 	$dispositivos = ControladorDispositivos::ctrMostrarDispositivos($item, $valor);	
 	
 	if(count($dispositivos) == 0){

      $datosJson = '{ "data":[]}';

      echo $datosJson;

      return;

    }

 	$datosJson = '{
		 
		  "data": [ ';

	for($i = 0; $i < count($dispositivos); $i++){

			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/



			$acciones = "<div class='btn-group'><button  class='btn btn-warning btnEditarDispositivo' idDispositivo='".$dispositivos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarDispositivo'><i class='fa fa-pencil'></i></button></div>";

	    
			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$dispositivos[$i]["modelo"].'",
				      "'.$dispositivos[$i]["marca"].'",
				      "'.$dispositivos[$i]["certificado"].'",
				      "",
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
ACTIVAR TABLA DE DISPOSITIVOS
=============================================*/ 
$activar = new TablaDispositivos();
$activar -> mostrarTabla();