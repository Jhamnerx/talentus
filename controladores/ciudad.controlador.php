<?php

class ControladorCiudad{

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarCiudad($item, $valor){

		$tabla = "ciudad";

		$respuesta = ModeloCiudad::mdlMostrarCiudad($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearCiudad(){

		if(isset($_POST["nombreCiudad"])){
			$datos = array("nombre"=>trim(strtoupper($_POST["nombreCiudad"])),
						   "prefijo"=>trim($_POST["prefijoCiudad"]),
						   "estado"=> 1);

			$respuesta = ModeloCiudad::mdlIngresarCiudad("ciudad", $datos);

				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "La Ciudad ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "ciudad";

							}
						})

					</script>';

				}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  })

			  	</script>';

			  	return;

			}
		}
	}



	/*=============================================
	EDITAR CIUDAD
	=============================================*/

	static public function ctrEditarCiudad(){

		if(isset($_POST["editarNombreCiudad"])){

			$datos = array("id"=>$_POST["editarIdCiudad"],
						   "nombre"=>strtoupper($_POST["editarNombreCiudad"]),
						   "prefijo"=>$_POST["editarPrefijoCiudad"]
						);

			$respuesta = ModeloCiudad::mdlEditarCiudad("ciudad", $datos);


			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "La Ciudad ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "ciudad";

						}
					})

				</script>';

			}
		}
	}




}
