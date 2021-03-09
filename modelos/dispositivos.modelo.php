<?php

require_once "conexion.php";

class ModeloDispositivos{


	/*=============================================
	MOSTRAR DISPOSITIVOS
	=============================================*/

	static public function mdlMostrarDispositivos($tabla, $item, $valor){

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
	ACTIVAR CATEGORIA
	=============================================*/

	static public function mdlActualizarDispositivo($tabla, $item1, $valor1, $item2, $valor2){

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
	CREAR CATEGORIA
	=============================================*/

	static public function mdlIngresarDispositivo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(modelo, marca, certificado) VALUES (:modelo, :marca, :certificado)");

		$stmt->bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
		$stmt->bindParam(":marca", $datos["marca"], PDO::PARAM_STR);
		$stmt->bindParam(":certificado", $datos["codeHomologacion"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR CATEGORIA
	=============================================*/

	static public function mdlEditarDispositivo($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET modelo = :modelo, marca = :marca, certificado = :certificado WHERE id = :id");

		$stmt -> bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
		$stmt -> bindParam(":certificado", $datos["certificado"], PDO::PARAM_STR);
		$stmt -> bindParam(":marca", $datos["marca"], PDO::PARAM_STR);
		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

}

