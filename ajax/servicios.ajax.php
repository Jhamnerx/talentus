<?php

require_once "../controladores/servicios.controlador.php";
require_once "../modelos/servicios.modelo.php";


class AjaxServicios{

  /*=============================================
  ACTIVAR SERVICIO
  =============================================*/	

  public $activarServicio;
  public $activarId;

  public function ajaxActivarServicio(){


  	$respuesta = ModeloServicios::mdlActualizarServicios("servicios", "estado", $this->activarServicio, "id", $this->activarId);

  	echo $respuesta;

  }


  /*=============================================
  EDITAR SERVICIO
  =============================================*/ 

  public $idServicio;

  public function ajaxEditarServicio(){

    $item = "id";
    $valor = $this->idServicio;

    $respuesta = ControladorServicios::ctrMostrarServicios($item, $valor);

    echo json_encode($respuesta);

  }

}

/*=============================================
ACTIVAR Servicio
=============================================*/

if(isset($_POST["activarServicio"])){

	$activarServicio = new AjaxServicios();
	$activarServicio -> activarServicio = $_POST["activarServicio"];
	$activarServicio -> activarId = $_POST["activarId"];
	$activarServicio -> ajaxActivarServicio();

}

/*=============================================
EDITAR SERVICIO
=============================================*/
if(isset($_POST["idServicio"])){

  $editar = new AjaxServicios();
  $editar -> idServicio = $_POST["idServicio"];
  $editar -> ajaxEditarServicio();

}
