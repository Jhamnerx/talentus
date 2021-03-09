<?php

require_once "conexion.php";

class ModeloIngresos{


	/*=============================================
	MOSTRAR Ingresos
	=============================================*/

	static public function mdlMostrarIngresos($tabla, $item, $valor){

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
	DETALLE INGRESO
	=============================================*/

	static public function mdlDetalleIngresos($tabla, $item, $valor){


		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		

		$stmt -> close();
		
		$stmt = null;
	
	}

	/*=============================================
	ANULAR INGRESO
	=============================================*/

	static public function mdlAnularIngresos($tabla, $item1, $valor1, $item2, $valor2){

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
	GUARDAR INGRESO
	=============================================*/

	static public function mdlGuardarIngreso($tabla, $datos){	

		$dbh = Conexion::conectar();

		$stmt = $dbh->prepare("INSERT INTO $tabla(idproveedor, idusuario, tipo_comprobante, serie_comprobante, num_comprobante, fecha_hora, impuesto, total_compra, divisa) VALUES (:idproveedor, :idusuario, :tipo_comprobante, :serie_comprobante, :num_comprobante, :fecha_hora, :impuesto, :total_compra, :divisa)");

		$stmt->bindParam(":idproveedor", $datos["proveedor"], PDO::PARAM_INT);
		$stmt->bindParam(":idusuario", $datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha_hora", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_comprobante", $datos["tipo_comprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":divisa", $datos["divisa_ingreso"], PDO::PARAM_STR);
		$stmt->bindParam(":serie_comprobante", $datos["serie_comprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":num_comprobante", $datos["numero_comprobante"], PDO::PARAM_STR);
		$stmt->bindParam(":impuesto", $datos["impuesto_ingreso"], PDO::PARAM_INT);
		$stmt->bindParam(":total_compra", $datos["total_compra"], PDO::PARAM_INT);

		

		$stmt->execute();
		$id = $dbh->lastInsertId();
		return $id;

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	GUARDAR INGRESO DETALLE
	=============================================*/

	static public function mdlGuardarIngresoDetalle($tabla, $datos){
		
		$num_elementos = 0;

		while ($num_elementos < count($datos["idarticulo"])){


			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idingreso, idarticulo, cantidad, precio_compra, precio_venta) VALUES (:idingreso, :idarticulo, :cantidad, :precio_compra, :precio_venta)");

			$stmt->bindParam(":idingreso", $datos["idingreso"], PDO::PARAM_INT);
			$stmt->bindParam(":idarticulo", $datos["idarticulo"][$num_elementos], PDO::PARAM_INT);
			$stmt->bindParam(":cantidad", $datos["cantidad"][$num_elementos], PDO::PARAM_INT);
			$stmt->bindParam(":precio_compra", $datos["precio_compra"][$num_elementos], PDO::PARAM_INT);
			$stmt->bindParam(":precio_venta", $datos["precio_venta"][$num_elementos], PDO::PARAM_INT);

			$stmt->execute();

			$num_elementos++;

			

		}
		return 1;
	}
}
