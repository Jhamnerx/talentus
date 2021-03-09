<?php

require_once "conexion.php";

class ModeloLineas{


	/*=============================================
	MOSTRAR Lineas
	=============================================*/

	static public function mdlMostrarLineas($tabla, $item, $valor){

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
	CAMBIAR ESTADO LINEA
	=============================================*/

	static public function mdlActualizarLinea($tabla, $item1, $valor1, $item2, $valor2){

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
	REGISTRAR LINEA
	=============================================*/

	static public function mdlIngresarLinea($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(numero, sim_card, placa, empresa, estado) VALUES (:numero, :sim_card, :placa, :empresa, 1)");

		$stmt->bindParam(":numero", $datos["numero"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_card", $datos["sim_card"], PDO::PARAM_STR);
		$stmt->bindParam(":placa", $datos["placa"], PDO::PARAM_STR);
		$stmt->bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR LINEA
	=============================================*/

	static public function mdlEditarLinea($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET numero = :numero, sim_card = :sim_card, placa = :placa, empresa= :empresa WHERE id = :id");

		$stmt->bindParam(":numero", $datos["numero"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_card", $datos["sim_card"], PDO::PARAM_STR);
		$stmt->bindParam(":placa", $datos["placa"], PDO::PARAM_STR);
		$stmt->bindParam(":empresa", $datos["empresa"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	ELIMINAR LINEA
	=============================================*/

	static public function mdlEliminarLinea($tabla, $datos){

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

