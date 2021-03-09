<?php

class ControladorIngresos{

	/*=============================================
	MOSTRAR Ingresos
	=============================================*/

	static public function ctrMostrarIngresos($item, $valor){

		$tabla = "ingreso";

		$respuesta = ModeloIngresos::mdlMostrarIngresos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	DETALLE INGRESO
	=============================================*/

	static public function ctrDetalleIngresos($item, $valor){

		$tabla = "detalle_ingreso";

		$respuesta = ModeloIngresos::mdlDetalleIngresos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	GUARDAR INGRESO
	=============================================*/

	static public function ctrGuardarIngreso($datos){

		$tabla = "ingreso";

		$respuesta = ModeloIngresos::mdlGuardarIngreso($tabla, $datos);

		if ($respuesta != null) {
			
			$datos1 = array("idarticulo"=>$datos["idarticulo"],
					"cantidad"=>$datos["cantidad"],
					"idingreso"=>$respuesta,
					"precio_compra"=>$datos["precio_compra"],
					"precio_venta"=>$datos["precio_venta"]
					);

			$tabla1 = "detalle_ingreso";

			$respuesta1 =  ModeloIngresos::mdlGuardarIngresoDetalle($tabla1, $datos1);

			return $respuesta1;
		}

	}
}
