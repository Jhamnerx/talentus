<?php

require_once "conexion.php";

class ModeloFlotas{


	/*=============================================
	MOSTRAR FLOTAS
	=============================================*/

	static public function mdlMostrarFlotas($tabla, $item, $valor){

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
	ACTIVAR FLOTA
	=============================================*/

	static public function mdlActualizarFlota($tabla, $item1, $valor1, $item2, $valor2){

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
	CREAR FLOTA
	=============================================*/

	static public function mdlIngresarFlota($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, idcliente, estado) VALUES (:flota, :idcliente, :estado)");

		$stmt->bindParam(":flota", $datos["flota"], PDO::PARAM_STR);
		$stmt->bindParam(":idcliente", $datos["cliente"], PDO::PARAM_INT);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR FLOTA
	=============================================*/

	static public function mdlEditarFlota($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, idcliente = :idcliente WHERE id = :id");

		$stmt -> bindParam(":nombre", $datos["flota"], PDO::PARAM_STR);
		$stmt -> bindParam(":idcliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	ELIMINAR FLOTA
	=============================================*/

	static public function mdlEliminarFlota($tabla, $datos){

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
}

