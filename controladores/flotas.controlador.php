<?php

class ControladorFlotas{

	/*=============================================
	MOSTRAR FLOTAS
	=============================================*/

	static public function ctrMostrarFlotas($item, $valor){

		$tabla = "flota";

		$respuesta = ModeloFlotas::mdlMostrarFlotas($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR FLOTAS
	=============================================*/

	static public function ctrCrearFlota(){


		if(isset($_POST["nombreFlota"])){


			$datos = array("flota"=>strtoupper($_POST["nombreFlota"]),
						   "cliente"=>$_POST["idcliente"],
						   "estado"=> 1);
			$existe = ModeloFlotas::mdlMostrarFlotas("flota", "nombre", $_POST["nombreFlota"]);
			if ($existe) {
					echo'<script>

					swal({
						  type: "success",
						  title: "La Flota ya Existe",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "flota";

							}
						})

					</script>';
			}else{
					$respuesta = ModeloFlotas::mdlIngresarFlota("flota", $datos);

					if($respuesta == 1){

						echo'<script>

						swal({
							  type: "success",
							  title: "La Flota ha sido guardada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {

								window.location = "flota";

								}
							})

						</script>';

					}else{

					echo'<script>

						swal({
							  type: "error",
							  title: "¡La flota no puede ir vacía o llevar caracteres especiales!",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  })

				  	</script>';

				  	return;

				}
			}

		}
	}

	/*=============================================
	CREAR FLOTAS VEHICULOS
	=============================================*/

	static public function ctrCrearFlotaVehiculo($datos){

		if(isset($_POST["nombreFlota"])){


			$datos = array("flota"=>strtoupper($_POST["nombreFlota"]),
						   "cliente"=>$_POST["idcliente"],
						   "estado"=> 1);
			$existe = ModeloFlotas::mdlMostrarFlotas("flota", "nombre", $_POST["nombreFlota"]);
			if ($existe) {
					echo'<script>

					swal({
						  type: "success",
						  title: "La Flota ya Existe",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "flota";

							}
						})

					</script>';
			}else{
					$respuesta = ModeloFlotas::mdlIngresarFlota("flota", $datos);

					if($respuesta == 1){

						echo'<script>

						swal({
							  type: "success",
							  title: "La Flota ha sido guardada correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
								if (result.value) {

								window.location = "flota";

								}
							})

						</script>';

					}else{

					echo'<script>

						swal({
							  type: "error",
							  title: "¡La flota no puede ir vacía o llevar caracteres especiales!",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  })

				  	</script>';

				  	return;

				}
			}

		}
	}



	/*=============================================
	EDITAR FLOTAS
	=============================================*/

	static public function ctrEditarflota(){

		if(isset($_POST["editarNombreflota"])){

			$datos = array("id"=>$_POST["editarIdflota"],
						   "flota"=>strtoupper($_POST["editarNombreflota"]),
						   "cliente"=>$_POST["editarClienteflota"]
						);

			$respuesta = ModeloFlotas::mdlEditarflota("flota", $datos);


			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "La flota ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "flota";

						}
					})

				</script>';

			}
		}
	}


	/*=============================================
	ELIMINAR CATEGORIA
	=============================================*/

	static public function ctrEliminarflota(){

		if(isset($_GET["idflota"])){


			$respuesta = ModeloFlotas::mdlEliminarflota("flota", $_GET["idflota"]);


			if($respuesta == 1){

				echo'<script>
				swal({
					  type: "success",
					  title: "La flota ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "flota";

								}
							})

				</script>';
				
			}
			
		}

	}


}
