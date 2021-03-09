<?php
setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
class ControladorActas{
	
	/*=============================================
	MOSTRAR Todos los Acta
	=============================================*/

	static public function ctrMostrarActa($item, $valor){

		$tabla = "acta";

		$respuesta = ModeloActas::mdlMostrarActa($tabla, $item, $valor);

		return $respuesta;

	}
	/*=============================================
	CrEAr Todos los Acta
	=============================================*/

	static public function ctrCrearActa(){
		//Cajamarca, 07 de Noviembre del 2018.
		//Cajamarca, 20de Februarydel 2020


		if(isset($_POST["numActa"])){

			$item = "id";
   			$valor = $_POST["ciudad"];

   			$ciudad = ControladorCiudad::ctrMostrarCiudad($item, $valor);

			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

			$fecha = $ciudad["nombre"].", ".date("d")." de ".$meses[date('n')-1]." del ".date("Y");

			$ciudadInicial = substr($_POST["ciudad"], 0);

			$datos = array("num_acta"=>trim(strtoupper($_POST["numActa"])),
						   "idvehiculo"=>trim($_POST["idvehiculo"]),
						   "inicio_cobertura"=>trim($_POST["inicio"]),
						   "fin_cobertura"=>trim($_POST["fin"]),
						   "fecha"=>$fecha,
						   "ciudad"=>trim($ciudadInicial),
						   "year"=>trim(date("y")),
						   "fondo"=>($_POST["fondo"] == "on") ? "1" : "0",
						   "sello"=>($_POST["sello"] == "on") ? "1" : "0"
						);

			$tabla = "acta";

			$respuesta = ModeloActas::mdlCrearActa($tabla, $datos);

			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "El acta ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "acta";

						}
					})

				</script>';

			}else{

			echo'<script>

				swal({
					  type: "error",
					  title: "¡Los datos no pueden llevar caracteres especiales o vacios!",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  })

		  	</script>';

		  	return;

			}
		}

	}
	/*=============================================
	EDITA Todos los Acta
	=============================================*/

	static public function ctrEditarActa(){

		if(isset($_POST["editaridActa"])){

			$item = "id";
   			$valor = $_POST["editarciudad"];


   			$ciudad = ControladorCiudad::ctrMostrarCiudad($item, $valor);



			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

			$fecha = $ciudad["nombre"].", ".date("d")." de ".$meses[date('n')-1]." del ".date("Y");

			$ciudadInicial = substr($_POST["editarciudad"], 0);

			$datos = array("num_acta"=>trim(strtoupper($_POST["editarNumActa"])),
						   "idvehiculo"=>trim($_POST["editaractavehiculo"]),
						   "id"=>trim($_POST["editaridActa"]),
						   "inicio_cobertura"=>trim($_POST["editarinicio"]),
						   "fin_cobertura"=>trim($_POST["editarfin"]),
						   "fecha"=>$fecha,
						   "ciudad"=>trim($ciudadInicial),
						   "year"=>trim(date("y")),
						   "fondo"=>(isset($_POST["editarfondo"])) ? "1" : "0",
						   "sello"=>(isset($_POST["editarsello"])) ? "1" : "0"
						);

			$tabla = "acta";



			$respuesta = ModeloActas::mdlEditarActa($tabla, $datos);

			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "El acta ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "acta";

						}
					})

				</script>';

			}else{

			echo'<script>

				swal({
					  type: "error",
					  title: "¡Los datos no pueden llevar caracteres especiales o vacios!",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  })

		  	</script>';

		  	return;

			}
		}

	}



	static public function ctrActualizarFechaActa($ciudad, $idActa){


   		$ciudad = ControladorCiudad::ctrMostrarCiudad("id", $ciudad);



		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

		$fecha = $ciudad["nombre"].", ".date("d")." de ".$meses[date('n')-1]." del ".date("Y");

		$respuesta = ModeloActas::mdlActualizarFechaActa("acta", $idActa, $fecha);

		return $respuesta;
	
	}
}

?>