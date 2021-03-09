<?php

class ControladorRoles{

	/*=============================================
	MOSTRAR Roles
	=============================================*/

	static public function ctrMostrarRoles($item, $valor){

		$tabla = "roles";

		$respuesta = ModeloRoles::mdlMostrarRoles($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR Permisos
	=============================================*/

	static public function ctrMostrarPermisos($item, $valor){

		$tabla = "permisos";

		$respuesta = ModeloRoles::mdlMostrarPermisos($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR ROLES
	=============================================*/

	static public function ctrCrearRol(){

		if(isset($_POST["rol"])){
			$datos = array("rol"=>trim(strtoupper($_POST["rol"])));

			$respuesta = ModeloRoles::mdlIngresarRol("roles", $datos);

				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "Rol creado",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "plantilla";

							}
						})

					</script>';

				}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡No se pudo guardar!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  })

			  	</script>';

			  	return;

			}
		}
	}



	/*=============================================
	EDITAR ROL PERMISOS
	=============================================*/

	static public function ctrGuardarPermisos($datos){
		//var_dump($datos);
		$tabla = "permisos";
		$existe = ModeloRoles::mdlMostrarPermisos($tabla, "id", $datos["id"]);

		if (count($existe) > 0) {
			//echo "existe";
			$eliminar = ModeloRoles::mdlEliminarPermisos($tabla, $datos["id"]);
		}
		
		foreach ($datos as $key => $value) {

			$tabla = "permisos";
			$item = $key;
			$valor = $value;

			//echo "UPDATE $tabla SET estado =$valor WHERE rol =$idRolGuardar AND permiso = $item";

			$respuesta = ModeloRoles::mdlGuardarPermisos($tabla, $item, $valor, $datos["id"]);

			echo $respuesta;
		}


	}




}
