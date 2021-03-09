<?php

require_once "../controladores/lineas.controlador.php";
require_once "../modelos/lineas.modelo.php";


class AjaxLineas{

  /*=============================================
  ACTIVAR LINEAS
  =============================================*/	

  public $activarLinea;
  public $activarId;

  public function ajaxActivarLinea(){



    $estado = ModeloLineas::mdlActualizarLinea("lineas", "estado", $this->activarLinea, "id", $this->activarId);
  

    echo $estado;


  }


  /*=============================================
  EDITAR LINEAS
  =============================================*/ 

  public $idLinea;

  public function ajaxEditarLinea(){

    $item = "id";
    $valor = $this->idLinea;

    $respuesta = ControladorLineas::ctrMostrarLineas($item, $valor);

    echo json_encode($respuesta);

  }

}

/*=============================================
ACTIVAR LINEAS
=============================================*/

if(isset($_POST["activarLinea"])){

	$activarLinea = new AjaxLineas();
	$activarLinea -> activarLinea = $_POST["activarLinea"];
	$activarLinea -> activarId = $_POST["activarId"];
	$activarLinea -> ajaxActivarLinea();

}


/*=============================================
EDITAR LINEAS
=============================================*/
if(isset($_POST["editarIdLinea"])){

  $editar = new AjaxLineas();
  $editar -> idLinea = $_POST["editarIdLinea"];
  $editar -> ajaxEditarLinea();

}

