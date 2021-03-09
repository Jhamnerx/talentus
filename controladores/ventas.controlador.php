<?php
class ControladorVentas{

	/*=============================================
	MOSTRAR Ventas
	=============================================*/

	static public function ctrMostrarVentas($item, $valor){

		$tabla = "venta";

		$respuesta = ModeloVentas::mdlMostrarVentas($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	DETALLE VENTA
	=============================================*/

	static public function ctrDetalleVentas($item, $valor){

		$tabla = "detalle_venta";

		$respuesta = ModeloVentas::mdlDetalleVentas($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	GUARDAR VENTA
	=============================================*/

	static public function ctrGuardarVenta($datos){

		$tabla = "venta";
	    $datosCobro = array(
	        'empresa' =>$datos["cliente"],
	        'estado' =>"2",
	        'fechaVencimiento'=>"12-03-2021",
	        'periodo'=>"mensual",
	        'monto'=>$datos["total_venta"],
	        'cantidadunidad'=>0,
	        'ciudad'=>2,
	        'tipoPago'=>$datos["tipoPago"],
	        'observacion'=>""
	        );
	    
	    ModeloVentas::mdlIngresarCobro("cobros", $datosCobro);


		$respuesta = ModeloVentas::mdlGuardarVenta($tabla, $datos);

		if ($respuesta != null) {

			$datos1 = array("idarticulo"=>$datos["idarticulo"],
					"cantidad"=>$datos["cantidad"],
					"idventa"=>$respuesta,
					"descuento"=>$datos["descuento"],
					"precio_venta"=>$datos["precio_venta"]
					);

			$tabla1 = "detalle_venta";

			$respuesta1 =  ModeloVentas::mdlGuardarVentaDetalle($tabla1, $datos1);
			return $respuesta1;
		}

		
	}
}
