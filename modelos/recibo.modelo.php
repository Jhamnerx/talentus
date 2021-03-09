<?php

require_once "conexion.php";

class ModeloRecibos{


	/*=============================================
	MOSTRAR Recibos
	=============================================*/

	static public function mdlMostrarRecibos($tabla, $item, $valor, $cant = 0){

		if($item != null){

			if ($cant != 0) {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

				$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetchAll();


			}else{

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

				$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetch();

			}

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	MOSTRAR REPORTE Recibos
	=============================================*/

	static public function mdlMostrarReporteRecibos($tabla, $item, $fechaInicio, $fechaFin){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item >= '$fechaInicio' AND $item <= '$fechaFin'");


		$stmt -> execute();

		return $stmt -> fetchAll();


		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	DETALLE RECIBO
	=============================================*/

	static public function mdlDetalleRecibos($tabla, $item, $valor){


		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ANULAR RECIBO
	=============================================*/

	static public function mdlAnularRecibos($tabla, $item1, $valor1, $item2, $valor2){

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
	GUARDAR RECIBO
	=============================================*/

	static public function mdlGuardarRecibo($tabla, $datos){

		$dbh = Conexion::conectar();

		$stmt = $dbh->prepare("INSERT INTO $tabla(idcliente, empresa, num_recibo, tipoPago, total_recibo, divisa, fechaPago, fecha, estado) VALUES (:idcliente, :empresa, :num_recibo, :tipoPago, :total_recibo, :divisa, :fechaPago, :fecha, 1)");

		$stmt->bindParam(":idcliente", $datos["idcliente"], PDO::PARAM_INT);
		$stmt->bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);
		$stmt->bindParam(":num_recibo", $datos["num_recibo"], PDO::PARAM_STR);
		$stmt->bindParam(":tipoPago", $datos["tipoPago"], PDO::PARAM_STR);
		$stmt->bindParam(":total_recibo", $datos["total_recibo"], PDO::PARAM_STR);
		$stmt->bindParam(":divisa", $datos["divisa"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":fechaPago", $datos["fechaPago"], PDO::PARAM_STR);




		$stmt->execute();
		$id = $dbh->lastInsertId();
		return $id;

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	GUARDAR RECIBO DETALLE
	=============================================*/

	static public function mdlGuardarReciboDetalle($tabla, $datos){

		$num_elementos = 0;

		while ($num_elementos < count($datos["item"])){


			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idrecibo, item, cantidad, precio) VALUES (:idrecibo, :item, :cantidad, :precio)");

			$stmt->bindParam(":idrecibo", $datos["idrecibo"], PDO::PARAM_INT);
			$stmt->bindParam(":item", $datos["item"][$num_elementos], PDO::PARAM_STR);
			$stmt->bindParam(":cantidad", $datos["cantidad"][$num_elementos], PDO::PARAM_INT);
			$stmt->bindParam(":precio", $datos["precio"][$num_elementos], PDO::PARAM_STR);

			$stmt->execute();

			$num_elementos++;



		}
		return 1;
	}

	/*=============================================
	ELIMINAR RECIBO
	=============================================*/

	static public function mdlEliminarRecibo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return 1;

		}else{

			return 0;

		}

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	ELIMINAR DETALLE RECIBO
	=============================================*/
	static public function mdlEliminarDetalleRecibo($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE $item = :id");

		$stmt -> bindParam(":id", $valor, PDO::PARAM_INT);

		if($stmt -> execute()){

			return 1;

		}else{

			return 0;

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR RECIBO
	=============================================*/

	static public function mdlEditarRecibo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idcliente = :idcliente, empresa = :empresa, num_recibo = :num_recibo, tipoPago = :tipoPago, total_recibo = :total_recibo, divisa = :divisa, fechaPago = :fechaPago, fecha = :fecha WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt->bindParam(":idcliente", $datos["idcliente"], PDO::PARAM_INT);
		$stmt->bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);
		$stmt->bindParam(":num_recibo", $datos["num_recibo"], PDO::PARAM_STR);
		$stmt->bindParam(":tipoPago", $datos["tipoPago"], PDO::PARAM_STR);
		$stmt->bindParam(":total_recibo", $datos["total_recibo"], PDO::PARAM_STR);
		$stmt->bindParam(":divisa", $datos["divisa"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":fechaPago", $datos["fechaPagoEditar"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return 1;

		}else{

			return 0;

		}

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	ACTUALIZAR DETALLE RECIBO
	=============================================*/

	static public function mdlEditarReciboDetalle($tabla, $datos){

		$num_elementos = 0;

		while ($num_elementos < count($datos["item"])){


			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET item = :item, cantidad = :cantidad, precio = :precio WHERE id = :idDetalle");

			$stmt->bindParam(":idDetalle", $datos["idDetalle"][$num_elementos], PDO::PARAM_INT);
			$stmt->bindParam(":item", $datos["item"][$num_elementos], PDO::PARAM_STR);
			$stmt->bindParam(":cantidad", $datos["cantidad"][$num_elementos], PDO::PARAM_INT);
			$stmt->bindParam(":precio", $datos["precio"][$num_elementos], PDO::PARAM_STR);

			$stmt->execute();

			$num_elementos++;



		}
		return 1;
	}


	/*=============================================
	CAMBIAR ESTADO RECIBO
	=============================================*/

	static public function mdlActualizarRecibo($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

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
}
