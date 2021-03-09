<?php

require_once "conexion.php";

class ModeloTarea{


	/*=============================================
	MOSTRAR TAREAS
	=============================================*/

	static public function mdlMostrarTareas($tabla, $item, $valor){

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


	static public function mdlMostrarTipoTarea($tabla, $item, $valor){

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
	ACTUALIZAR TAREA A LEIDA
	=============================================*/

	static public function mdlActualizarTarea($tabla, $item1, $valor1, $item2, $valor2){

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
	CREAR TAREA
	=============================================*/

	static public function mdlCrearTarea($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_empleado, id_admin, tipo, vehiculo, sim, sim_card, nuevo_sim, nuevo_card, dispositivo ,cliente, leido, estado, fecha, hora) VALUES (10, :id_admin, :tipo, :vehiculo, :sim, :sim_card, :nuevo_sim, :nuevo_card, :dispositivo, :cliente, 0, 1, :fecha, :hora)");

		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":id_admin", $datos["id_admin"], PDO::PARAM_STR);
		$stmt->bindParam(":vehiculo", $datos["vehiculo"], PDO::PARAM_STR);
		$stmt->bindParam(":sim", $datos["sim"], PDO::PARAM_STR);
		$stmt->bindParam(":sim_card", $datos["sim_card"], PDO::PARAM_STR);
		$stmt->bindParam(":nuevo_sim", $datos["nuevo_sim"], PDO::PARAM_STR);
		$stmt->bindParam(":nuevo_card", $datos["nuevo_card"], PDO::PARAM_STR);
		$stmt->bindParam(":cliente", $datos["cliente"], PDO::PARAM_STR);
		$stmt->bindParam(":dispositivo", $datos["dispositivo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":hora", $datos["hora"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	CREAR TAREA
	=============================================*/

	static public function mdlCrearTipoTarea($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(tipo, costo) VALUES (:tipo, :costo)");

		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":costo", $datos["costo"], PDO::PARAM_STR);
		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	EDITAR TAREA
	=============================================*/

	static public function mdlEditarTarea($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET categoria = :categoria WHERE id = :id");

		$stmt -> bindParam(":categoria", $datos["categoria"], PDO::PARAM_STR);


		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	ELIMINAR TAREA
	=============================================*/

	static public function mdlEliminarTarea($tabla, $datos){

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

