<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class TablaTecnicos{

  /*=============================================
  MOSTRAR LA TABLA DE TECNICOS
  =============================================*/ 

 	public function mostrarTabla(){	

 	$item = "cargo";
 	$valor = "6";

 	$usuarios = ControladorUsuarios::ctrMostrarTecnicos($item, $valor);

 	
 	if(count($usuarios) == 0){

      $datosJson = '{ "data":[]}';

      echo $datosJson;

      return;

    }

 	$datosJson = '{
		 
		  "data": [ ';

	for($i = 0; $i < count($usuarios); $i++){
	
			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($usuarios[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoUsuario = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoUsuario = 0;

			}

		 	$estado = "<button class='btn ".$colorEstado." btn-xs btnActivar' estadoUsuario='".$estadoUsuario."' idUsuario='".$usuarios[$i]["id"]."'>".$textoEstado."</button>";


			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/


  			$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarUsuario' idUsuario='".$usuarios[$i]["id"]."' data-toggle='modal' data-target='#modalEditarUsuario'><i class='fa fa-pencil'></i> EDITAR </button></div>";

	    
			/*=============================================
  			TELEFONO USUARIOS
  			=============================================*/

  			$telefonoArray = explode(",", $usuarios[$i]["telefono"]);
  			$telefono = "";

  			for ($j=0; $j < count($telefonoArray); $j++) { 

  				$telefono.= "<label class='label label-success'>".$telefonoArray[$j]."</label><br><br>";
  			}

			/*=============================================
  			NOMBRE USUARIOS
  			=============================================*/
  			if ($usuarios[$i]["apellido"] == null) {
  				
  				$nombre = $usuarios[$i]["nombre"];

  			}else{

  				$nombre = $usuarios[$i]["nombre"]." ".$usuarios[$i]["apellido"];
  			}
	    

			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$nombre.'",
				      "'.$telefono.'",
				      "'.$usuarios[$i]["email"].'",
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
ACTIVAR TABLA DE TECNICOS
=============================================*/ 
$activar = new TablaTecnicos();
$activar -> mostrarTabla();