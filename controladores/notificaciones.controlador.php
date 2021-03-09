<?php 

class ControladorNotificaciones{

	static public function ctrMostrarNotificaciones($item, $valor){


		$tabla = "notificaciones";

		$respuesta = ModeloNotificaciones::mdlMostrarNotificaciones($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	AÑDIR NOTIFICACIONES
	=============================================*/

	static public function ctrIngresarNotificacion($datos){

		if(isset($datos)){


 			//verificar que no exista
			$respuesta1 = ModeloNotificaciones::mdlMostrarNotificaciones("notificaciones","idCobro", $datos["idCobro"]);
				
			// echo json_encode($respuesta1);
			if (!$respuesta1) {
			

				$respuesta = ModeloNotificaciones::mdlIngresarNotificacion("notificaciones", $datos);

			}
			


			

			// 

			// 	if($respuesta == 1){

			// 		echo'<script>

			// 			console.log("se añadio")


			// 		</script>';

			// 	}else{

			// 		echo'<script>

			// 			console.log("No se añadio")


			// 		</script>';

			//   	return;

			// }
		}
	}






}



 ?>