<?php

require_once "conexion.php";

class ModeloCertificados{


	/*=============================================
	MOSTRAR Todos Certificado
	=============================================*/

	static public function mdlMostrarCertificado($tabla, $item, $valor){

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
	CREAR ACTA
	=============================================*/

	static public function mdlCrearCertificado($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(num_certificado, idcliente, modelo_gps, idvehiculo, fin_cobertura, fecha, ciudad, year, sello, fondo, estado) VALUES (:num_certificado, :idcliente,:modelo_gps, :idvehiculo, :fin_cobertura, :fecha, :ciudad, :year, :sello, :fondo, 1)");

		$stmt->bindParam(":num_certificado", $datos["num_certificado"], PDO::PARAM_STR);
		$stmt->bindParam(":idcliente", $datos["idcliente"], PDO::PARAM_STR);
		$stmt->bindParam(":modelo_gps", $datos["modelo_gps"], PDO::PARAM_STR);
		$stmt->bindParam(":idvehiculo", $datos["idvehiculo"], PDO::PARAM_STR);
		$stmt->bindParam(":fin_cobertura", $datos["fin_cobertura"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt->bindParam(":year", $datos["year"], PDO::PARAM_STR);
		$stmt->bindParam(":sello", $datos["sello"], PDO::PARAM_STR);
		$stmt->bindParam(":fondo", $datos["fondo"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR ACTA
	=============================================*/

	static public function mdlEditarCertificado($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET num_certificado =:num_certificado, idcliente = :idcliente, modelo_gps = :modelo_gps, idvehiculo = :idvehiculo, fin_cobertura = :fin_cobertura, fecha = :fecha, ciudad = :ciudad, year= :year, sello=:sello, fondo= :fondo WHERE id = :id");

		$stmt->bindParam(":id", $datos["editaridCertificado"], PDO::PARAM_INT);
		$stmt->bindParam(":num_certificado", $datos["num_certificado"], PDO::PARAM_STR);
		$stmt->bindParam(":idcliente", $datos["idcliente"], PDO::PARAM_STR);
		$stmt->bindParam(":modelo_gps", $datos["modelo_gps"], PDO::PARAM_STR);
		$stmt->bindParam(":idvehiculo", $datos["idvehiculo"], PDO::PARAM_STR);
		$stmt->bindParam(":fin_cobertura", $datos["fin_cobertura"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt->bindParam(":year", $datos["year"], PDO::PARAM_STR);
		$stmt->bindParam(":sello", $datos["sello"], PDO::PARAM_STR);
		$stmt->bindParam(":fondo", $datos["fondo"], PDO::PARAM_STR);


		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ACTIVAR ACTA
	=============================================*/

	static public function mdlActualizarCertificado($tabla, $item1, $valor1, $item2, $valor2){

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

?>