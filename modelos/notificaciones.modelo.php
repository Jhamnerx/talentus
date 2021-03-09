<?php 

require_once "conexion.php";


class ModeloNotificaciones{



	/*=============================================
	MOSTRAR NOTIFICACIONES
	=============================================*/

	static public function mdlMostrarNotificaciones($tabla, $item, $valor){


		if ($item != null) {
			
			$stmt = Conexion::Conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt->fetch();


		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY descripcion DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		
		$stmt = null;

	}


	/*=============================================
	AÑADIR NOTIFICACION
	=============================================*/

	static public function mdlIngresarNotificacion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(tipo, descripcion, idCobro, autor, estado) VALUES (:tipo, :descripcion, :idCobro, :autor, :estado)");

		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":idCobro", $datos["idCobro"], PDO::PARAM_STR);
		$stmt->bindParam(":autor", $datos["autor"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	ALTERNAR ESTADO NOTIFACIONES
	=============================================*/

	static public function mdlActualizarNotificacion($tabla, $item1, $valor1, $item2, $valor2){

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
	ELIMINAR notificacion
	=============================================*/

	static public function mdlEliminarNotificacion($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idCobro = :id");

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





 ?>