<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
require_once "../modelos/notificaciones.modelo.php";
require_once "../controladores/notificaciones.controlador.php";
require_once "../controladores/cobros.controlador.php";
require_once "../modelos/cobros.modelo.php";

class AjaxUsuario{


  /*=============================================
  VALIDAR EMAIL EXISTENTE
  =============================================*/ 

  public $validarEmail;

  public function ajaxValidarEmail(){

    $datos = $this->validarEmail;

    $respuesta = ControladorUsuarios::ctrMostrarUsuarios("email", $datos);

    if ($respuesta) {

      echo json_encode($respuesta);
      # code...
    }else{
      echo 0;
    }

      

  }

/*==================================================
  EDITAR USUARIO

/*==================================================*/
  public $idEditarUsuario;
  public function ajaxEditarUsuario(){

    $item = "id";
    $valor = $this->idEditarUsuario;

    $respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

    echo json_encode($respuesta);


  }


  /*=============================================
  ACTIVAR USUARIO
  =============================================*/ 

  public $activarUsuario;
  public $activarId;

  public function ajaxActivarUsuario(){



    $estado = ModeloUsuarios::mdlActualizarUsuario("usuarios", "estado", $this->activarUsuario, "id", $this->activarId);
  

    echo $estado;


  }

  /*=============================================
  LOGIN USUARIO
  =============================================*/ 

  public $login;
  public $clave;

  public function ajaxLoginUsuario(){

  	$datos = array("login"=>$this->login,
					"clave"=>$this->clave
					);



    $respuesta = ControladorUsuarios::ctrIngresoUsuario($datos);

    echo $respuesta;

  }

  /*=============================================
  VERIFICAR USUARIO
  =============================================*/ 

  public $usuario;

  public function ajaxVerificarUsuario(){

    $tabla = "usuarios";

    $item = "login";
    $valor = $this->usuario;


    $respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla, $item, $valor);

    echo json_encode($respuesta);

  }

  /*=============================================
  REGISTRAR USUARIO
  =============================================*/ 
  public $nombre;
  public $apellido;
  public $tipoDocumento;
  public $numDocumento;
  public $direccion;
  public $cargo;
  public $ciudad;
  public $telefono;
  public $email;
  public $loginUsuario;
  public $passUsuario;
  public $fotoUsuario;
  
  public function ajaxCrearUsuario(){

    $datos = array(
          "nombre"=>$this->nombre,
          "apellido"=>$this->apellido,
          "tipo_documento"=>$this->tipoDocumento,
          "num_documento"=>$this->numDocumento,
          "direccion"=>$this->direccion,
          "cargo"=>$this->cargo,
          "ciudad"=>$this->ciudad,
          "telefono"=>$this->telefono,
          "email"=>$this->email,
          "loginUsuario"=>$this->loginUsuario,
          "passUsuario"=>crypt($this->passUsuario, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'),
          "fotoUsuario"=>$this->fotoUsuario
          );

    $respuesta = ControladorUsuarios::ctrCrearUsuario($datos);

    echo $respuesta;

  }

}


/*=============================================
VALIDAR EMAIL EXISTENTE
=============================================*/ 

if(isset($_POST["validarEmail"])){

  $valEmail = new AjaxUsuario();
  $valEmail -> validarEmail = $_POST["validarEmail"];
  $valEmail -> ajaxValidarEmail();

}


/*=============================================
LOGIN USUARIO
=============================================*/
if(isset($_POST["login"])){

	$login = new AjaxUsuario();
	$login -> login = $_POST["login"];
	$login -> clave = $_POST["clave"];
	$login -> ajaxLoginUsuario();

}

/*=============================================
VERIFICAR USUARIO
=============================================*/
if(isset($_POST["usuario"])){

  $verificar = new AjaxUsuario();
  $verificar -> usuario = $_POST["usuario"];
  $verificar -> ajaxVerificarUsuario();

}
/*=============================================
REGISTRAR USUARIO
=============================================*/ 
if(isset($_POST["nombre"])){

  $crear = new AjaxUsuario();
  $crear -> nombre = $_POST["nombre"];
  $crear -> apellido = $_POST["apellido"];
  $crear -> tipoDocumento = $_POST["tipoDocumento"];
  $crear -> numDocumento = $_POST["numDocumento"];
  $crear -> direccion = $_POST["direccion"];
  $crear -> cargo = $_POST["cargo"];
  $crear -> ciudad = $_POST["ciudad"];
  $crear -> telefono = $_POST["telefono"];
  $crear -> email = $_POST["email"];
  $crear -> loginUsuario = $_POST["loginUsuario"];
  $crear -> passUsuario = $_POST["passUsuario"];
  $crear -> fotoUsuario = $_POST["fotoUsuario"];
  $crear -> ajaxCrearUsuario();

}

/*=============================================
ACTIVAR USUARIOS
=============================================*/

if(isset($_POST["activarUsuario"])){

  $activarUsuario = new AjaxUsuario();
  $activarUsuario -> activarUsuario = $_POST["activarUsuario"];
  $activarUsuario -> activarId = $_POST["activarId"];
  $activarUsuario -> ajaxActivarUsuario();

}


/*=============================================
EDITAR USUARIOS
=============================================*/
if (isset($_POST["idEditarUsuario"])) {

  $editarUsario = new AjaxUsuario();
  $editarUsario -> idEditarUsuario = $_POST["idEditarUsuario"];
  $editarUsario -> ajaxEditarUsuario();

  # code...
}

?>