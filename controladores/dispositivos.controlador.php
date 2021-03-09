<?php

class ControladorDispositivos{

	/*=============================================
	MOSTRAR DISPOSITIVOS
	=============================================*/

	static public function ctrMostrarDispositivos($item, $valor){

		$tabla = "dispositivos";

		$respuesta = ModeloDispositivos::mdlMostrarDispositivos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR DISPOSITIVOS
	=============================================*/

	static public function ctrCrearDispositivo(){

		if(isset($_POST["modelo"])){
			$datos = array("modelo"=>trim(strtoupper($_POST["modelo"])),
						   "marca"=>trim($_POST["marca"]),
						   "codeHomologacion"=> trim($_POST["codeHomologacion"]));

			$respuesta = ModeloDispositivos::mdlIngresarDispositivo("dispositivos", $datos);

				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "La Dispositivo ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "dispositivos";

							}
						})

					</script>';

				}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La Dispositivo no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  })

			  	</script>';

			  	return;

			}
		}
	}



	/*=============================================
	EDITAR DISPOSITIVOS
	=============================================*/

	static public function ctrEditarDispositivo(){

		if(isset($_POST["editarIdDispositivo"])){

			$datos = array("id"=>$_POST["editarIdDispositivo"],
						   "modelo"=>$_POST["editarmodelo"],
						   "marca"=>$_POST["editarmarca"],
						   "certificado"=>$_POST["editarcodeHomologacion"]
						);

			$respuesta = ModeloDispositivos::mdlEditarDispositivo("dispositivos", $datos);


			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "Dispositivo ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "dispositivos";

						}
					})

				</script>';

			}
		}
	}



}
