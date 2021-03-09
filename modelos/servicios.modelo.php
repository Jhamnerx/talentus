<?php

require_once "conexion.php";

class ModeloServicios{


	/*=============================================
	MOSTRAR Todos Servicios
	=============================================*/

	static public function mdlMostrarServicios($tabla, $item, $valor){

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
	MOSTRAR EL TOTAL DE VENTAS
	=============================================*/	

	static public function mdlMostrarTotalProductos($tabla, $orden){
	
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt-> close();

		$stmt = null;

	}
	/*=============================================
	MOSTRAR Articulos
	=============================================*/

	static public function mdlMostrarArticulos($tabla, $item, $valor){

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
	MOSTRAR SERVICIOS/ARTICULOS MUCHO -> MUCHOS
	=============================================*/
	static public function mdlMostrarNArticulos($tabla, $item, $valor){


		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		
		$stmt = null;
	
	}

	/*=============================================
	ACTIVAR SERVICIO
	=============================================*/

	static public function mdlActualizarServicios($tabla, $item1, $valor1, $item2, $valor2){

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
	CREAR SERVICIO
	=============================================*/

	static public function mdlIngresarServicio($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idcategoria, tipo, nombre, precio, stock, descripcion, imagen, estado) VALUES (:idcategoria, :tipo, :nombre, :precio, :stock, :descripcion, :imagen, :estado)");

		$stmt->bindParam(":idcategoria", $datos["categoria"], PDO::PARAM_INT);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt->bindParam(":stock", $datos["stock"], PDO::PARAM_INT);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
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
	EDITAR SERVICIO
	=============================================*/

	static public function mdlEditarServicio($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, idcategoria = :categoria, tipo = :tipo, precio = :precio, stock = :stock, descripcion = :descripcion, imagen = :imagen WHERE id = :id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":categoria", $datos["categoria"], PDO::PARAM_INT);
		$stmt -> bindParam(":tipo", $datos["tipo"], PDO::PARAM_STR);
		$stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
		$stmt -> bindParam(":stock", $datos["stock"], PDO::PARAM_INT);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
		

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

}