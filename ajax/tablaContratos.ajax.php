<?php 
require_once "../controladores/contratos.controlador.php";
require_once "../modelos/contratos.modelo.php";
require_once "../controladores/persona.controlador.php";
require_once "../modelos/persona.modelo.php";
require_once "../controladores/vehiculos.controlador.php";
require_once "../modelos/vehiculos.modelo.php";
/**
 * 
 */
class TablaContratos{
	
	public function mostrarTabla(){	

		$item = null;
		$valor = null;
		$mod = 2;

		$contratos = ControladorContratos::ctrMostrarContratos($item, $valor, $mod);

		if(count($contratos) == 0){

	      $datosJson = '{ "data":[]}';

	      echo $datosJson;

	      return;

	    }


 		$datosJson = '{
		 
		  "data": [ ';

		for($i = 0; $i < count($contratos); $i++){

			/*=============================================
			cliente
			=============================================*/ 


		    $item = "id";
		    $valor = $contratos[$i]["idcliente"];
		    $count = 1;

		    $cliente = ControladorPersona::ctrMostrarPersona($item, $valor, $count);
			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($contratos[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoContrato = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoContrato = 0;

			}

		 	$estado = "<button class='btn ".$colorEstado." btn-xs btnActivar' estadoContrato='".$estadoContrato."' idContrato='".$contratos[$i]["id"]."'>".$textoEstado."</button>";

			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/


  			//$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarContrato' idContrato='".$contratos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarContrato'><i class='fa fa-pencil'></i></div>";
  			// }else{

  			// 	$acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarContrato' idContrato='".$contratos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarContrato'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarContrato idContrato".$contratos[$i]["id"]."' disabled idContrato='".$contratos[$i]["id"]."' ><i class='fa fa-times'></i></button></div>";
  			// }

  			if ($contratos[$i]["fondo"] == 1 && $contratos[$i]["sello"] == 1) {

  			$caracteristicas = "<div class='form-group'> <label>Fondo</label> <input idContrato='".$contratos[$i]["id"]."' id='fondo' type='checkbox' class='caracteristicas' checked aria-checked='true'> <br> <label style='padding-right: 8px'>Sello</label><input idContrato='".$contratos[$i]["id"]."' id='sello' type='checkbox' class='caracteristicas' checked aria-checked='true'></div>";

  			}else if ($contratos[$i]["fondo"] == 1 && $contratos[$i]["sello"] == 0) {

  				$caracteristicas = "<div class='form-group'><label> Fondo <input id='fondo' idContrato='".$contratos[$i]["id"]."' class='caracteristicas' checked aria-checked='true' type='checkbox'></label> <br> <label style='padding-right: 8px'> Sello </label> <input id='sello' idContrato='".$contratos[$i]["id"]."' class='caracteristicas' type='checkbox'></div>";
  			}else if ($contratos[$i]["fondo"] == 0 && $contratos[$i]["sello"] == 1) {

  				$caracteristicas = "<div class='form-group'><label> Fondo </label> <input id='fondo' idContrato='".$contratos[$i]["id"]."' class='caracteristicas' type='checkbox'> <br> <label style='padding-right: 8px'> Sello   </label> <input id='sello' idContrato='".$contratos[$i]["id"]."' class='caracteristicas' checked aria-checked='true' type='checkbox'></div>";

  			}else if ($contratos[$i]["fondo"] == 0 && $contratos[$i]["sello"] == 0) {

  				$caracteristicas = "<div class='form-group'><label> Fondo <input id='fondo' idContrato='".$contratos[$i]["id"]."' class='caracteristicas' type='checkbox'></label> <br> <label style='padding-right: 8px'> Sello</label> <input id='sello' idContrato='".$contratos[$i]["id"]."' class='caracteristicas disabled' type='checkbox'></div>";
  			}

  			$detalle = ControladorContratos::ctrMostrarDetalleContratos("idcontrato", $contratos[$i]["id"], 0);

  			$list ="<ul>";

  			foreach ($detalle as $key => $value) {

  				$vehiculo = ControladorVehiculos::ctrMostrarVehiculos("id", $value["idvehiculo"]);

  				$list .="<li>".$vehiculo["placa"]."</li>";
  			}

  			$list .="</ul>";


  			//LISTA DE PLANES

  			$listPlan ="<ul>";

  			foreach ($detalle as $key => $value) {


  				$listPlan .="<li>".$value["plan"]."</li>";
  			}

  			$listPlan .="</ul>";

  			
      /*=============================================
        CREAR LAS ACCIONES
        =============================================*/

          $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarContrato' idContrato='".$contratos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarContrato'><i class='fa fa-pencil'></i></button> <button class='btn btn-danger btnEliminarContrato idContrato".$contratos[$i]["id"]."' idContrato='".$contratos[$i]["id"]."' ><i class='fa fa-times'></i></button></div>";
  			

	        if ($cliente["apellido"] == "null") {
	        	
	            $nombre_cliente = $cliente["nombre"];

	        }else{

	            $nombre_cliente = $cliente["nombre"]. " ".$cliente["apellido"];
	        }
	        
	    
			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'."<a target='_blank' href='reportes/contrato.php/".$contratos[$i]["id"]."'><button class='btn btn-info btnDescargarContrato' idContrato='".$contratos[$i]["id"]."'><i class='fa fa-download'></i> </button></a>".'",
				     "'.$nombre_cliente.'",
				      "'.$list.'",
				      "'.$contratos[$i]["ciudad"].'",
				      "'.$listPlan.'",
				      "'.$contratos[$i]["fecha"].'",
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
ACTIVAR TABLA DE CONTRATOS
=============================================*/ 
$activar = new TablaContratos();
$activar -> mostrarTabla();

 ?>