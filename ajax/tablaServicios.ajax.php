<?php 

require_once "../controladores/servicios.controlador.php";
require_once "../modelos/servicios.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class TablaServicios{

  /*=============================================
  MOSTRAR LA TABLA DE SERVICIOS
  =============================================*/ 

 	public function mostrarTabla(){

	 	$item = null;
	 	$valor = null;

	 	$servicios = ControladorServicios::ctrMostrarServicios($item, $valor);

	 	if(count($servicios) == 0){

	      $datosJson = '{ "data":[]}';

	      echo $datosJson;

	      return;

	    }


	    $datosJson = '{
		 
		  "data": [ ';

		for($i = 0; $i < count($servicios); $i++){

			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($servicios[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoServicio = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoServicio = 0;

			}
			$item = "id";
		    $valor = $servicios[$i]["idcategoria"];

		    $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

			$categoria = $categorias["categoria"];

		 	$estado = "<button value=".$textoEstado." class='btn ".$colorEstado." btn-xs btnActivar' estadoServicio='".$estadoServicio."' idServicio='".$servicios[$i]["id"]."'>".$textoEstado."</button>";
		 	
		 	if ($servicios[$i]["imagen"] != "") {

		 		$imagen = "<img src='".$servicios[$i]["imagen"]."' width='50px'>";
		 		
		 	}else{
		 		$imagen = "<img src='vistas/img/servicios/default/default.png' width='50px'>";
		 	}
		 	
		 	/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/
	    
		    $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarServicio' idServicio='".$servicios[$i]["id"]."' data-toggle='modal' data-target='#modalEditarServicio'><i class='fa fa-pencil'></i></button></div>";

		    $datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$servicios[$i]["nombre"].'",
				      "'.$categoria.'",
				      "'.$servicios[$i]["precio"].'",
				      "'.$servicios[$i]["stock"].'",
				      "'.$imagen.'",
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
ACTIVAR TABLA DE SERVICIOS
=============================================*/ 

	$activar = new TablaServicios();
	$activar -> mostrarTabla();

