<?php

require_once "conexion.php";

class ModeloVentas{


	/*=============================================
	MOSTRAR Ventas
	=============================================*/

	static public function mdlMostrarVentas($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		
		$stmt = null;
	
	}


	/*=============================================
	DETALLE VENTA
	=============================================*/

	static public function mdlDetalleVentas($tabla, $item, $valor){


		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		
		$stmt = null;
	
	}

	/*=============================================
	ANULAR VENTA
	=============================================*/

	static public function mdlAnularVentas($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item2 = :$item2 WHERE $item1 = :$item1");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return 1;
		
		}else{

			return 0;	

		}

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	GUARDAR VENTA
	=============================================*/

	static public function mdlGuardarVenta($tabla, $datos){	

		$dbh = Conexion::conectar();

		$stmt = $dbh->prepare("INSERT INTO $tabla(idcliente, idusuario, tipo_comprobante, serie_comprobante, num_comprobante, impuesto, total_venta, divisa, empresa, tipoPago, estado) VALUES (:idcliente, :idusuario, :tipo_comprobante, :serie_comprobante, :num_comprobante, :impuesto, :total_venta, :divisa, :empresa, :tipoPago, 1)");

		$stmt->bindParam(":idcliente", $datos["cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":idusuario", $datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);
		$stmt->bindParam(":tipoPago", $datos["tipoPago"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_comprobante", $datos["tipo_comprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":divisa", $datos["divisa_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":serie_comprobante", $datos["serie_comprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":num_comprobante", $datos["numero_comprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto_venta"], PDO::PARAM_STR);
		$stmt->bindParam(":total_venta", $datos["total_venta"], PDO::PARAM_STR);

		

		$stmt->execute();
		$id = $dbh->lastInsertId();
		return $id;

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	GUARDAR venta DETALLE
	=============================================*/

	static public function mdlGuardarVentaDetalle($tabla, $datos){
		
		$num_elementos = 0;

		while ($num_elementos < count($datos["idarticulo"])){


			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idventa, idarticulo, cantidad, precio_venta, descuento) VALUES (:idventa, :idarticulo, :cantidad, :precio_venta, :descuento)");

			$stmt->bindParam(":idventa", $datos["idventa"], PDO::PARAM_INT);
			$stmt->bindParam(":idarticulo", $datos["idarticulo"][$num_elementos], PDO::PARAM_INT);
			$stmt->bindParam(":cantidad", $datos["cantidad"][$num_elementos], PDO::PARAM_INT);
			$stmt->bindParam(":precio_venta", $datos["precio_venta"][$num_elementos], PDO::PARAM_INT);
			$stmt->bindParam(":descuento", $datos["descuento"][$num_elementos], PDO::PARAM_INT);

			$stmt->execute();

			$num_elementos++;

			

		}
		return 1;
	}


	static public function mdlIngresarCobro($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(empresa,estado,fechaVen, periodo, montoxunidad, cantidadUnidades, ciudad, tipoPago, observacion) VALUES (:empresa, :estado, :fechaVencimiento, :periodo, :monto, :cantidadunidad, :ciudad, :tipoPago, :observacion)");


		$stmt->bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":fechaVencimiento", $datos["fechaVencimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":periodo", $datos["periodo"], PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidadunidad", $datos["cantidadunidad"], PDO::PARAM_INT);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_INT);
		$stmt->bindParam(":tipoPago", $datos["tipoPago"], PDO::PARAM_STR);
		$stmt->bindParam(":observacion", $datos["observacion"], PDO::PARAM_STR);
		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}}
