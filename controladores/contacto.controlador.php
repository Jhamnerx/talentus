<?php

class ControladorContacto{

	/*=============================================
	MOSTRAR CONTACTO
	=============================================*/

	static public function ctrMostrarContacto($item, $valor){

		$tabla = "contacto";

		$respuesta = ModeloContacto::mdlMostrarContacto($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR CONTACTO
	=============================================*/

	static public function ctrCrearContacto(){

		if(isset($_POST["nombreContacto"])){
			$datos = array("nombre"=>trim(strtoupper($_POST["nombreContacto"])),
						   "flota"=>trim($_POST["flota"]),
						   "telefono"=>trim($_POST["telefonoContacto"]),
						   "email"=> trim($_POST["emailContacto"]));

			$respuesta = ModeloContacto::mdlIngresarContacto("contacto", $datos);

				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "El Contacto ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "contacto";

							}
						})

					</script>';

				}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡Los datos no pueden ir vacíos o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  })

			  	</script>';

			  	return;

			}
		}
	}



	/*=============================================
	EDITAR CONTACTO
	=============================================*/

	static public function ctrEditarContacto(){

		if(isset($_POST["editarNombreContacto"])){

			$datos = array("nombre"=>trim(strtoupper($_POST["editarNombreContacto"])),
						   "idContacto"=>trim($_POST["editarIdContacto"]),
						   "flota"=>trim($_POST["flota"]),
						   "telefono"=>trim($_POST["telefonoContacto"]),
						   "email"=> trim($_POST["emailContacto"]));


			$respuesta = ModeloContacto::mdlEditarContacto("contacto", $datos);


			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "El contacto ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "contacto";

						}
					})

				</script>';

			}
		}
	}



}
