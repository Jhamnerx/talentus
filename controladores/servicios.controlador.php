<?php

class ControladorServicios{

	/*=============================================
	MOSTRAR Todos los Servicios
	=============================================*/

	static public function ctrMostrarServicios($item, $valor){

		$tabla = "servicios";

		$respuesta = ModeloServicios::mdlMostrarServicios($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR TOTAL PRODUCTOS
	=============================================*/

	static public function ctrMostrarTotalProductos($orden){

		$tabla = "servicios";

		$respuesta = ModeloServicios::mdlMostrarTotalProductos($tabla, $orden);

		return $respuesta;
	}

	/*=============================================
	MOSTRAR Articulos
	=============================================*/

	static public function ctrMostrarArticulos($item, $valor){

		$tabla = "servicios";

		$respuesta = ModeloServicios::mdlMostrarArticulos($tabla, $item, $valor);

		return $respuesta;

	}
	/*=============================================
	CREAR SERVICIO
	=============================================*/

	static public function ctrCrearServicio(){

		if(isset($_POST["nombreServicio"])){

			if ($_FILES["fotoServicio"]["tmp_name"] != "") {

				list($ancho, $alto) = getimagesize($_FILES["fotoServicio"]["tmp_name"]);

				if($_FILES["fotoServicio"]["type"] == "image/jpeg"){

					$ruta = "vistas/img/servicios/".$_POST["nombreServicio"]."/".$_POST["nombreServicio"].".jpg";

					if (!file_exists($ruta)) {		

						mkdir("vistas/img/servicios/".$_POST["nombreServicio"], 0700);
						
					}


					$origen = imagecreatefromjpeg($_FILES["fotoServicio"]["tmp_name"]);

					$destino = imagecreatetruecolor($ancho, $alto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $ancho, $alto, $ancho, $alto);

					imagejpeg($destino, $ruta);
				}

				if($_FILES["fotoServicio"]["type"] == "image/png"){

					$destino = imagecreatetruecolor($ancho, $alto);

					$ruta = "vistas/img/servicios/".$_POST["nombreServicio"]."/".$_POST["nombreServicio"].".png";

					if (!file_exists($ruta)) {		

						mkdir("vistas/img/servicios/".$_POST["nombreServicio"], 0700);
						
					}

					$origen = imagecreatefrompng($_FILES["fotoServicio"]["tmp_name"]);

					imagealphablending($destino, FALSE);

					imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $ancho, $alto, $ancho, $alto);


					imagepng($destino, $ruta);

				}


				$fotoServicio = $ruta;

			}else{

				$fotoServicio = "vistas/img/servicios/default/default.png";
			}

			


			if ($_POST["seleccionarTipo"] == "servicio") {

				$datos = array("nombre"=>strtoupper(trim($_POST["nombreServicio"])),
							   "categoria"=>$_POST["seleccionarCategoria"],
							   "tipo"=>$_POST["seleccionarTipo"],
							   "precio"=>$_POST["precioServicio"],
							   "stock"=>99999,
							   "descripcion"=>trim($_POST["descripcionServicio"]),
							   "imagen"=>$fotoServicio,
							   "estado"=> 1);

				}else{

			$datos = array("nombre"=>strtoupper(trim($_POST["nombreServicio"])),
						   "categoria"=>$_POST["seleccionarCategoria"],
						   "tipo"=>$_POST["seleccionarTipo"],
						   "precio"=>$_POST["precioServicio"],
						   "stock"=>$_POST["stockServicio"],
						   "descripcion"=>trim($_POST["descripcionServicio"]),
						   "imagen"=>$fotoServicio,
						   "estado"=> 1);

				}	



			$respuesta = ModeloServicios::mdlIngresarServicio("servicios", $datos);

			if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "El '.$_POST["seleccionarTipo"].' fue guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "servicios";

							}
						})

					</script>';

				}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El '.$_POST["seleccionarTipo"].' no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  })

			  	</script>';

			  	return;

			}


		}

	}


	/*=============================================
	EDITAR SERVICIO
	=============================================*/

	static public function ctrEditarServicio(){

		if(isset($_POST["editarIdServicio"])){

			if ($_FILES["fotoServicio"]["tmp_name"] != "") {

				list($ancho, $alto) = getimagesize($_FILES["fotoServicio"]["tmp_name"]);

				if($_FILES["fotoServicio"]["type"] == "image/jpeg"){

					$aleatorio = mt_rand(100,999);

					$ruta = "vistas/img/servicios/".$aleatorio."/".$aleatorio.".jpg";

					if (!file_exists($ruta)) {		

						mkdir("vistas/img/servicios/".$aleatorio, 0700);
						
					}


					$origen = imagecreatefromjpeg($_FILES["fotoServicio"]["tmp_name"]);

					$destino = imagecreatetruecolor($ancho, $alto);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $ancho, $alto, $ancho, $alto);

					imagejpeg($destino, $ruta);
				}

				if($_FILES["fotoServicio"]["type"] == "image/png"){

					$destino = imagecreatetruecolor($ancho, $alto);

					$ruta = "vistas/img/servicios/".$aleatorio."/".$aleatorio.".png";

					if (!file_exists($ruta)) {		

						mkdir("vistas/img/servicios/".$aleatorio, 0700);
						
					}

					$origen = imagecreatefrompng($_FILES["fotoServicio"]["tmp_name"]);

					imagealphablending($destino, FALSE);

					imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $ancho, $alto, $ancho, $alto);


					imagepng($destino, $ruta);

				}


				$fotoServicio = $ruta;

		}else{

			$fotoServicio = $_POST["antiguaFotoServicio"];
		}

			$datos = array("id"=>$_POST["editarIdServicio"],
						   "nombre"=>strtoupper(trim($_POST["editarNombreServicio"])),
						   "categoria"=>$_POST["seleccionarCategoria"],
						   "tipo"=>$_POST["seleccionarTipo"],
						   "precio"=>$_POST["editarprecioServicio"],
						   "stock"=>$_POST["editarstockServicio"],
						   "descripcion"=>trim($_POST["EditardescripcionServicio"]),
						   "imagen"=>$fotoServicio
						    );
			// echo json_encode($datos);
			// return;

			$respuesta = ModeloServicios::mdlEditarServicio("servicios", $datos);

			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "El '.$_POST["seleccionarTipo"].' ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "servicios";

						}
					})

				</script>';

			}
		}
	}
}