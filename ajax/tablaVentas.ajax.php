<?php
require_once "../controladores/ventas.controlador.php";
require_once "../controladores/persona.controlador.php";
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../modelos/persona.modelo.php";
require_once "../modelos/usuarios.modelo.php";



/**
 *
 */
class TablaVentas
{

	public function mostrarTabla()
	{
		$item = null;
		$valor = null;

		$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

		if(count($ventas) == 0){

	      $datosJson = '{ "data":[]}';

	      echo $datosJson;

	      return;

	    }

	 	$datosJson = '{

			  "data": [ ';

		for($i = 0; $i < count($ventas); $i++){

			/*=============================================
			cliente
			=============================================*/


		    $item = "id";
		    $valor = $ventas[$i]["idcliente"];
		    $count = 1;

		    $cliente = ControladorPersona::ctrMostrarPersona($item, $valor, $count);

			/*=============================================
			REVISAR ESTADO
			=============================================*/

			if($ventas[$i]["estado"] == 0){

				$colorEstado = "label-danger";
				$textoEstado = "Anulado";
				$estadoVenta = 1;

			}else{

				$colorEstado = "label-success";
				$textoEstado = "Aceptado";
				$estadoVenta = 0;

			}

		 	$estado = "<label class='btn ".$colorEstado." btn-xs labelActivar".$ventas[$i]["id"]."' estadoVenta='".$estadoVenta."' idVenta='".$ventas[$i]["id"]."'>".$textoEstado."</label>";

			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/

  			if($ventas[$i]["estado"] == 0){

  				$acciones = "<div class='btn-group'><button style='margin-right: 5px;' class='btn btn-warning btnVerVenta' onclick='mostrarVenta(".$ventas[$i]["id"].")' idVenta='".$ventas[$i]["id"]."'><i class='fa fa-eye'></i></button> <a href='reportes/factura.php/".$ventas[$i]["id"]."' idVenta='".$ventas[$i]["id"]."' target='_blank' class='facturaExport' ><button class='btn btn-info'><i class='fa fa-file'></i></button></a></div>";
  			}else{

  				$acciones = "<div class='btn-group'><button style='margin-right: 5px;' class='btn btn-warning btnVerVenta' onclick='mostrarVenta(".$ventas[$i]["id"].")' idVenta='".$ventas[$i]["id"]."'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btnEliminarVenta idVenta".$ventas[$i]["id"]."' id='btnEliminarVenta' idVenta='".$ventas[$i]["id"]."' ><i class='fa fa-times'></i></button> <a href='reportes/factura.php/".$ventas[$i]["id"]."' idVenta='".$ventas[$i]["id"]."' target='_blank' class='facturaExport'> <button class='btn btn-info'><i class='fa fa-file'></i></button></a> </div>";
  			}
			/*=============================================
  			FORMATEAR FECHA
  			=============================================*/
  			setlocale(LC_ALL,"es_ES");
  			$fecha=date_format(date_create($ventas[$i]["fecha_hora"]),"d/m/Y");
  			$date = DateTime::createFromFormat("d/m/Y", $fecha);
  			$dia = strftime("%d", $date->getTimestamp());
				$mes = strftime("%B",$date->getTimestamp());
				$year = strftime("%Y",$date->getTimestamp());

				$fechaFormat = $dia." de ".$mes." del ".$year;
				if ($cliente) {
					if ($cliente["apellido"] == "null") {
	            $nombre_cliente = $cliente["nombre"];

	        }else{

	            $nombre_cliente = $cliente["nombre"]. " ".$cliente["apellido"];
	        }
				}else {
					$nombre_cliente = "<em>Cliente sin datos</em>";
				}


	        //info usuarioi
	        $usuario = ControladorUsuarios::ctrMostrarUsuarios("id", $ventas[$i]["idusuario"]);


			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$acciones.'",
				      "'.$ventas[$i]["empresa"].'",
				      "'.$nombre_cliente.'",
				      "'.$usuario["nombre"].'",
				      "'.$ventas[$i]["tipo_comprobante"].'",
				      "'.$ventas[$i]["serie_comprobante"]."-".$ventas[$i]["num_comprobante"].'",
				      "'.$ventas[$i]["divisa"]." ".$ventas[$i]["total_venta"].'",
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
ACTIVAR TABLA DE VENTAS
=============================================*/
$activar = new Tablaventas();
$activar -> mostrarTabla();
