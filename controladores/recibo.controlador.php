<?php
class ControladorRecibos{

	/*=============================================
	MOSTRAR RECIBO
	=============================================*/

	static public function ctrMostrarRecibo($item, $valor){

		$tabla = "recibo";

		$respuesta = ModeloRecibos::mdlMostrarRecibos($tabla, $item, $valor, $cant = 0);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR REPORTE RECIBOS
	=============================================*/

	static public function ctrMostrarReporteRecibos($item, $fechaInicio, $fechaFin){

		$tabla = "recibo";

		$respuesta = ModeloRecibos::mdlMostrarReporteRecibos($tabla, $item, $fechaInicio, $fechaFin);

		return $respuesta;

	}
	/*=============================================
	MOSTRAR RECIBO
	=============================================*/

	static public function ctrMostrarRecibos($item, $valor){

		$tabla = "recibo";

		$respuesta = ModeloRecibos::mdlMostrarRecibos($tabla, $item, $valor, $cant = 1);

		return $respuesta;

	}

	/*=============================================
	DETALLE RECIBO
	=============================================*/

	static public function ctrDetalleRecibo($item, $valor){

		$tabla = "detalle_recibo";

		$respuesta = ModeloRecibos::mdlDetalleRecibos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	GUARDAR RECIBO
	=============================================*/

	static public function ctrGuardarRecibo($datos){

		$tabla = "recibo";


		$respuesta = ModeloRecibos::mdlGuardarRecibo($tabla, $datos);

		if ($respuesta != null) {

			$datos1 = array("item"=>$datos["item"],
					"cantidad"=>$datos["cantidad"],
					"idrecibo"=>$respuesta,
					"precio"=>$datos["precio"]
					);

			$tabla1 = "detalle_recibo";

			$respuesta1 =  ModeloRecibos::mdlGuardarReciboDetalle($tabla1, $datos1);
			return $respuesta1;
		}

		
	}
	/*=============================================
	EDITAR RECIBO
	=============================================*/

	static public function ctrEditarRecibo($datos){

		$tabla = "recibo";


		$respuesta = ModeloRecibos::mdlEditarRecibo($tabla, $datos);


		if ($respuesta != null) {

			$datos1 = array("item"=>$datos["item"],
					"cantidad"=>$datos["cantidad"],
					"idDetalle"=>$datos["idDetalle"],
					"precio"=>$datos["precio"]
					);

			$tabla1 = "detalle_recibo";

			$respuesta1 =  ModeloRecibos::mdlEditarReciboDetalle($tabla1, $datos1);

			return $respuesta1;
		}

		
	}
	/*=============================================
	ELIMINAR RECIBO
	=============================================*/

	static public function ctrEliminarRecibo(){

		if(isset($_GET["idRecibo"])){


			/*=============================================
			BORRAR DETALLE DE LOS RECIBOS
			=============================================*/
			$tabla = "detalle_recibo";
			$item = "idrecibo";
			$valor = $_GET["idRecibo"];

			$detalleRecibo = ModeloRecibos::mdlEliminarDetalleRecibo($tabla, $item, $valor);

			if($detalleRecibo){


				$respuesta = ModeloRecibos::mdlEliminarRecibo("recibo", $_GET["idRecibo"]);


				if($respuesta == 1){

					echo'<script>
					swal({
						  type: "success",
						  title: "El recibo ha sido eliminado",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "recibo";

									}
								})

					</script>';
					
				}

			}


			


			
		}

	}

}
