<?php

require_once "../controladores/actas.controlador.php";
require_once "../controladores/ciudad.controlador.php";
require_once "../modelos/actas.modelo.php";
require_once "../modelos/ciudad.modelo.php";



/**
 * 
 */
class ajaxActas{
	
  /*=============================================
  ACTIVAR FLOTA
  =============================================*/	

  public $activarActa;
  public $activarId;

	public function ajaxActivarActa()
	{


    $estado = ModeloActas::mdlActualizarActa("acta", "estado", $this->activarActa, "id", $this->activarId);
  

    echo $estado;
	}

  /*=============================================
  MOSTRAR FLOTAS
  =============================================*/ 

  public $idActa;

  public function ajaxMostrarActas(){



    $item = $this->itemActa;
    $valor = $this->idActa;

    $actas = ControladorActas::ctrMostrarActa($item, $valor);

    echo json_encode($actas);

  }

  /*=============================================
  CREAR FLOTAS
  =============================================*/ 

  // public $nombreActa;
  // public $idcliente;

  // public function ajaxCrearActas(){

  //     $datos = array("flota"=>strtoupper($this->nombreActa),
  //              "cliente"=>$this->idcliente,
  //              "estado"=> 1);

  //   $respuesta = ControladorActas::ctrCrearActaVehiculo($item, $valor);

  //   echo $respuesta;

  // }
  /*=============================================
  ACTUALIZAR CARACTERISTICAA ACTA
  =============================================*/ 

  public $caracteristica;
  public $estado;
  public $idActaCaract;

  public function ajaxActualizarActa(){

    $tabla = "acta";

    $respuesta = ModeloActas::mdlActualizarActa($tabla, $this->caracteristica, $this->estado, "id", $this->idActaCaract);

    echo $this->caracteristica;
    echo $this->estado;
    echo $this->idActaCaract;

  }

  /*=============================================
  ACTUALIZAR FECHA ACTA
  =============================================*/ 

  public $idCiudadActa;
  public $idActaActualizar;
  public function ajaxActualizarFechaActa(){

    $tabla = "acta";

    $respuesta = ControladorActas::ctrActualizarFechaActa($this->idCiudadActa, $this->idActaActualizar);

    echo $respuesta;


  }

}
/*=============================================
ACTIVAR FLOTAS
=============================================*/

if(isset($_POST["activarActa"])){

  $activarActa = new AjaxActas();
  $activarActa -> activarActa = $_POST["activarActa"];
  $activarActa -> activarId = $_POST["activarId"];
  $activarActa -> ajaxActivarActa();

}
/*=============================================
MOSTRAR FLOTAS
=============================================*/

if(isset($_POST["idActa"])){

  $mostrarActa = new ajaxActas();
  $mostrarActa -> idActa = $_POST["idActa"];
  $mostrarActa -> itemActa = $_POST["item"];
  $mostrarActa -> ajaxMostrarActas();

}

/*=============================================
CREAR FLOTAS
=============================================*/


// if(isset($_POST["nombreActa"])){

//   $crearActa = new ajaxActas();
//   $crearActa -> nombreActa = $_POST["nombreActa"];
//   $crearActa -> idcliente = $_POST["idcliente"];
//   $crearActa -> ajaxCrearActas();

// }

/*=============================================
ACTUALIZAR CARACTERITICA
=============================================*/

if(isset($_POST["caracteristica"])){

  $CaracteristicaActa = new AjaxActas();
  $CaracteristicaActa -> caracteristica = $_POST["caracteristica"];
  $CaracteristicaActa -> estado = $_POST["estado"];
  $CaracteristicaActa -> idActaCaract = $_POST["idActaCaract"];
  $CaracteristicaActa -> ajaxActualizarActa();

}
/*=============================================
ACTUALIZAR fecha ACTA
=============================================*/

if(isset($_POST["idCiudadActa"])){

  $FechaActa = new AjaxActas();
  $FechaActa -> idCiudadActa = $_POST["idCiudadActa"];
  $FechaActa -> idActaActualizar = $_POST["idActaActualizar"];

  $FechaActa -> ajaxActualizarFechaActa();

}

?>