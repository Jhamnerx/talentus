<?php

require_once "../controladores/persona.controlador.php";
require_once "../modelos/persona.modelo.php";

class TablaProveedor{

  /*=============================================
  MOSTRAR LA TABLA DE CATEGORÍAS
  =============================================*/ 

 	public function mostrarTabla(){	

 	$item = "tipo";
 	$valor = "Proveedor";
 	$count = 0;

 	$persona = ControladorPersona::ctrMostrarPersona($item, $valor, $count);


 	
 	if(count($persona) == 0){

      $datosJson = '{ "data":[]}';

      echo $datosJson;

      return;

    }

 	$datosJson = '{
		 
		  "data": [ ';

	for($i = 0; $i < count($persona); $i++){
	
			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($persona[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoProveedor = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoProveedor = 0;

			}

		 	$estado = "<button val=".$textoEstado." class='btn ".$colorEstado." btn-xs btnActivar' estadoProveedor='".$estadoProveedor."' idProveedor='".$persona[$i]["id"]."'>".$textoEstado."</button>";


			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/

  			if($persona[$i]["estado"] == 0){

  				//$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarProveedor' idProveedor='".$persona[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProveedor'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProveedor idProveedor".$persona[$i]["id"]."' idProveedor='".$persona[$i]["id"]."' ><i class='fa fa-times'></i></button></div>";
  				$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarProveedor' idProveedor='".$persona[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProveedor'><i class='fa fa-pencil'></i></button></div>";
  			}else{
  				$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarProveedor' idProveedor='".$persona[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProveedor'><i class='fa fa-pencil'></i></button></div>";
  				// $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarProveedor' idProveedor='".$persona[$i]["id"]."' data-toggle='modal' data-target='#modalEditarProveedor'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProveedor idProveedor".$persona[$i]["id"]."' idProveedor='".$persona[$i]["id"]."' ><i class='fa fa-times'></i></button></div>";
  			}
  			if ($persona[$i]["apellido"] == null) {
  				
  				$nombre = $persona[$i]["nombre"];

  			}else{

  				$nombre = $persona[$i]["nombre"]." ".$persona[$i]["apellido"];
  			}
			/*=============================================
  			TELEFONO USUARIOS
  			=============================================*/

  			$telefonoArray = explode(",", $persona[$i]["telefono"]);
  			$telefono = "";

  			for ($j=0; $j < count($telefonoArray); $j++) { 

  				$telefono.= "<label class='label label-success'>".$telefonoArray[$j]."</label><br><br>";
  			}

  				

	    
			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$nombre.'",
				      "'.$persona[$i]["tipo_documento"].'",
				      "'.$persona[$i]["num_documento"].'",
				      "'.$persona[$i]["direccion"].'",
				      "'.$telefono.'",
				      "'.$persona[$i]["email"].'",
				      "'.$estado.'",
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
ACTIVAR TABLA DE PROVEEDOR
=============================================*/ 
$activar = new TablaProveedor();
$activar -> mostrarTabla();