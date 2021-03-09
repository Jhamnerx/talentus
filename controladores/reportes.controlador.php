<?php

class ControladorReportes{

	/*=============================================
	MOSTRAR REPORTES
	=============================================*/

	static public function ctrMostrarReportes($item, $valor){

		$tabla = "reportes";

		$respuesta = ModeloReportes::mdlMostrarReportes($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR DETALLES
	=============================================*/

	static public function ctrMostrarDetallesReportes($item, $valor){

		$tabla = "reporte_detalle";

		$respuesta = ModeloReportes::mdlMostrarDetalleReportes($tabla, $item, $valor);

		return $respuesta;

	}
	/*=============================================
	CREAR REPORTES
	=============================================*/

	static public function ctrCrearReporte(){

		if(isset($_POST["idvehiculoreporte"])){
			$datos = array("vehiculo"=>trim(strtoupper($_POST["idvehiculoreporte"])),
						   "fecha_t"=>trim($_POST["fechaReporte"]),
						   "hora_t"=>trim($_POST["horaReporte"]),
						   "fecha"=>date('d-m-Y'),
						   "detalle"=>trim($_POST["descripcionReporte"]));

			$respuesta = ModeloReportes::mdlIngresarReporte("reportes", $datos);

				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "El reporte se guardo",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "reporte";

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
	CREAR DETALLE REPORTES
	=============================================*/

	static public function ctrCrearDetalleReporte(){

		if(isset($_POST["idReporteEditar"])){
			$datos = array("id_reporte"=>trim(strtoupper($_POST["idReporteEditar"])),
						   "detalle"=>trim($_POST["accionReporte"]));

			$respuesta = ModeloReportes::mdlIngresarDetalleReporte("reporte_detalle", $datos);

				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "El reporte se guardo",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "reporte";

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
	EDITAR REPORTES
	=============================================*/

	static public function ctrEditarReporte(){

		if(isset($_POST["editarNombreReporte"])){

			$datos = array("vehiculo"=>trim(strtoupper($_POST["idvehiculoreporte"])),
						   "id"=>trim($_POST["idReporte"]),
						   "fecha_t"=>trim($_POST["fechaReporte"]),
						   "hora_t"=>trim($_POST["horaReporte"]),
						   "fecha"=>trim($_POST["horaReporte"]),
						   "detalle"=>trim($_POST["descripcionReporte"]));

			$respuesta = ModeloReportes::mdlEditarReporte("reportes", $datos);


			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "La categoría ha sido editada correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "reporte";

						}
					})

				</script>';

			}
		}
	}


	/*=============================================
	ELIMINAR REPORTES
	=============================================*/

	// static public function ctrEliminarReporte(){

	// 	if(isset($_GET["idReporte"])){


	// 		/*=============================================
	// 		QUITAR LAS CATEGORIAS DE LOS PRODUCTOS
	// 		=============================================*/
	// 		$tabla = "servicios";
	// 		$item = "idcategoria";
	// 		$valor = $_GET["idReporte"];

	// 		$traerServicios = ModeloServicios::mdlMostrarNArticulos($tabla, $item, $valor);

	// 		if ($_GET["idReporte"] ==1) {

	// 			echo'<script>
	// 			swal({
	// 				  type: "error",
	// 				  title: "No Puedes Eliminar la Reporte por Defecto",
	// 				  showConfirmButton: true,
	// 				  confirmButtonText: "Cerrar"
	// 				  }).then(function(result){
	// 							if (result.value) {

	// 							window.location = "reportes";

	// 							}
	// 						})

	// 			</script>';
	// 			return;
	// 		}

	// 		if($traerServicios){

	// 			echo var_dump($traerServicios);

	// 			foreach ($traerServicios as $key => $value) {

	// 				$item1 = "idcategoria";
	// 				$valor1 = 1;
	// 				$item2 = "id";
	// 				$valor2 = $value["id"];

	// 				ModeloServicios::mdlActualizarServicios("servicios", $item1, $valor1, $item2, $valor2);

	// 			}



	// 		}


	// 		$respuesta = ModeloReportes::mdlEliminarReporte("reportes", $_GET["idReporte"]);


	// 		if($respuesta == 1){

	// 			echo'<script>
	// 			swal({
	// 				  type: "success",
	// 				  title: "La categoría ha sido borrada correctamente",
	// 				  showConfirmButton: true,
	// 				  confirmButtonText: "Cerrar"
	// 				  }).then(function(result){
	// 							if (result.value) {

	// 							window.location = "reportes";

	// 							}
	// 						})

	// 			</script>';
				
	// 		}
			
	// 	}

	// }


}
