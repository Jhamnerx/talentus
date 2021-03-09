<?php
ini_set('memory_limit', '-1');

class ControladorPlantilla{

	public function plantilla(){

		include "vistas/plantilla.php";

	}

	/*=============================================
	SELECCIONAR PLANTILLA
	=============================================*/

	static public function ctrSeleccionarPlantilla(){

		$tabla = "plantilla";

		$respuesta = ModeloPlantilla::mdlSeleccionarPlantilla($tabla);

		return $respuesta;

	}
	/*=============================================
	SELECCIONAR CUIDADES
	=============================================*/

	static public function ctrSeleccionarCiudad(){

		$tabla = "ciudad";

		$respuesta = ModeloPlantilla::mdlPlantilla($tabla);

		return $respuesta;

	}
	/*=============================================
	ACTUALIZAR LOGO O ICONO
	=============================================*/

	static public function ctrActualizarLogoIcono($item, $valor){

		$tabla = "plantilla";
		$id = 1;

		$plantilla = ModeloPlantilla::mdlSeleccionarPlantilla($tabla);

		/*=============================================
		CAMBIANDO LOGOTIPO O ICONO
		=============================================*/	

		$valorNuevo = $valor;

		if(isset($valor["tmp_name"])){

			list($ancho, $alto) = getimagesize($valor["tmp_name"]);

			/*=============================================
			CAMBIANDO LOGOTIPO
			=============================================*/	

			if($item == "logo"){

				unlink("../".$plantilla["logo"]);

				$nuevoAncho = 1200;
				$nuevoAlto = 350;

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				if($valor["type"] == "image/jpeg"){

					$ruta = "../vistas/img/plantilla/logo.jpg";

					$origen = imagecreatefromjpeg($valor["tmp_name"]);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);

				}

				if($valor["type"] == "image/png"){

					$ruta = "../vistas/img/plantilla/logo.png";

					$origen = imagecreatefrompng($valor["tmp_name"]);

					imagealphablending($destino, FALSE);

					imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);

				}

			}

			/*=============================================
			CAMBIANDO ICONO
			=============================================*/	

			if($item == "icono"){

				unlink("../".$plantilla["icono"]);

				$nuevoAncho = 282;
				$nuevoAlto = 282;

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				if($valor["type"] == "image/jpeg"){

					$ruta = "../vistas/img/plantilla/icono.jpg";

					$origen = imagecreatefromjpeg($valor["tmp_name"]);					

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);
			
				}

				if($valor["type"] == "image/png"){

					$ruta = "../vistas/img/plantilla/icono.png";

					$origen = imagecreatefrompng($valor["tmp_name"]);

					imagealphablending($destino, FALSE);
        			
        			imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);
			
				}

			}

			/*=============================================
			CAMBIANDO FONDO LOGIN
			=============================================*/	

			if($item == "fondoLogin"){

				unlink("../".$plantilla["fondoLogin"]);

				$nuevoAncho = 850;
				$nuevoAlto = 1080;

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				if($valor["type"] == "image/jpeg"){

					$ruta = "../vistas/img/plantilla/fondoLogin.jpg";

					$origen = imagecreatefromjpeg($valor["tmp_name"]);					

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);
			
				}

				if($valor["type"] == "image/png"){

					$ruta = "../vistas/img/plantilla/fondoLogin.png";

					$origen = imagecreatefrompng($valor["tmp_name"]);

					imagealphablending($destino, FALSE);
        			
        			imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);
			
				}

			}


			/*=============================================
			CAMBIANDO FONDO CONTRATO
			=============================================*/	

			if($item == "fondoContrato"){

				unlink("../".$plantilla["fondoContrato"]);

				$nuevoAncho = 2480;
				$nuevoAlto = 3508;

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				if($valor["type"] == "image/jpeg"){

					$ruta = "../vistas/img/plantilla/fondoContrato.jpg";

					$origen = imagecreatefromjpeg($valor["tmp_name"]);					

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);
			
				}

				if($valor["type"] == "image/png"){

					$ruta = "../vistas/img/plantilla/fondoContrato.png";

					$origen = imagecreatefrompng($valor["tmp_name"]);

					imagealphablending($destino, FALSE);
        			
        			imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);
			
				}

			}

			/*=============================================
			CAMBIANDO FONDO ACTA
			=============================================*/	

			if($item == "fondoActa"){

				unlink("../".$plantilla["fondoActa"]);

				$nuevoAncho = 2480;
				$nuevoAlto = 3508;

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				if($valor["type"] == "image/jpeg"){

					$ruta = "../vistas/img/plantilla/fondoActa.jpg";

					$origen = imagecreatefromjpeg($valor["tmp_name"]);					

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);
			
				}

				if($valor["type"] == "image/png"){

					$ruta = "../vistas/img/plantilla/fondoActa.png";

					$origen = imagecreatefrompng($valor["tmp_name"]);

					imagealphablending($destino, FALSE);
        			
        			imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);
			
				}

			}
			/*=============================================
			CAMBIANDO FONDO CERTIFICADO
			=============================================*/	

			if($item == "fondoCertificado"){

				unlink("../".$plantilla["fondoCertificado"]);

				$nuevoAncho = 2480;
				$nuevoAlto = 3508;

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				if($valor["type"] == "image/jpeg"){

					$ruta = "../vistas/img/plantilla/fondoCertificado.jpg";

					$origen = imagecreatefromjpeg($valor["tmp_name"]);					

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);
			
				}

				if($valor["type"] == "image/png"){

					$ruta = "../vistas/img/plantilla/fondoCertificado.png";

					$origen = imagecreatefrompng($valor["tmp_name"]);

					imagealphablending($destino, FALSE);
        			
        			imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);
			
				}

			}


			//FIRMA
			/*=============================================
			CAMBIANDO FONDO FIRMA
			=============================================*/	

			if($item == "fondoFirma"){

				unlink("../".$plantilla["fondoFirma"]);

				$nuevoAncho = 500;
				$nuevoAlto = 230;

				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

				if($valor["type"] == "image/jpeg"){

					$ruta = "../vistas/img/plantilla/fondoFirma.jpg";

					$origen = imagecreatefromjpeg($valor["tmp_name"]);					

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagejpeg($destino, $ruta);
			
				}

				if($valor["type"] == "image/png"){

					$ruta = "../vistas/img/plantilla/fondoFirma.png";

					$origen = imagecreatefrompng($valor["tmp_name"]);

					imagealphablending($destino, FALSE);
        			
        			imagesavealpha($destino, TRUE);

					imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

					imagepng($destino, $ruta);
			
				}

			}



			$valorNuevo = substr($ruta, 3);

		}

		$respuesta = ModeloPlantilla::mdlActualizarLogoIcono($tabla, $id, $item, $valorNuevo);

		return $respuesta;

	}

	/*=============================================
	ACTUALIZAR COLORES
	=============================================*/

	static public function ctrActualizarColores($datos){

		$tabla = "plantilla";
		$id = 1;

		$respuesta = ModeloPlantilla::mdlActualizarColores($tabla, $id, $datos);

		return $respuesta;


	}

	/*=============================================
	ACTUALIZAR SCRIPT
	=============================================*/

	static public function ctrActualizarScript($datos){

		$tabla = "plantilla";
		$id = 1;

		$respuesta = ModeloPlantilla::mdlActualizarScript($tabla, $id, $datos);

		return $respuesta;


	}

	/*=============================================
	SELECCIONAR COMERCIO
	=============================================*/

	static public function ctrSeleccionarComercio(){

		$tabla = "comercio";

		$respuesta = ModeloPlantilla::mdlSeleccionarComercio($tabla);

		return $respuesta;

	}

	/*=============================================
	ACTUALIZAR INFORMACION
	=============================================*/

	static public function ctrActualizarInformacion($datos){

		$tabla = "plantilla";
		$id = 1;

		$respuesta = ModeloPlantilla::mdlActualizarInformacion($tabla, $id, $datos);

		return $respuesta;


	}



	/*=============================================
	ACTUALIZAR INFORMACION EMPRESA
	=============================================*/

	static public function ctrActualizarEmpresa($item, $valor){

		$tabla = "plantilla";
		$id = 1;

		$respuesta = ModeloPlantilla::mdlActualizarEmpresa($tabla, $id, $item, $valor);

		return $respuesta;


	}
}

