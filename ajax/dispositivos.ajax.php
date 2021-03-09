<?php

require_once "../controladores/dispositivos.controlador.php";
require_once "../modelos/dispositivos.modelo.php";


class AjaxDispositivos{

  /*=============================================
  MOSTRAR DISPOSITIVOS
  =============================================*/ 

  public function ajaxMostrarDispositivos(){



    $item = null;
    $valor = null;

    $dispositivo = ControladorDispositivos::ctrMostrarDispositivos($item, $valor);

    echo json_encode($dispositivo);

  }
  /*=============================================
  ACTIVAR DISPOSITIVO
  =============================================*/	

  public $activarDispositivo;
  public $activarId;

  public function ajaxActivarDispositivo(){



    $estado = ModeloDispositivos::mdlActualizarDispositivo("dispositivos", "estado", $this->activarDispositivo, "id", $this->activarId);
  

    echo $estado;


  }

  /*=============================================
  VALIDAR NO REPETIR DISPOSITIVO
  =============================================*/ 

  public $validarDispositivo;

  public function ajaxValidarDispositivo(){

    $item = "modelo";
    $valor = $this->validarDispositivo;

    $respuesta = ControladorDispositivos::ctrMostrarDispositivos($item, $valor);

    echo json_encode($respuesta);

  }

  /*=============================================
  EDITAR DISPOSITIVO
  =============================================*/ 

  public $idDispositivo;

  public function ajaxEditarDispositivo(){

    $item = "id";
    $valor = $this->idDispositivo;

    $respuesta = ControladorDispositivos::ctrMostrarDispositivos($item, $valor);

    echo json_encode($respuesta);

  }

}

/*=============================================
ACTIVAR DISPOSITIVO
=============================================*/

if(isset($_POST["activarDispositivo"])){

	$activarDispositivo = new AjaxDispositivos();
	$activarDispositivo -> activarDispositivo = $_POST["activarDispositivo"];
	$activarDispositivo -> activarId = $_POST["activarId"];
	$activarDispositivo -> ajaxActivarDispositivo();

}

/*=============================================
VALIDAR NO REPETIR DISPOSITIVO
=============================================*/

if(isset( $_POST["validarDispositivo"])){

  $valDispositivo = new AjaxDispositivos();
  $valDispositivo -> validarDispositivo = $_POST["validarDispositivo"];
  $valDispositivo -> ajaxValidarDispositivo();

}

/*=============================================
EDITAR DISPOSITIVO
=============================================*/
if(isset($_POST["idDispositivo"])){

  $editar = new AjaxDispositivos();
  $editar -> idDispositivo = $_POST["idDispositivo"];
  $editar -> ajaxEditarDispositivo();

}

/*=============================================
MOSTRAR FLOTAS
=============================================*/

if(isset($_POST["mostrar"])){

  $mostrarFlota = new AjaxDispositivos();
  $mostrarFlota -> ajaxMostrarDispositivos();

}

