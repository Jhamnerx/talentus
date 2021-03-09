<?php
require_once "utiles.php";
require_once "notificaciones.controlador.php";

class ControladorUsuarios{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function ctrMostrarUsuarios($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarTecnicos($item, $valor){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlMostrarTecnicos($tabla, $item, $valor);

		return $respuesta;

	}
	/*=============================================
	REGISTRO DE CLIENTES
	=============================================*/

	public function ctrRegistroClientes(){

		if(isset($_POST["regUsuario"])){

			if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["regUsuario"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["regEmail"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["regPassword"])){

			   	$encriptar = crypt($_POST["regPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			   	$encriptarEmail = md5($_POST["regEmail"]);

			   	$login = explode(" ", $_POST["regUsuario"]);
			    $datos = array(
			          "nombre"=>$_POST["regUsuario"],
			          "apellido"=>"",
			          "tipo_documento"=>"",
			          "num_documento"=>$_POST["regNumDocumento"],
			          "direccion"=>"",
			          "cargo"=>"7",
			          "ciudad"=>"2",
			          "telefono"=>"",
			          "email"=>$_POST["regEmail"],
			          "loginUsuario"=>$login[0],
			          "passUsuario"=>$encriptar,
			          "fotoUsuario"=>"vistas/img/usuarios/default/default.jpg"
			          );



				$tabla = "usuarios";

				$respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos, $datos["fotoUsuario"]);

				if($respuesta == "1"){

					/*=============================================
					VERIFICACIÓN CORREO ELECTRÓNICO
					=============================================*/

					date_default_timezone_set("America/Lima");

					$url = Ruta::ctrRuta();	

					$mail = new PHPMailer;

					$mail->CharSet = 'UTF-8';

					$mail->isMail();

					$mail->setFrom('clientes@talentustechnology.com', 'Talentus Technology');

					$mail->addReplyTo('clientes@talentustechnology.com', 'Talentus Technology');

					$mail->Subject = "Por favor verifique su dirección de correo electrónico";

					$mail->addAddress($_POST["regEmail"]);

					$mail->msgHTML('<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
						
						<center>
							
							<img style="padding:20px; width:10%" src="http://talentustechnology.com/talentus/vistas/img/plantilla/logo.png">

						</center>

						<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
						
							<center>
							
							<img style="padding:20px; width:15%" src="http://talentustechnology.com/talentus/vistas/img/plantilla/email.png">

							<h3 style="font-weight:100; color:#999">GRACIAS POR REGISTRARSE EN TALENTUS SISTEMA</h3>

							<hr style="border:1px solid #ccc; width:80%">

							<h4 style="font-weight:100; color:#999; padding:0 20px">Podra solicitar un servicio desde este enlance</h4>

							<a href="'.$url.'solicitar/'.$encriptarEmail.'" target="_blank" style="text-decoration:none">

						

							</a>

							<br>

							<hr style="border:1px solid #ccc; width:80%">

							<h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>

							</center>

						</div>

					</div>');

					$envio = $mail->Send();

					if(!$envio){

						echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡Ha ocurrido un problema enviando verificación de correo electrónico a '.$_POST["regEmail"].$mail->ErrorInfo.'!",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},

								function(isConfirm){

									if(isConfirm){
										history.back();
									}
							});

						</script>';

					}else{

						echo '<script> 

							swal({
								  title: "¡OK!",
								  text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM de su correo electrónico '.$_POST["regEmail"].' para verificar la cuenta!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},

								function(isConfirm){

									if(isConfirm){
										history.back();
									}
							});

						</script>';

					}

				}

			}else{

				echo '<script> 

						swal({
							  title: "¡ERROR!",
							  text: "¡Error al registrar el usuario, no se permiten caracteres especiales!",
							  type:"error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							},

							function(isConfirm){

								if(isConfirm){
									history.back();
								}
						});

				</script>';

			}

		}

	}


	/*=============================================
	CREAR USUARIOS
	=============================================*/

	static public function ctrCrearUsuario($datos){
		
		/*=============================================
		GUARDAR FOTO
		=============================================*/	
		$tabla = "usuarios";
		if ($datos["fotoUsuario"] != "data:,") {
		
			list($ancho, $alto) = getimagesize($datos["fotoUsuario"]);



			$nuevoAncho = 500;
			$nuevoAlto = 500;

			$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

			$ruta = "../vistas/img/usuarios/".strtolower($datos["loginUsuario"])."/".$datos["loginUsuario"].".png";
			$ruta2 = "/vistas/img/usuarios/".strtolower($datos["loginUsuario"]);

			if (!file_exists($ruta)) {		
				echo "no existe";
				mkdir("../vistas/img/usuarios/".strtolower($datos["loginUsuario"]), 0700);
				
			}

			$origen = imagecreatefrompng($datos["fotoUsuario"]);

			imagealphablending($destino, FALSE);

			imagesavealpha($destino, TRUE);

			imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);


			imagepng($destino, $ruta);


		}else{

			$ruta = "vistas/img/usuarios/default/default.jpg";
		}




		$respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos, $ruta);

		return $respuesta;



	}
	/*=============================================
	EDITAR USUARIOS
	=============================================*/
	static public function ctrEditarUsuario(){

		if (isset($_POST["editarIdUsuario"])) {
			
			$datos = array('id' => $_POST["editarIdUsuario"],
						   'nombre'=> $_POST["editarNombreUsuario"],
						   'apellido' => $_POST["editarApellidoUsuario"],
						   'tipo_documento' => $_POST["editarTipoDocumento"],
						   'num_documento' => $_POST["editarNumDocumento"],
						   'direccion' => $_POST["editarDireccion"],
						   'cargo' => $_POST["editarCargo"],
						   'ciudad'=> $_POST["editarCiudad"],
						   'telefono' => $_POST["editarTelefono"],
						   'email'=> $_POST["editarEmail"]);


			$respuesta = ModeloUsuarios::mdlEditarUsuario("usuarios", $datos);


			if($respuesta == 1){

				echo'<script>

				swal({
					  type: "success",
					  title: "El usuario ha sido editado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "usuarios";

						}
					})

				</script>';

			}


		}
	}


	/*=============================================
CAMBIAR PASSWORD
	=============================================*/
	static public function ctrCambiarPassword(){

		if (isset($_POST["PasswordIdUsuario"])) {

			if ($_POST["PasswordUsuario"] != $_POST["PasswordUsuario2"]) {
				
				echo'<script>

				swal({
					  type: "error",
					  title: "Las contraseñas no coinciden",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "usuarios";

						}
					})

				</script>';

				return;

			}else{

				$encriptar = crypt($_POST["PasswordUsuario"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');


				$respuesta = ModeloUsuarios::mdlActualizarUsuario("usuarios", "clave",$encriptar, "id", $_POST["PasswordIdUsuario"]);


				if($respuesta == 1){

					echo'<script>

					swal({
						  type: "success",
						  title: "Contraseña cambiada",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "usuarios";

							}
						})

					</script>';

				}


			}

			



		}
	}



	/*=============================================
	LOGIN USUARIOS
	=============================================*/
	static public function ctrIngresoUsuario($datos){


		$is_email = Utiles::is_email($datos["login"]);

		if ($is_email) {

			$item = "email";

		}else{

			$item = "login";
		}
		
		$valor = $datos["login"];
		$tabla = "usuarios";

		if(isset($datos["login"])){

			$encriptar = crypt($datos["clave"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			$tabla = "usuarios";

			$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

			if (!$respuesta) {

				return 10;
			}

			if((strtolower($respuesta["login"]) == strtolower($datos["login"]) || strtolower($respuesta["email"]) == strtolower($datos["login"])) && $respuesta["clave"] == $encriptar){

				if ($respuesta["estado"] == 1) {

					/**
					 * AÑDIR NOTIFICACION
					 */	
				    $cobros = ModeloCobros::mdlMostrarCobros("cobros", null, null);


			    	for ($i=0; $i < count($cobros); $i++) {
				        $fechaInicial = $cobros[$i]["fechaVen"];
				        $fechaFinal = date("Y/m/d");

				        $dias = Utiles::diferenciaFechas($fechaInicial, $fechaFinal);

			       
				        if ($dias <= 10 AND $dias >= 0) {
				          
				          $datos = array("tipo"=>"vencimiento",
				           "descripcion"=>"porvencer",
				           "idCobro"=>$cobros[$i]["id"],
				           "autor"=> "sistema",
				           "estado"=> "1");

				          $notifi = ControladorNotificaciones::ctrIngresarNotificacion($datos);

				        }

			      	}
					session_start();

					$_SESSION["validarSesion"] = "ok";
					$_SESSION["id"] = $respuesta["id"];
					$_SESSION["nombre"] = $respuesta["nombre"];
					$_SESSION["apellido"] = $respuesta["apellido"];
					$_SESSION["email"] = $respuesta["email"];
					$_SESSION["tipo_documento"] = $respuesta["tipo_documento"];
					$_SESSION["num_documento"] = $respuesta["num_documento"];
					$_SESSION["direccion"] = $respuesta["direccion"];
					$_SESSION["telefono"] = $respuesta["telefono"];
					
					$_SESSION["ciudad"] = $respuesta["ciudad"];
					$_SESSION["foto"] = $respuesta["foto"];
					$_SESSION["estado"] = $respuesta["foto"];
					$_SESSION["estado"] = $respuesta["foto"];

					$permisos = ModeloUsuarios::mdlMostrarPermisos("permisos", "rol", $respuesta["cargo"]);

					$cargo = ModeloUsuarios::mdlMostrarRoles("roles", "id", $respuesta["cargo"]);

					$_SESSION["cargo"] = $cargo["rol"];

					foreach ($permisos as $key => $value) {

						$_SESSION[$value["permiso"]] = $value["estado"];
					}

					return 1;


				}else{

					return 2;


				}

				return 4;

			}else{

				return 3;
			}

		}

	}

}