<?php

class ControladorTareas{

	/*=============================================
	MOSTRAR TAREAS
	=============================================*/

	static public function ctrMostrarTareas($item, $valor){

		$tabla = "tareas";

		$respuesta = ModeloTarea::mdlMostrarTareas($tabla, $item, $valor);

		return $respuesta;

	}
	/*=============================================
	MOSTRAR TIPO TAREAS
	=============================================*/

	static public function ctrMostrarTipoTareas($item, $valor){

		$tabla = "tipotarea";

		$respuesta = ModeloTarea::mdlMostrarTipoTarea($tabla, $item, $valor);

		return $respuesta;

	}
	/*=============================================
	CREAR TAREAS
	=============================================*/

	static public function ctrCrearTarea(){

		if(isset($_POST["tipoTarea"])){
			$datos = array("tipo"=>trim($_POST["tipoTarea"]),
						   "id_admin"=>$_SESSION["id"],
						   "dispositivo"=>$_POST["dispositivo"],
						   "vehiculo"=>trim($_POST["idVehiculo"]),
						   "sim"=>$_POST["simTarea"],
						   "sim_card"=>$_POST["simCardTarea"],
						   "nuevo_sim"=>$_POST["nuevoSimTarea"],
						   "nuevo_card"=>$_POST["nuevoSimCardTarea"],
						   "cliente"=>1,
						   "fecha"=>$_POST["fechaTarea"],
						   "hora"=>$_POST["horaTarea"],
						   "estado"=> 1);

			$respuesta = ModeloTarea::mdlCrearTarea("tareas", $datos);

				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "La Tarea ha sido creada",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "tareas";

							}
						})

					</script>';

				}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡Los datos no pueden ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  })

			  	</script>';

			  	return;

			}
		}
	}


	/*=============================================
	CREAR TAREAS
	=============================================*/

	static public function ctrCrearTipoTarea(){

		if(isset($_POST["crearTipoTarea"])){
			$datos = array("tipo"=>trim($_POST["crearTipoTarea"]),
						   "costo"=>trim($_POST["costoTarea"])
						);

			$respuesta = ModeloTarea::mdlCrearTipoTarea("tipotarea", $datos);

				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "La Tarea ha sido creada",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "tareas";

							}
						})

					</script>';

				}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡Los datos no pueden ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  })

			  	</script>';

			  	return;

			}
		}
	}


	/*=============================================
	ELIMINAR TAREA
	=============================================*/

	static public function ctrEliminarTarea(){

		if(isset($_GET["idTarea"])){


			/*=============================================
			QUITAR LAS TAREAS DE LOS PRODUCTOS
			=============================================*/
			$tabla = "tareas";
			$valor = $_GET["idTarea"];


			$respuesta = ModeloTarea::mdlEliminarTarea("tareas", $_GET["idTarea"]);


			if($respuesta == 1){

				echo'<script>
				swal({
					  type: "success",
					  title: "La tarea ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "tareas";

								}
							})

				</script>';
				
			}
			
		}

	}


}
