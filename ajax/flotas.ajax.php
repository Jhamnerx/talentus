<?php

require_once "../controladores/flotas.controlador.php";
require_once "../modelos/flotas.modelo.php";



/**
 * 
 */
class ajaxFlotas{
	
  /*=============================================
  ACTIVAR FLOTA
  =============================================*/	

  public $activarFlota;
  public $activarId;

	public function ajaxActivarFlota()
	{


    $estado = ModeloFlotas::mdlActualizarFlota("flota", "estado", $this->activarFlota, "id", $this->activarId);
  

    echo $estado;
	}

  /*=============================================
  MOSTRAR FLOTAS
  =============================================*/ 

  public $idFlota;

  public function ajaxMostrarFlotas(){



    $item = $this->itemFlota;
    $valor = $this->idFlota;

    $flotas = ControladorFlotas::ctrMostrarFlotas($item, $valor);

    echo json_encode($flotas);

  }

  /*=============================================
  CREAR FLOTAS
  =============================================*/ 

  public $nombreFlota;
  public $idcliente;

  public function ajaxCrearFlotas(){

      $datos = array("flota"=>strtoupper($this->nombreFlota),
               "cliente"=>$this->idcliente,
               "estado"=> 1);

    $respuesta = ControladorFlotas::ctrCrearFlotaVehiculo($item, $valor);

    echo $respuesta;

  }

}
/*=============================================
ACTIVAR FLOTAS
=============================================*/

if(isset($_POST["activarFlota"])){

  $activarFlota = new AjaxFlotas();
  $activarFlota -> activarFlota = $_POST["activarFlota"];
  $activarFlota -> activarId = $_POST["activarId"];
  $activarFlota -> ajaxActivarFlota();

}
/*=============================================
MOSTRAR FLOTAS
=============================================*/

if(isset($_POST["idFlota"])){

  $mostrarFlota = new ajaxFlotas();
  $mostrarFlota -> idFlota = $_POST["idFlota"];
  $mostrarFlota -> itemFlota = $_POST["item"];
  $mostrarFlota -> ajaxMostrarFlotas();

}

/*=============================================
CREAR FLOTAS
=============================================*/


if(isset($_POST["nombreFlota"])){

  $crearFlota = new ajaxFlotas();
  $crearFlota -> nombreFlota = $_POST["nombreFlota"];
  $crearFlota -> idcliente = $_POST["idcliente"];
  $crearFlota -> ajaxCrearFlotas();

}

?>