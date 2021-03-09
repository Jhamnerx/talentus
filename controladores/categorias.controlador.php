<?php

class ControladorCategorias{

	/*=============================================
	MOSTRAR CATEGORIAS
	=============================================*/

	static public function ctrMostrarCategorias($item, $valor){

		$tabla = "categorias";

		$respuesta = ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR CATEGORIAS
	=============================================*/

	static public function ctrCrearCategoria(){

		if(isset($_POST["nombreCategoria"])){
			$datos = array("categoria"=>trim(strtoupper($_POST["nombreCategoria"])),
						   "descripcion"=>trim($_POST["descripcionCategoria"]),
						   "estado"=> 1);

			$respuesta = ModeloCategorias::mdlIngresarCategoria("categorias", $datos);

				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "La categoría ha sido guardada correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "categorias";

							}
						})

					</script>';

				}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  })

			  	</script>';

			  	return;

			}
		}
	}



	/*=============================================
	EDITAR CATEGORIAS
	=============================================*/

	static public function ctrEditarCategoria(){

		if(isset($_POST["editarNombreCategoria"])){

			$datos = array("id"=>$_POST["editarIdCategoria"],
						   "categoria"=>strtoupper($_POST["editarNombreCategoria"]),
						   "descripcion"=>$_POST["descripcionCategoria"]
						);

			$respuesta = ModeloCategorias::mdlEditarCategoria("categorias", $datos);


			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "La categoría ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "categorias";

						}
					})

				</script>';

			}
		}
	}


	/*=============================================
	ELIMINAR CATEGORIA
	=============================================*/

	static public function ctrEliminarCategoria(){

		if(isset($_GET["idCategoria"])){


			/*=============================================
			QUITAR LAS CATEGORIAS DE LOS PRODUCTOS
			=============================================*/
			$tabla = "servicios";
			$item = "idcategoria";
			$valor = $_GET["idCategoria"];

			$traerServicios = ModeloServicios::mdlMostrarNArticulos($tabla, $item, $valor);

			if ($_GET["idCategoria"] ==1) {

				echo'<script>
				swal({
					  type: "error",
					  title: "No Puedes Eliminar la Categoria por Defecto",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "categorias";

								}
							})

				</script>';
				return;
			}

			if($traerServicios){

				echo var_dump($traerServicios);

				foreach ($traerServicios as $key => $value) {

					$item1 = "idcategoria";
					$valor1 = 1;
					$item2 = "id";
					$valor2 = $value["id"];

					ModeloServicios::mdlActualizarServicios("servicios", $item1, $valor1, $item2, $valor2);

				}



			}


			$respuesta = ModeloCategorias::mdlEliminarCategoria("categorias", $_GET["idCategoria"]);


			if($respuesta == 1){

				echo'<script>
				swal({
					  type: "success",
					  title: "La categoría ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "categorias";

								}
							})

				</script>';
				
			}
			
		}

	}


}
