<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../controladores/ciudad.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../modelos/ciudad.modelo.php";
require_once "../modelos/rutas.php";
class TablaUsuarios{

  /*=============================================
  MOSTRAR LA TABLA DE USUARIOS
  =============================================*/ 

 	public function mostrarTabla(){	
 	$url = Ruta::ctrRuta();
 	$item = null;
 	$valor =null;

 	$usuarios = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

 	
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
  			NOMBRE USUARIOS
  			=============================================*/
  			if ($usuarios[$i]["apellido"] == null) {
  				
  				$nombre = $usuarios[$i]["nombre"];

  			}else{

  				$nombre = $usuarios[$i]["nombre"]." ".$usuarios[$i]["apellido"];
  			}
	    
			/*=============================================
  			TELEFONO USUARIOS
  			=============================================*/

  			$telefonoArray = explode(",", $usuarios[$i]["telefono"]);
  			$telefono = "";

  			for ($j=0; $j < count($telefonoArray); $j++) { 

  				$telefono.= "<label class='label label-success'>".$telefonoArray[$j]."</label><br><br>";
  			}

			$item = "id";
   			$valor = $usuarios[$i]["ciudad"];

   			$ciudad = ControladorCiudad::ctrMostrarCiudad($item, $valor);
			/*=============================================
  			TELEFONO USUARIOS
  			=============================================*/

  			$foto = "<img class='img-circle' src='".$url.$usuarios[$i]["foto"]."' width='60px'>";

  			$password = "<div class='btn-group'><button class='btn btn-info btnCambiarPassword' idUsuario='".$usuarios[$i]["id"]."' data-toggle='modal' data-target='#modalCambiarPassword'><i class='fa fa-key'></i> Contraseña </button></div>";
  		
			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$nombre.'",
				      "'.$usuarios[$i]["num_documento"].'",
				      "'.$usuarios[$i]["direccion"].'",
				      "'.$telefono.'",
				      "'.$usuarios[$i]["email"].'",
				      "'.$usuarios[$i]["login"].'",
				      "'.$password.'",
				      "'.$ciudad["nombre"].'",
				      "'.$foto.'",
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
ACTIVAR TABLA DE CATEGORÍAS
=============================================*/ 
$activar = new TablaUsuarios();
$activar -> mostrarTabla();