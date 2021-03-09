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
	
	public function mostrarTabla()
	{
		$item = null;
		$valor = null;

		$recibos = ControladorRecibos::ctrMostrarRecibos($item, $valor);

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
			REVISAR ESTADO
			=============================================*/ 

			if($recibos[$i]["anulado"] == 0){
				
				$colorEstado = "btn-danger";
				$textoEstado = "Anulado";
				$estadoRecibo = 1;

			}else{

				$colorEstado = "btn-success";
				$textoEstado = "Aceptado";
				$estadoRecibo = 0;

			}

		 	$anulado = "<button value=".$textoEstado." class='btn ".$colorEstado." btn-xs btnActivar' estadoRecibo='".$estadoRecibo."' idRecibo='".$recibos[$i]["id"]."'>".$textoEstado."</button>";


			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/

  			$acciones = "<div class='btn-group'><button style='margin-right: 5px;'  class='btn btn-warning btnEditarRecibo' idRecibo='".$recibos[$i]["id"]."' data-toggle='modal' data-target='#modalEditarRecibo'><i class='fa fa-pencil'></i></button> <button  style='margin-right: 5px;'class='btn btn-danger btnEliminarRecibo idRecibo".$recibos[$i]["id"]."' id='btnEliminarRecibo' idRecibo='".$recibos[$i]["id"]."' ><i class='fa fa-times'></i></button> <a href='reportes/recibo.php/".$recibos[$i]["id"]."' idRecibo='".$recibos[$i]["id"]."' target='_blank' class='facturaExport'> <button class='btn btn-info'><i class='fa fa-file'></i></button></a> </div>";

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
				      "'.$acciones.'",
				      "'.$nombre_cliente.'",
				      "'.$recibos[$i]["num_recibo"].'",
				      "'.$recibos[$i]["tipoPago"].'",
				      "'.$recibos[$i]["total_recibo"].'",
				      "'.$fechaFormat.'",
				      "'.$estado.'",
				      "'.$anulado.'"
				    ],';

		}


		$datosJson = substr($datosJson, 0, -1);

		$datosJson.=  ']
			  
		}'; 

		echo $datosJson;

	}
}

/*=============================================
ACTIVAR TABLA DE RECIBOS
=============================================*/ 
$activar = new Tablarecibos();
$activar -> mostrarTabla();