<?php

require_once "conexion.php";

class ModeloPersona{


	/*=============================================
	MOSTRAR Persona
	=============================================*/

	static public function mdlMostrarPersona($tabla, $item, $valor, $count){

		if($count == 1){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}
		if ($count == 0){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		
		$stmt = null;
	
	}

	/*=============================================
	ACTIVAR PERSONA
	=============================================*/

	static public function mdlActualizarPersona($tabla, $item1, $valor1, $item2, $valor2){

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
	CREAR PERSONA
	=============================================*/

	static public function mdlGuardarPersona($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(tipo, nombre, apellido, tipo_documento, num_documento, direccion, telefono, email) VALUES (:tipo, :nombre, :apellido, :tipo_documento, :num_documento, :direccion, :telefono, :email)");

		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":num_documento", $datos["num_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;
	}



	/*=============================================
	EDITAR PERSONA
	=============================================*/

	static public function mdlEditarPersona($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET tipo = :tipo, nombre = :nombre, apellido = :apellido, tipo_documento = :tipo_documento, num_documento = :num_documento, direccion = :direccion, telefono = :telefono, email = :email WHERE id = :idPersona");

		$stmt->bindParam(":idPersona", $datos["idPersona"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":num_documento", $datos["num_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;
	}

}