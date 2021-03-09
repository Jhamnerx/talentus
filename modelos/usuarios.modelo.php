<?php 
 require_once "conexion.php";


 /**
  * 
  */
 class ModeloUsuarios{
 	
	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function mdlMostrarUsuarios($tabla, $item, $valor){

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


	static public function mdlMostrarTecnicos($tabla, $item, $valor){


		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND estado = 1");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();


		$stmt -> close();
		
		$stmt = null;
	
	}


	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/
	static public function mdlRegistroUsuario($tabla, $datos, $ruta){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, apellido, tipo_documento, num_documento, direccion, telefono, email, cargo, ciudad, login, clave, foto, estado) VALUES (:nombre, :apellido, :tipo_documento, :num_documento, :direccion, :telefono, :email, :cargo, :ciudad, :loginUsuario, :passUsuario, :foto, 1)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":num_documento", $datos["num_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
		$stmt->bindParam(":loginUsuario", $datos["loginUsuario"], PDO::PARAM_STR);
		$stmt->bindParam(":passUsuario", $datos["passUsuario"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $ruta, PDO::PARAM_STR);


		if($stmt->execute()){

			return "1";

		}else{

			return "0";
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	ACTIVAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

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
	EDITAR USUARIO
	=============================================*/
	static public function mdlEditarUsuario($tabla, $datos){

		$stmt = Conexion::Conectar()->prepare("UPDATE $tabla SET nombre = :nombre, apellido = :apellido, tipo_documento = :tipo_documento, num_documento = :num_documento, direccion = :direccion, cargo = :cargo, ciudad = :ciudad, telefono = :telefono, email = :email WHERE id = :id");

		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_documento", $datos["tipo_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":num_documento", $datos["num_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);
		$stmt->bindParam(":ciudad", $datos["ciudad"], PDO::PARAM_STR);
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

 }


 ?>