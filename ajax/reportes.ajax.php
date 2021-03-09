<?php

require_once "../controladores/reportes.controlador.php";
require_once "../modelos/reportes.modelo.php";


class AjaxReportes{

  /*=============================================
  CAMBIAR ESTADO REPORTE
  =============================================*/	

  public $activarReporte;
  public $activarId;

  public function ajaxCambiarReporte(){



    $estado = ModeloReportes::mdlActualizarReporte("reportes", "estado", $this->activarReporte, "id", $this->activarId);
  

    echo $estado;


  }

  /*=============================================
  EDITAR DETALLES
  =============================================*/ 

  public $idReporte;

  public function ajaxEditarReporte(){

    $item = "id";
    $valor = $this->idReporte;

    $respuesta = ControladorReportes::ctrMostrarReportes($item, $valor);

    echo json_encode($respuesta);

  }
  /*=============================================
 MOSTRAR DETALLES
  =============================================*/ 

  public $idDetalleReporte;

  public function ajaxDetalleReporte(){

    $item = "id_reporte";
    $valor = $this->idDetalleReporte;

    $respuesta = ControladorReportes::ctrMostrarDetallesReportes($item, $valor);

    echo json_encode($respuesta);

  }
  
}

/*=============================================
CAMBIAR ESTADOS
=============================================*/

if(isset($_POST["activarReporte"])){

	$activarReporte = new AjaxReportes();
	$activarReporte -> activarReporte = $_POST["activarReporte"];
	$activarReporte -> activarId = $_POST["activarId"];
	$activarReporte -> ajaxCambiarReporte();

}

/*=============================================
EDITAR CATEGORIA
=============================================*/
if(isset($_POST["idReporte"])){

  $editar = new AjaxReportes();
  $editar -> idReporte = $_POST["idReporte"];
  $editar -> ajaxEditarReporte();

}

/*=============================================
DETALLE REPORTE
=============================================*/
if(isset($_POST["idDetalleReporte"])){

  $detalle = new AjaxReportes();
  $detalle -> idDetalleReporte = $_POST["idDetalleReporte"];
  $detalle -> ajaxDetalleReporte();

}
