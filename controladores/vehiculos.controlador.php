<?php

class ControladorVehiculos{

	/*=============================================
	MOSTRAR Todos los Vehiculos
	=============================================*/

	static public function ctrMostrarVehiculos($item, $valor){

		$tabla = "vehiculo";

		$respuesta = ModeloVehiculos::mdlMostrarVehiculos($tabla, $item, $valor);

		return $respuesta;

	}
	/*=============================================
	CrEAr Todos los Vehiculos
	=============================================*/

	static public function ctrCrearVehiculos(){

		if(isset($_POST["placa"])){
			$datos = array("placa"=>trim(strtoupper($_POST["placa"])),
						   "marca"=>trim($_POST["marca"]),
						   "modelo"=>trim($_POST["modelo"]),
						   "tipo"=>trim($_POST["tipo"]),
						   "year"=>trim($_POST["year"]),
						   "color"=>trim($_POST["color"]),
						   "motor"=>trim($_POST["motor"]),
						   "serie"=>trim($_POST["serie"]),
						   "idflota"=>trim($_POST["flota"]),
						   "sim"=>trim($_POST["sim"]),
						   "operador"=>trim($_POST["operador"]),
						   "descripcion"=>trim($_POST["descripcion"]),
						   "dispositivo"=>trim($_POST["dispositivo"]),
						   "idgps"=>trim($_POST["idgps"]),
						   "estado"=> 1);



			$datosLinea = array("numero"=>$_POST["sim"],
			   "sim_card"=>"",
			   "placa"=>$_POST["placa"],
			   "empresa"=>"");
			
			ModeloLineas::mdlIngresarLinea("lineas", $datosLinea);

			$tabla = "vehiculo";
			$respuesta = ModeloVehiculos::mdlCrearVehiculos($tabla, $datos);

			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "El vehiculo ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "vehiculo";

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
	EDITA Todos los Vehiculos
	=============================================*/

	static public function ctrEditarVehiculo(){

		if(isset($_POST["editarPlaca"])){
			$datos = array("idvehiculo"=>trim($_POST["editarIdVehiculo"]),
						   "placa"=>trim(strtoupper($_POST["editarPlaca"])),
						   "marca"=>trim($_POST["editarMarca"]),
						   "modelo"=>trim($_POST["editarModelo"]),
						   "tipo"=>trim($_POST["editarTipo"]),
						   "year"=>trim($_POST["editarYear"]),
						   "color"=>trim($_POST["editarColor"]),
						   "motor"=>trim($_POST["editarMotor"]),
						   "serie"=>trim($_POST["editarSerie"]),
						   "idflota"=>trim($_POST["editaridflota"]),
						   "sim"=>trim($_POST["editarSim"]),
						   "operador"=>trim($_POST["editarOperador"]),
						   "descripcion"=>trim($_POST["editarDescripcionVehiculo"]),
						   "dispositivo"=>trim($_POST["editarDispositivo"]),
						   "idgps"=>trim($_POST["editaridgps"]),
						   "estado"=> 1);

			$tabla = "vehiculo";

			$respuesta = ModeloVehiculos::ctrEditarVehiculos($tabla, $datos);

			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "El vehiculo ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "vehiculo";

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
}

?>