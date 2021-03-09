<?php

require_once "conexion.php";

class ModeloCobros{


	/*=============================================
	MOSTRAR COBROS
	=============================================*/

	static public function mdlMostrarCobros($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fechaVen DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		
		$stmt = null;
	
	}

	/*=============================================
	MOSTRAR REGISTRO COBROS
	=============================================*/

	static public function mdlMostrarRegistroCobro($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		
		$stmt = null;
	
	}
	/*=============================================
	ALTERNAR ESTADO
	=============================================*/

	static public function mdlActualizarCobro($tabla, $item1, $valor1, $item2, $valor2){

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

	/*=============================================
	CREAR REGISTRO
	=============================================*/

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

	}


	/*=============================================
	EDITAR REGISTRO
	=============================================*/

	static public function mdlEditarCobro($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET empresa = :empresa, fechaVen = :fechaVencimiento, periodo = :periodo, 	montoxunidad = :monto, cantidadUnidades = :cantidadunidad, ciudad = :ciudad, tipoPago = :tipoPago, observacion = :observacion WHERE id = :id");


		$stmt->bindParam(":id", $datos["idCobro"], PDO::PARAM_INT);
		$stmt->bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);
		$stmt->bindParam(":fechaVencimiento", $datos["fechaVencimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":periodo", $datos["periodo"], PDO::PARAM_STR);
		$stmt->bindParam(":monto", $datos["monto"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidadunidad", $datos["cantidadunidad"], PDO::PARAM_STR);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt->bindParam(":tipoPago", $datos["tipoPago"], PDO::PARAM_STR);
		$stmt->bindParam(":observacion", $datos["observacion"], PDO::PARAM_STR);

		if($stmt->execute()){

			return $stmt;

		}else{

			return $stmt;
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	PAGAR REGISTRO COBRO
	=============================================*/

	static public function mdlPagarCobro($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado= :estado, fechaVen = :fechaVencimiento, tipoPago = :tipoPago WHERE id = :id");


		$stmt->bindParam(":id", $datos["idCobro"], PDO::PARAM_INT);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt->bindParam(":tipoPago", $datos["tipoPago"], PDO::PARAM_STR);
		$stmt->bindParam(":fechaVencimiento", $datos["fechaVencimiento"], PDO::PARAM_STR);

		if($stmt->execute()){

			return $stmt;

		}else{

			return $stmt;
		
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	CREAR REGISTRO COBRO PAGO
	=============================================*/

	static public function mdlCrearRegistroPago($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idcobro, tipo_pago, cantidad, descripcion) VALUES(:idCobro, :tipoPago, :cantidad, :descripcion)");


		$stmt->bindParam(":idCobro", $datos["idCobro"], PDO::PARAM_STR);
		$stmt->bindParam(":tipoPago", $datos["tipoPago"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad", $datos["cantidad"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);

		if($stmt->execute()){

			return $stmt;

		}else{

			return $stmt;
		
		}

		$stmt->close();
		$stmt = null;

	}
}

