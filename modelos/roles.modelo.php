<?php

require_once "conexion.php";

class ModeloRoles{


	/*=============================================
	MOSTRAR Roles
	=============================================*/

	static public function mdlMostrarRoles($tabla, $item, $valor){

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
	MOSTRAR Permisos
	=============================================*/

	static public function mdlMostrarPermisos($tabla, $item, $valor){


		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE rol = :id");
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
		
		$stmt = null;
	
	}

	static public function mdlMostrarPermisosMenu($tabla, $item1, $valor1, $item2, $valor2){


		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE rol = :id AND permiso= :permiso");
		$stmt -> bindParam(":id", $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":permiso", $valor2, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();
		
		$stmt = null;
	
	}	
	/*=============================================
	ACTIVAR ROL
	=============================================*/

	static public function mdlActualizarRol($tabla, $item1, $valor1, $item2, $valor2){

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
	CREAR ROL
	=============================================*/

	static public function mdlIngresarRol($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(rol) VALUES (:rol)");

		$stmt->bindParam(":rol", $datos["rol"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	GUARDAR PERMISO ROL
	=============================================*/

	static public function mdlGuardarPermisos($tabla, $item, $valor, $RolGuardar){

		//echo "INSERT INTO $tabla (rol, permiso, estado) VALUES($idRolGuardar, $item, $valor)";

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(rol, permiso, estado) VALUES(:id, :permiso, :estado)");
		$stmt->bindParam(":id", $RolGuardar, PDO::PARAM_STR);
		$stmt->bindParam(":permiso", $item, PDO::PARAM_STR);
		$stmt->bindParam(":estado", $valor, PDO::PARAM_STR);



		if($stmt->execute()){

			echo 1;

		}else{

			echo 0;
		
		}

		
		//$stmt->close();
		$stmt = null;

	}	
	/*=============================================
	GUARDAR PERMISO ROL
	=============================================*/

	static public function mdlEliminarPermisos($tabla, $idRolGuardar){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE rol = :id");

		$stmt->bindParam(":id", $idRolGuardar, PDO::PARAM_INT);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}
	/*=============================================
	EDITAR ROL
	=============================================*/

	static public function mdlEditarRol($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET rol = :rol WHERE id = :id");

		$stmt -> bindParam(":rol", $datos["rol"], PDO::PARAM_STR);

		if($stmt->execute()){

			return 1;

		}else{

			return 0;
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	ELIMINAR Rol
	=============================================*/

	static public function mdlEliminarRol($tabla, $datos){

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

