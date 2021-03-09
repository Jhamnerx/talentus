<?php

require_once "../controladores/vehiculos.controlador.php";
require_once "../modelos/vehiculos.modelo.php";


class AjaxVehiculos{
  /*=============================================
  MOSTRAR VEHICULOS
  =============================================*/ 


  public function ajaxMostrarVehiculos(){


    $item = null;
    $valor = null;

    $vehiculos = ModeloVehiculos::mdlMostrarVehiculos("vehiculo", $item, $valor);

    echo json_encode($vehiculos);

  }

  /*=============================================
  MOSTRAR VEHICULO
  =============================================*/ 

  public $placaVehiculo;
  public $itemVehiculo;

  public function ajaxMostrarVehiculo(){



    $item = $this->itemVehiculo;
    $valor = $this->placaVehiculo;

    $vehiculoTarea = ModeloVehiculos::mdlMostrarVehiculos("vehiculo", $item, $valor);

    echo json_encode($vehiculoTarea);

  }
  /*=============================================
  ACTIVAR VEHICULO
  =============================================*/	

  public $activarVehiculo;
  public $activarId;

  public function ajaxActivarVehiculo(){



    $estado = ModeloVehiculos::mdlActualizarVehiculos("vehiculo", "estado", $this->activarVehiculo, "id", $this->activarId);
  

    echo $estado;


  }


  /*=============================================
  EDITAR VEHICULO
  =============================================*/ 

  public $idVehiculo;

  public function ajaxEditarVehiculo(){

    $item = "id";
    $valor = $this->idVehiculo;

    $respuesta = ControladorVehiculos::ctrMostrarVehiculos($item, $valor);

    echo json_encode($respuesta);

  }


  /*=============================================
  VALIDAR
  =============================================*/ 

  public $numeroSim;

  public function ajaxValidarSim(){

    $item = "sim";
    $valor = $this->numeroSim;

    $respuesta = ControladorVehiculos::ctrMostrarVehiculos($item, $valor);

    echo json_encode($respuesta);

  }

}

/*=============================================
ACTIVAR VEHICULO
=============================================*/

if(isset($_POST["activarVehiculo"])){

	$activarVehiculo = new AjaxVehiculos();
	$activarVehiculo -> activarVehiculo = $_POST["activarVehiculo"];
	$activarVehiculo -> activarId = $_POST["activarId"];
	$activarVehiculo -> ajaxActivarVehiculo();

}

/*=============================================
EDITAR VEHICULO
=============================================*/
if(isset($_POST["idVehiculo"])){

  $editar = new AjaxVehiculos();
  $editar -> idVehiculo = $_POST["idVehiculo"];
  $editar -> ajaxEditarVehiculo();

}

/*=============================================
MOSTRAR VEHICULOS
=============================================*/

if(isset($_POST["idvehiculoc"])){

  $mostrarVehiculos = new AjaxVehiculos();
  $mostrarVehiculos -> idVehiculoc = $_POST["idvehiculoc"];
  $mostrarVehiculos -> itemVehiculo = $_POST["item"];
  $mostrarVehiculos -> ajaxMostrarVehiculos();

}


if(isset($_POST["placaVehiculo"])){

  $mostrarVehiculo = new AjaxVehiculos();
  $mostrarVehiculo -> placaVehiculo = $_POST["placaVehiculo"];
  $mostrarVehiculo -> itemVehiculo = $_POST["item"];
  $mostrarVehiculo -> ajaxMostrarVehiculo();

}


/*=============================================
VERIFICAR SIM EXISTENTE
=============================================*/

if(isset( $_POST["numeroSim"])){

  $valSim = new AjaxVehiculos();
  $valSim -> numeroSim = $_POST["numeroSim"];
  $valSim -> ajaxValidarSim();

}
