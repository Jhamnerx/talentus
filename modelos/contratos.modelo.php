<?php 
require_once 'conexion.php';

/**
 * 
 */
class ModeloContratos{

	/*=============================================
	MOSTRAR CONTRATOS
	=============================================*/

	static public function mdlMostrarContratos($tabla, $item, $valor, $mod){

		/**
		 * MOD = 0  || MOSTRAR VARIAS FILA S
		 * MOD = 1  || MOSTRAR 1 FILA 
		 * MOD = 2  || MOSTRAR TODAS LAS FILAS
		 */

		if ($mod == 1){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}

		if ($mod == 0){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY id DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		if ($mod == 2) {
			
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY id DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();
		
		$stmt = null;


	}


	/*=============================================
	ACTUAALIZAR CONTRATO
	=============================================*/

	static public function mdlActualizarContrato($tabla, $item1, $valor1, $item2, $valor2){

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
	EDITAR CONTRATO
	=============================================*/

	static public function mdlEditarContrato($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha = :fecha, ciudad = :ciudad WHERE id = :id");

		$stmt -> bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt -> bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
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
	GUARDAR CONTRATO
	=============================================*/

	static public function mdlGuardarContrato($tabla, $datos){	

		$dbh = Conexion::conectar();

		$stmt = $dbh->prepare("INSERT INTO $tabla(idcliente, ciudad, plan, fecha, fondo, sello, estado) VALUES (:idcliente, :ciudad, 50, :fecha, :fondo, :sello, 1)");

		$stmt->bindParam(":idcliente", $datos["idcliente"], PDO::PARAM_STR);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		//$stmt->bindParam(":plan", $datos["planContrato"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fechaContrato"], PDO::PARAM_STR);
		$stmt->bindParam(":fondo", $datos["fondo"], PDO::PARAM_STR);
		$stmt->bindParam(":sello", $datos["sello"], PDO::PARAM_STR);


		

		$stmt->execute();
		$id = $dbh->lastInsertId();
		return $id;

		$stmt->close();
		$stmt = null;
	}

	/*=============================================
	GUARDAR DETALLE
	=============================================*/

	static public function mdlGuardarContratoDetalle($tabla, $datos){
		
		$num_elementos = 0;

		while ($num_elementos < count($datos["idvehiculo"])){


			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idcontrato, idvehiculo, plan) VALUES (:idcontrato, :idvehiculo, :plan)");

			$stmt->bindParam(":idcontrato", $datos["idcontrato"], PDO::PARAM_INT);
			$stmt->bindParam(":idvehiculo", $datos["idvehiculo"][$num_elementos], PDO::PARAM_INT);
			$stmt->bindParam(":plan", $datos["plan"][$num_elementos], PDO::PARAM_INT);

			$stmt->execute();

			$num_elementos++;

			

		}
		return 1;
	}	
	/*=============================================
	ELIMINAR DETALLE CONTRATO
	=============================================*/

	static public function mdlEliminarDetalleContrato($tabla, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $valor, PDO::PARAM_INT);

		if($stmt -> execute()){

			return 1;
		
		}else{

			return 0;	

		}

		$stmt -> close();

		$stmt = null;

	}


	static public function mdlEliminarContrato($tabla, $valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $valor, PDO::PARAM_INT);

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