<?php
setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
class ControladorCertificados{
	
	/*=============================================
	MOSTRAR VEHICULOS AYUDA
	=============================================*/

	static public function ctrMostrarVehiculos(){
        $vehiculos = [];

        $respuesta = ModeloVehiculos::mdlMostrarVehiculos("vehiculo", null, null);
        
        if($respuesta){
            
            for ($i=0; $i < count($respuesta) ; $i++) { 

      			 $vehiculos += [$respuesta[$i]['id'] => $respuesta[$i]['placa'] ];
            }
            // $texto = substr($texto, 0, -1);
            // $texto.='}';

        }
        return json_encode($vehiculos);

    }

	/*=============================================
	MOSTRAR Todos los Certificado
	=============================================*/

	static public function ctrMostrarCertificado($item, $valor){

		$tabla = "certificado";

		$respuesta = ModeloCertificados::mdlMostrarCertificado($tabla, $item, $valor);

		return $respuesta;

	}
	/*=============================================
	CrEAr Todos los Certificado
	=============================================*/

	static public function ctrCrearCertificado(){
		//Cajamarca, 07 de Noviembre del 2018.
		//Cajamarca, 20de Februarydel 2020


		if(isset($_POST["numCertificado"])){

			$item = "id";
   			$valor = $_POST["ciudad"];

   			$ciudad = ControladorCiudad::ctrMostrarCiudad($item, $valor);

			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

			$fecha = $ciudad["nombre"].", ".date("d")." de ".$meses[date('n')-1]." del ".date("Y");

			$ciudadInicial = substr($_POST["ciudad"], 0);

			$datos = array("num_certificado"=>trim(strtoupper($_POST["numCertificado"])),
						   "idcliente"=>trim($_POST["certificadoidcliente"]),
						   "modelo_gps"=>trim($_POST["dispositivo"]),
						   "idvehiculo"=>trim($_POST["idvehiculo"]),
						   "fin_cobertura"=>trim($_POST["fin"]),
						   "fecha"=>$fecha,
						   "ciudad"=>trim($ciudadInicial),
						   "year"=>trim(date("y")),
						   "fondo"=>($_POST["fondo"] == on) ? "1" : "0",
						   "sello"=>($_POST["sello"] == on) ? "1" : "0"
						);

			$tabla = "certificado";

			var_dump($datos);

			$respuesta = ModeloCertificados::mdlCrearCertificado($tabla, $datos);

			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "El certificado ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "certificado";

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
	EDITA Todos los Certificado
	=============================================*/

	static public function ctrEditarCertificado(){

		if(isset($_POST["editaridCertificado"])){

			$item = "id";
   			$valor = $_POST["editarciudad"];


   			$ciudad = ControladorCiudad::ctrMostrarCiudad($item, $valor);



			$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

			$fecha = $ciudad["nombre"].", ".date("d")." de ".$meses[date('n')-1]." del ".date("Y");

			$ciudadInicial = substr($_POST["editarciudad"], 0);


			$datos = array("num_certificado"=>trim(strtoupper($_POST["editarnumCertificado"])),
						   "editaridCertificado"=>trim($_POST["editaridCertificado"]),
						   "idcliente"=>trim($_POST["certificadoidcliente"]),
						   "modelo_gps"=>trim($_POST["editardispositivo"]),
						   "idvehiculo"=>trim($_POST["idEditarVehiculo"]),
						   "fin_cobertura"=>trim($_POST["editarfin"]),
						   "fecha"=>$fecha,
						   "ciudad"=>trim($ciudadInicial),
						   "year"=>trim(date("y")),
						   "fondo"=>(isset($_POST["editarfondo"])) ? "1" : "0",
						   "sello"=>(isset($_POST["editarsello"])) ? "1" : "0"
						);

			$tabla = "certificado";



			$respuesta = ModeloCertificados::mdlEditarCertificado($tabla, $datos);

			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "El certificado ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "certificado";

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