<?php

require_once "../controladores/ciudad.controlador.php";
require_once "../modelos/ciudad.modelo.php";


class AjaxCiudad{

  /*=============================================
  ACTIVAR CIUDAD
  =============================================*/	

  public $activarCiudad;
  public $activarId;

  public function ajaxActivarCiudad(){



    $estado = ModeloCiudad::mdlActualizarCiudad("ciudad", "estado", $this->activarCiudad, "id", $this->activarId);
  

    echo $estado;


  }

  /*=============================================
  VALIDAR NO REPETIR CATEGORÍA
  =============================================*/ 

  public $validarCiudad;

  public function ajaxValidarCiudad(){

    $item = "categoria";
    $valor = $this->validarCiudad;

    $respuesta = ControladorCiudad::ctrMostrarCiudad($item, $valor);

    echo json_encode($respuesta);

  }

  /*=============================================
  EDITAR CIUDAD
  =============================================*/ 

  public $idCiudad;

  public function ajaxEditarCiudad(){

    $item = "id";
    $valor = $this->idCiudad;

    $respuesta = ControladorCiudad::ctrMostrarCiudad($item, $valor);

    echo json_encode($respuesta);

  }

}

/*=============================================
ACTIVAR CIUDAD
=============================================*/

if(isset($_POST["activarCiudad"])){

	$activarCiudad = new AjaxCiudad();
	$activarCiudad -> activarCiudad = $_POST["activarCiudad"];
	$activarCiudad -> activarId = $_POST["activarId"];
	$activarCiudad -> ajaxActivarCiudad();

}


/*=============================================
EDITAR CIUDAD
=============================================*/
if(isset($_POST["idCiudad"])){

  $editar = new AjaxCiudad();
  $editar -> idCiudad = $_POST["idCiudad"];
  $editar -> ajaxEditarCiudad();

}

