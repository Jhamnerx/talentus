<?php 
date_default_timezone_set("America/Lima");


require_once "../controladores/recibo.controlador.php";
require_once "../controladores/persona.controlador.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/recibo.modelo.php";
require_once "../modelos/persona.modelo.php";
require_once "../modelos/usuarios.modelo.php";



/**
 * 
 */
class TablaRecibos
{
	public $fechaReciboInicio;
  	public $fechaReciboFin;

	public function mostrarTabla()
	{
		$item = "fecha";

		$recibos = ControladorRecibos::ctrMostrarReporteRecibos($item, $this->fechaReciboInicio, $this->fechaReciboFin);

		if(count($recibos) == 0){

	      $datosJson = '{ "data":[]}';

	      echo $datosJson;

	      return;

	    }

	 	$datosJson = '{
			 
			  "data": [ ';

		for($i = 0; $i < count($recibos); $i++){

			/*=============================================
			cliente
			=============================================*/ 


		    $item = "id";
		    $valor = $recibos[$i]["idcliente"];
		    $count = 1;

		    $cliente = ControladorPersona::ctrMostrarPersona($item, $valor, $count);

			/*=============================================
			REVISAR ESTADO
			=============================================*/ 

			if($recibos[$i]["estado"] == 0){
				
				$colorEstado = "label-success";
				$textoEstado = "Cancelado";
				$estadoRecibo = 1;

			}else{

				$colorEstado = "label-warning";
				$textoEstado = "Por cobrar";
				$estadoRecibo = 0;

			}

		 	$estado = "<label class='btn ".$colorEstado." btn-xs labelActivar".$recibos[$i]["id"]."' estadoRecibo='".$estadoRecibo."' idRecibo='".$recibos[$i]["id"]."'>".$textoEstado."</label>";


			/*=============================================
  			FORMATEAR FECHA
  			=============================================*/
  			setlocale(LC_ALL,"es_ES");
  			$fecha=date_format(date_create($recibos[$i]["fecha"]),"d/m/Y");
  			$date = DateTime::createFromFormat("d/m/Y", $fecha);
  			$dia = strftime("%d", $date->getTimestamp());
			$mes = strftime("%B",$date->getTimestamp());
			$year = strftime("%Y",$date->getTimestamp());

			$fechaFormat = $dia." de ".$mes." del ".$year;

	        if ($cliente["apellido"] == "null") {
	            $nombre_cliente = $cliente["nombre"];

	        }else{

	            $nombre_cliente = $cliente["nombre"]. " ".$cliente["apellido"];
	        }


	        
			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$nombre_cliente.'",
				      "'.$recibos[$i]["num_recibo"].'",
				      "'.$recibos[$i]["tipoPago"].'",
				      "'.$recibos[$i]["total_recibo"].'",
				      "'.$fechaFormat.'",
				      "'.$estado.'"
				    ],';

		}


		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']
			  
		}'; 

		echo $datosJson;

	}
}
/*=============================================
MOSTRAR REPORTE RECIBO

=============================================*/

if(isset($_GET["fechaReciboInicio"])){

  $activar = new Tablarecibos();
  $activar -> fechaReciboInicio = $_GET["fechaReciboInicio"];
  $activar -> fechaReciboFin = $_GET["fechaReciboFin"];
  $activar -> mostrarTabla();

}
