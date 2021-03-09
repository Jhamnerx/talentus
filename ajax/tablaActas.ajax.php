<?php 

require_once "../controladores/actas.controlador.php";
require_once "../controladores/vehiculos.controlador.php";
require_once "../controladores/ciudad.controlador.php";

require_once "../modelos/vehiculos.modelo.php";
require_once "../modelos/actas.modelo.php";
require_once "../modelos/ciudad.modelo.php";

class TablaActa{

  /*=============================================
  MOSTRAR LA TABLA DE VEHICULOS
  =============================================*/ 

 	public function mostrarTabla(){

	 	$item = null;
	 	$valor = null;

	 	$acta = ControladorActas::ctrMostrarActa($item, $valor);	


	 	if(count($acta) == 0){

	      $datosJson = '{ "data":[]}';

	      echo $datosJson;

	      return;

	    }

	    $datosJson = '{
		 
		  "data": [ ';

		for($i = 0; $i < count($acta); $i++){

			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($acta[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoActa = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoActa = 0;

			}

  			if ($acta[$i]["fondo"] == 1 && $acta[$i]["sello"] == 1) {

  			$caracteristicas = "<div class='form-group'> <label>Fondo</label> <input idActa='".$acta[$i]["id"]."' id='fondo' type='checkbox' class='caracteristicas' checked aria-checked='true'> <br> <label style='padding-right: 8px'>Sello</label><input idActa='".$acta[$i]["id"]."' id='sello' type='checkbox' class='caracteristicas' checked aria-checked='true'></div>";

  			}else if ($acta[$i]["fondo"] == 1 && $acta[$i]["sello"] == 0) {

  				$caracteristicas = "<div class='form-group'><label> Fondo <input id='fondo' idActa='".$acta[$i]["id"]."' class='caracteristicas' checked aria-checked='true' type='checkbox'></label> <br> <label style='padding-right: 8px'> Sello </label> <input id='sello' idActa='".$acta[$i]["id"]."' class='caracteristicas' type='checkbox'></div>";
  			}else if ($acta[$i]["fondo"] == 0 && $acta[$i]["sello"] == 1) {

  				$caracteristicas = "<div class='form-group'><label> Fondo </label> <input id='fondo' idActa='".$acta[$i]["id"]."' class='caracteristicas' type='checkbox'> <br> <label style='padding-right: 8px'> Sello   </label> <input id='sello' idActa='".$acta[$i]["id"]."' class='caracteristicas' checked aria-checked='true' type='checkbox'></div>";

  			}else if ($acta[$i]["fondo"] == 0 && $acta[$i]["sello"] == 0) {

  				$caracteristicas = "<div class='form-group'><label> Fondo <input id='fondo' idActa='".$acta[$i]["id"]."' class='caracteristicas' type='checkbox'></label> <br> <label style='padding-right: 8px'> Sello</label> <input id='sello' idActa='".$acta[$i]["id"]."' class='caracteristicas disabled' type='checkbox'></div>";
  			}

		 	$estado = "<button value='".$textoEstado."' class='btn ".$colorEstado." btn-xs btnActivar' estadoActa='".$estadoActa."' idActa='".$acta[$i]["id"]."'>".$textoEstado."</button>";
		 	
		 	/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/
	    
		    $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarActa' idvehiculo='".$acta[$i]["idvehiculo"]."' idacta='".$acta[$i]["id"]."' data-toggle='modal' data-target='#modalEditarActa'><i class='fa fa-pencil'></i></button></div>";

		    $descargar = "<a target='_blank' href='reportes/acta.php/".$acta[$i]["id"]."'><button class='btn btn-info btnDescargarActa' ciudad='".$acta[$i]["ciudad"]."' idActa='".$acta[$i]["id"]."'><i class='fa fa-download'></i> </button></a>";

		    $vehiculo = ControladorVehiculos::ctrMostrarVehiculos("id", $acta[$i]["idvehiculo"]);

		    $ciudad = ModeloCiudad::mdlMostrarCiudad("ciudad", "id", $acta[$i]["ciudad"]);

		    $codigo = $ciudad["prefijo"]."-".$acta[$i]["year"]."-".$acta[$i]["num_acta"];
		    //var_dump($vehiculo);



		   
		    $datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$codigo.'",
				      "'.$descargar.'",	
				      "'.$vehiculo["placa"].'",
				      "'.$acta[$i]["inicio_cobertura"].'",
				      "'.$acta[$i]["fin_cobertura"].'",
				      "'.$acta[$i]["fecha"].'",
				      "'.$caracteristicas.'",
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

	$activar = new TablaActa();
	$activar -> mostrarTabla();
 ?>