<?php

class ControladorPersona{

	/*=============================================
	MOSTRAR PERSONA
	=============================================*/

	static public function ctrMostrarPersona($item, $valor, $count){

		$tabla = "persona";

		$respuesta = ModeloPersona::mdlMostrarPersona($tabla, $item, $valor, $count);

		return $respuesta;

	}


	/*=============================================
	CREAR PERSONA
	=============================================*/

	static public function ctrGuardarPersona($datos){

		if(isset($datos["nombre"])){

			$tabla = "persona";

			$respuesta = ModeloPersona::mdlGuardarPersona($tabla, $datos);

			return $respuesta;

		}
	}

	/*=============================================
	EITAR PERSONA
	=============================================*/

	static public function ctrEditarPersona($datos){

		if(isset($datos["idPersona"])){

			$tabla = "persona";

			$respuesta = ModeloPersona::mdlEditarPersona($tabla, $datos);

			return $respuesta;

		}
	}


}