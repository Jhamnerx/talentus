<?php

require_once "conexion.php";

class ModeloReportes{


	/*=============================================
	MOSTRAR Reportes
	=============================================*/

	static public function mdlMostrarReportes($tabla, $item, $valor){

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
	MOSTRAR DETALLE REPORTE
	=============================================*/

	static public function mdlMostrarDetalleReportes($tabla, $item, $valor){

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
	CAMBIAR ESTADO REPORTE
	=============================================*/

	static public function mdlActualizarReporte($tabla, $item1, $valor1, $item2, $valor2){

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
	CREAR Reporte
	=============================================*/

	static public function mdlIngresarReporte($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(vehiculo, fecha_t, hora_t, fecha, detalle, estado) VALUES (:vehiculo, :fecha_t, :hora_t, :fecha, :detalle, 0)");

		$stmt->bindParam(":vehiculo", $datos["vehiculo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_t", $datos["fecha_t"], PDO::PARAM_STR);
		$stmt->bindParam(":hora_t", $datos["hora_t"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	AGREGAR DETALLE REPORTE
	=============================================*/

	static public function mdlIngresarDetalleReporte($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(id_reporte, detalle) VALUES (:id_reporte, :detalle)");

		$stmt->bindParam(":id_reporte", $datos["id_reporte"], PDO::PARAM_STR);
		$stmt->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	EDITAR Reporte
	=============================================*/

	static public function mdlEditarReporte($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET vehiculo = :vehiculo, fecha_t = :fecha_t, hora_t = :hora_t, fecha = :fecha, detalle = :detalle WHERE id = :id");

		$stmt->bindParam(":vehiculo", $datos["vehiculo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_t", $datos["fecha_t"], PDO::PARAM_STR);
		$stmt->bindParam(":hora_t", $datos["hora_t"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":detalle", $datos["detalle"], PDO::PARAM_STR);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	ELIMINAR Reporte
	=============================================*/

	static public function mdlEliminarReporte($tabla, $datos){

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

