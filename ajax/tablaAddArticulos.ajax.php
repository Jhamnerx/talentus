<?php 

require_once "../controladores/servicios.controlador.php";
require_once "../modelos/servicios.modelo.php";

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";

class TablaAddArticulos{

  /*=============================================
  MOSTRAR LA TABLA DE SERVICIOS
  =============================================*/ 

 	public function mostrarTabla(){

	 	$item = "estado";
	 	$valor = 1;

	 	$articulos = ControladorServicios::ctrMostrarArticulos($item, $valor);

	 	if(count($articulos) == 0){

	      $datosJson = '{ "data":[]}';

	      echo $datosJson;

	      return;

	    }


	    $datosJson = '{
		 
		  "data": [ ';

		for($i = 0; $i < count($articulos); $i++){

			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($articulos[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoServicio = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoServicio = 0;

			}
			$item = "id";
		    $valor = $articulos[$i]["idcategoria"];

		    $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

			$categoria = $categorias["categoria"];

		 	$estado = "<button class='btn ".$colorEstado." btn-xs btnActivar' estadoServicio='".$estadoServicio."' idServicio='".$articulos[$i]["id"]."'>".$textoEstado."</button>";
		 	
		 	if ($articulos[$i]["imagen"] != "") {

		 		$imagen = "<img src='".$articulos[$i]["imagen"]."' width='50px'>";
		 		
		 	}else{
		 		$imagen = "<img src='vistas/img/servicios/default/default.png' width='50px'>";
		 	}
		 	
		    /**
		     *	CREAR BOTON AGREGAR
		     *	
		     */
		    $accion = "agregarDetalle".$_GET["tipo"]."(";
		    
			$boton = "<button class='btn btn-warning agregarArticulo' name='".$articulos[$i]["id"]."' value='".$articulos[$i]["nombre"]."' idarticulo='".$articulos[$i]["id"]."' onclick='".$accion.$articulos[$i]["id"].", ".$articulos[$i]["stock"].", ".$articulos[$i]["precio"].")'><span class='fa fa-plus'></span></button>";

		    $datosJson	 .= '[
				      "'.$articulos[$i]["nombre"].'",
				      "'.$categoria.'",
				      "'.$articulos[$i]["precio"].'",
				      "'.$articulos[$i]["stock"].'",
				      "'.$imagen.'",
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

	$activar = new TablaAddArticulos();
	$activar -> mostrarTabla();

