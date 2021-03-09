<?php

require_once "conexion.php";

class ModeloVehiculos{


	/*=============================================
	MOSTRAR Todos Vehiculos
	=============================================*/

	static public function mdlMostrarVehiculos($tabla, $item, $valor){

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
	CREAR VEHICULO
	=============================================*/

	static public function mdlCrearVehiculos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(placa,marca,modelo,tipo,year,color,motor,serie,flota,sim,operador,descripcion,dispositivo,idgps,estado) VALUES (:placa,:marca,:modelo,:tipo,:year,:color,:motor,:serie,:flota,:sim,:operador,:descripcion,:dispositivo,:idgps,1)");

		$stmt->bindParam(":placa", $datos["placa"], PDO::PARAM_STR);
		$stmt->bindParam(":marca", $datos["marca"], PDO::PARAM_STR);
		$stmt->bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":year", $datos["year"], PDO::PARAM_STR);
		$stmt->bindParam(":color", $datos["color"], PDO::PARAM_STR);
		$stmt->bindParam(":motor", $datos["motor"], PDO::PARAM_STR);
		$stmt->bindParam(":serie", $datos["serie"], PDO::PARAM_STR);
		$stmt->bindParam(":flota", $datos["idflota"], PDO::PARAM_INT);
		$stmt->bindParam(":sim", $datos["sim"], PDO::PARAM_STR);
		$stmt->bindParam(":operador", $datos["operador"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":dispositivo", $datos["dispositivo"], PDO::PARAM_STR);
		$stmt->bindParam(":idgps", $datos["idgps"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	EDITAR VEHICULO
	=============================================*/

	static public function ctrEditarVehiculos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET placa =:placa, marca = :marca, modelo = :modelo, tipo = :tipo, year = :year, color = :color, motor= :motor, serie=:serie, flota= :flota, sim = :sim, operador= :operador, descripcion= :descripcion, dispositivo=:dispositivo, idgps=:idgps WHERE id = :idvehiculo");

		$stmt->bindParam(":idvehiculo", $datos["idvehiculo"], PDO::PARAM_INT);
		$stmt->bindParam(":placa", $datos["placa"], PDO::PARAM_STR);
		$stmt->bindParam(":marca", $datos["marca"], PDO::PARAM_STR);
		$stmt->bindParam(":modelo", $datos["modelo"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":year", $datos["year"], PDO::PARAM_STR);
		$stmt->bindParam(":color", $datos["color"], PDO::PARAM_STR);
		$stmt->bindParam(":motor", $datos["motor"], PDO::PARAM_STR);
		$stmt->bindParam(":serie", $datos["serie"], PDO::PARAM_STR);
		$stmt->bindParam(":flota", $datos["idflota"], PDO::PARAM_INT);
		$stmt->bindParam(":sim", $datos["sim"], PDO::PARAM_STR);
		$stmt->bindParam(":operador", $datos["operador"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":dispositivo", $datos["dispositivo"], PDO::PARAM_STR);
		$stmt->bindParam(":idgps", $datos["idgps"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ACTIVAR VEHICULO
	=============================================*/

	static public function mdlActualizarVehiculos($tabla, $item1, $valor1, $item2, $valor2){

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