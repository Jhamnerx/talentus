<?php 

require_once "../controladores/certificado.controlador.php";
require_once "../controladores/persona.controlador.php";
require_once "../controladores/ciudad.controlador.php";
require_once "../controladores/dispositivos.controlador.php";

require_once "../modelos/certificado.modelo.php";
require_once "../modelos/persona.modelo.php";
require_once "../modelos/ciudad.modelo.php";
require_once "../modelos/dispositivos.modelo.php";



class TablaCertificado{

  /*=============================================
  MOSTRAR LA TABLA DE VEHICULOS
  =============================================*/ 

 	public function mostrarTabla(){

	 	$item = null;
	 	$valor = null;

	 	$certificado = ControladorCertificados::ctrMostrarCertificado($item, $valor);	


	 	if(count($certificado) == 0){

	      $datosJson = '{ "data":[]}';

	      echo $datosJson;

	      return;

	    }

	    $datosJson = '{
		 
		  "data": [ ';

		for($i = 0; $i < count($certificado); $i++){

			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($certificado[$i]["estado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Desactivado";
				$estadoCertificado = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Activado";
				$estadoCertificado = 0;

			}

  			if ($certificado[$i]["fondo"] == 1 && $certificado[$i]["sello"] == 1) {

  			$caracteristicas = "<div class='form-group'> <label>Fondo</label> <input idCertificado='".$certificado[$i]["id"]."' id='fondo' type='checkbox' class='caracteristicas' checked aria-checked='true'> <br> <label style='padding-right: 8px'>Sello</label><input idCertificado='".$certificado[$i]["id"]."' id='sello' type='checkbox' class='caracteristicas' checked aria-checked='true'></div>";

  			}else if ($certificado[$i]["fondo"] == 1 && $certificado[$i]["sello"] == 0) {

  				$caracteristicas = "<div class='form-group'><label> Fondo <input id='fondo' idCertificado='".$certificado[$i]["id"]."' class='caracteristicas' checked aria-checked='true' type='checkbox'></label> <br> <label style='padding-right: 8px'> Sello </label> <input id='sello' idCertificado='".$certificado[$i]["id"]."' class='caracteristicas' type='checkbox'></div>";
  			}else if ($certificado[$i]["fondo"] == 0 && $certificado[$i]["sello"] == 1) {

  				$caracteristicas = "<div class='form-group'><label> Fondo </label> <input id='fondo' idCertificado='".$certificado[$i]["id"]."' class='caracteristicas' type='checkbox'> <br> <label style='padding-right: 8px'> Sello   </label> <input id='sello' idCertificado='".$certificado[$i]["id"]."' class='caracteristicas' checked aria-checked='true' type='checkbox'></div>";

  			}else if ($certificado[$i]["fondo"] == 0 && $certificado[$i]["sello"] == 0) {

  				$caracteristicas = "<div class='form-group'><label> Fondo <input id='fondo' idCertificado='".$certificado[$i]["id"]."' class='caracteristicas' type='checkbox'></label> <br> <label style='padding-right: 8px'> Sello</label> <input id='sello' idCertificado='".$certificado[$i]["id"]."' class='caracteristicas disabled' type='checkbox'></div>";
  			}

		 	$estado = "<button value='".$textoEstado."' class='btn ".$colorEstado." btn-xs btnActivar' estadoCertificado='".$estadoCertificado."' idCertificado='".$certificado[$i]["id"]."'>".$textoEstado."</button>";
		 	
		 	/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/
	    
		    $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarCertificado' idcertificado='".$certificado[$i]["id"]."' data-toggle='modal' data-target='#modalEditarCertificado'><i class='fa fa-pencil'></i></button></div>";

		    $descargar = "<a target='_blank' href='reportes/certificado.php/".$certificado[$i]["id"]."'><button class='btn btn-info btnDescargarCertificado' idCertificado='".$certificado[$i]["id"]."'><i class='fa fa-download'></i> </button></a>";


		    $item = "id";
		    $valor = $certificado[$i]["idcliente"];
		    $count = 1;

		    $cliente = ControladorPersona::ctrMostrarPersona($item, $valor, $count);


		    $dispositivo = ControladorDispositivos::ctrMostrarDispositivos("id", $certificado[$i]["modelo_gps"]);

		    //var_dump($dispositivo["modelo"]);

		    $ciudad = ModeloCiudad::mdlMostrarCiudad("ciudad", "id", $certificado[$i]["ciudad"]);

		    $codigo = $ciudad["prefijo"]."-".$certificado[$i]["year"]."-".$certificado[$i]["num_certificado"];
		  //  var_dump($cliente);



		      
		    $datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$codigo.'",
				      "'.$descargar.'",	
				      "'.$cliente["nombre"].' '.$cliente["apellido"].'",
				      "'.$dispositivo["modelo"].'",
				      "'.$certificado[$i]["fin_cobertura"].'",
				      "'.$certificado[$i]["fecha"].'",
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
ACTIVAR TABLA DE CERTIFICADOS
=============================================*/ 

	$activar = new TablaCertificado();
	$activar -> mostrarTabla();
 ?>