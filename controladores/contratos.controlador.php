<?php 

/**
 * CLASE CONTRATOS
 */
class ControladorContratos
{
	
	static public function ctrMostrarContratos($item, $valor, $mod){

		$tabla = "contrato";
		
		$respuesta = ModeloContratos::mdlMostrarContratos($tabla, $item, $valor, $mod);

		return $respuesta;
	}
	
	static public function ctrMostrarDetalleContratos($item, $valor, $mod){

		$tabla = "detalle_contrato";
		
		$respuesta = ModeloContratos::mdlMostrarContratos($tabla, $item, $valor, $mod);

		return $respuesta;
	}

	/*=============================================
	GUARDAR CONTRATO
	=============================================*/

	static public function ctrGuardarContrato($datos){

		$tabla = "contrato";

		$respuesta = ModeloContratos::mdlGuardarContrato($tabla, $datos);

		if ($respuesta != null) {

			$datos1 = array("idcontrato"=>$respuesta,
					"idvehiculo"=>$datos["idvehiculo"],
					"plan"=>$datos["plan"],
					);

			$tabla1 = "detalle_contrato";

			$respuesta1 =  ModeloContratos::mdlGuardarContratoDetalle($tabla1, $datos1);

			return $respuesta1;
		}

	}


	/*=============================================
	EDITAR CONTRATO
	=============================================*/

	static public function ctrEditarContrato(){

		if(isset($_POST["editarIdContrato"])){

			$datos = array("id"=>$_POST["editarIdContrato"],
						   "fecha"=>strtoupper($_POST["editarFechaContrato"]),
						   "ciudad"=>$_POST["contratoEditarciudad"]
						);

			$respuesta = ModeloContratos::mdlEditarContrato("contrato", $datos);


			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "El contrato se ha guardado",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "contrato";

						}
					})

				</script>';

			}
		}
	}


	/*=============================================
	ELIMINAR CONTRATO
	=============================================*/

	static public function ctrEliminarContrato(){

		if(isset($_GET["idContrato"])){


			/*=============================================
			ELIMINAR DETALLE DE LOS CONTRATOS
			=============================================*/
			$tabla = "detalle_contrato";
			$item = "idcontrato";
			$valor = $_GET["idContrato"];


			$traerdetalleContrato = ModeloContratos::mdlMostrarContratos($tabla, $item, $valor, 0);

			var_dump($traerdetalleContrato);

			if($traerdetalleContrato){


				foreach ($traerdetalleContrato as $key => $value) {

					$item = "idcontrato";
					$valor = $value["id"];

					$deleteDetalle = ModeloContratos::mdlEliminarDetalleContrato("detalle_contrato", $valor);

				}



			}


			$respuesta = ModeloContratos::mdlEliminarContrato("contrato", $_GET["idContrato"]);


			if($respuesta == 1){

				echo'<script>
				swal({
					  type: "success",
					  title: "Se ha eliminado el contrato",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
								if (result.value) {

								window.location = "contratos";

								}
							})

				</script>';
				
			}
			
		}

	}



}


 ?>