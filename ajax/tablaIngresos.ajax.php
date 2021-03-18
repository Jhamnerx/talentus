<?php
require_once "../controladores/ingresos.controlador.php";
require_once "../controladores/persona.controlador.php";
require_once "../modelos/ingresos.modelo.php";
require_once "../modelos/persona.modelo.php";



/**
 *
 */
class TablaIngresos
{

	public function mostrarTabla()
	{
		$item = null;
		$valor = null;

		$ingresos = ControladorIngresos::ctrMostrarIngresos($item, $valor);

		if(count($ingresos) == 0){

	      $datosJson = '{ "data":[]}';

	      echo $datosJson;

	      return;

	    }

	 	$datosJson = '{

			  "data": [ ';

		for($i = 0; $i < count($ingresos); $i++){

			/*=============================================
			PROVEEDOR
			=============================================*/


		    $item = "id";
		    $valor = $ingresos[$i]["idproveedor"];
		    $count = 1;

		    $proveedor = ControladorPersona::ctrMostrarPersona($item, $valor, $count);

		    //var_dump($proveedor);

			/*=============================================
			REVISAR ESTADO
			=============================================*/

			if($ingresos[$i]["estado"] == 0){

				$colorEstado = "label-danger";
				$textoEstado = "Desactivado";
				$estadoIngreso = 1;

			}else{

				$colorEstado = "label-success";
				$textoEstado = "Activado";
				$estadoIngreso = 0;

			}

		 	$estado = "<label class='btn ".$colorEstado." btn-xs labelActivar".$ingresos[$i]["id"]."' estadoIngreso='".$estadoIngreso."' idIngreso='".$ingresos[$i]["id"]."'>".$textoEstado."</label>";

			/*=============================================
  			CREAR LAS ACCIONES
  			=============================================*/

  			if($ingresos[$i]["estado"] == 0){

  				$acciones = "<div class='btn-group'><button style='margin-right: 5px;' class='btn btn-warning btnVerIngreso' onclick='mostrarIngreso(".$ingresos[$i]["id"].")' idIngreso='".$ingresos[$i]["id"]."' data-toggle='modal' data-target='#modalVerIngreso'><i class='fa fa-eye'></i></button>";
  			}else{

  				$acciones = "<div class='btn-group'><button style='margin-right: 5px;' class='btn btn-warning btnVerIngreso' onclick='mostrarIngreso(".$ingresos[$i]["id"].")' idIngreso='".$ingresos[$i]["id"]."' data-toggle='modal' data-target='#modalVerIngreso'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btnEliminarIngreso idIngreso".$ingresos[$i]["id"]."' id='btnEliminarIngreso' idIngreso='".$ingresos[$i]["id"]."' ><i class='fa fa-times'></i></button></div>";
  			}
			/*=============================================
  			FORMATEAR FECHA
  			=============================================*/
  			setlocale(LC_ALL,"es_ES");
  			$fecha=date_format(date_create($ingresos[$i]["fecha_hora"]),"d/m/Y");
  			$date = DateTime::createFromFormat("d/m/Y", $fecha);
  			$dia = strftime("%d", $date->getTimestamp());
				$mes = strftime("%B",$date->getTimestamp());
				$year = strftime("%Y",$date->getTimestamp());

				$fechaFormat = $dia." de ".$mes." del ".$year;
				if ($proveedor) {
					if ($proveedor["apellido"] == null) {

	            $nombre_cliente = $proveedor["nombre"];

	        }else{

	            $nombre_cliente = $proveedor["nombre"]. " ".$proveedor["apellido"];
	        }
				}else {
					 $nombre_cliente = "<em>Proveedor sin datos</em>";
				}


			$datosJson	 .= '[
				      "'.($i+1).'",
				      "'.$acciones.'",
				      "'.$nombre_cliente.'",
				      "'.$ingresos[$i]["idusuario"].'",
				      "'.$ingresos[$i]["tipo_comprobante"].'",
				      "'.$ingresos[$i]["serie_comprobante"]."-".$ingresos[$i]["num_comprobante"].'",
				      "'.$ingresos[$i]["divisa"]." ".$ingresos[$i]["total_compra"].'",
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
ACTIVAR TABLA DE CATEGORÍAS
=============================================*/
$activar = new TablaIngresos();
$activar -> mostrarTabla();
