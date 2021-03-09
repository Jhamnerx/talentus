<?php

class ControladorLineas{

	/*=============================================
	MOSTRAR LINEA
	=============================================*/

	static public function ctrMostrarLineas($item, $valor){

		$tabla = "lineas";

		$respuesta = ModeloLineas::mdlMostrarLineas($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR LINEA
	=============================================*/

	static public function ctrCrearLinea(){

		if(isset($_POST["numeroLinea"])){
			$datos = array("numero"=>$_POST["numeroLinea"],
						   "sim_card"=>$_POST["sim_card"],
						   "placa"=>$_POST["placaLinea"],
						   "empresa"=>$_POST["nameEmpresa"]);

			//echo json_encode($datos);

			$respuesta = ModeloLineas::mdlIngresarLinea("lineas", $datos);

				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "Linea Registrada",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "lineas";

							}
						})

					</script>';

				}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡No se ha podido registrar!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  })

			  	</script>';

			  	return;

			}
		}
	}



	/*=============================================
	EDITAR LINEA
	=============================================*/

	static public function ctrEditarLinea(){

		if(isset($_POST["editarNumeroLinea"])){
			$datos = array("numero"=>$_POST["editarNumeroLinea"],
						   "sim_card"=>$_POST["editarSim_card"],
						   "placa"=>$_POST["editarPlaca"],
						   "id"=>$_POST["idLinea"],
						   "empresa"=>$_POST["editarNameEmpresa"]);

			echo json_encode($datos);


			$respuesta = ModeloLineas::mdlEditarLinea("lineas", $datos);


			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "Edicion Exitosa",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "lineas";

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

								window.location = "lineas";

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


			$respuesta = ModeloLineas::mdlEliminarCategoria("lineas", $_GET["idCategoria"]);


			if($respuesta == 1){

				echo'<script>
				swal({
					  type: "success",
					  title: "La categoría ha sido borrada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "lineas";

								}
							})

				</script>';
				
			}
			
		}

	}


}
