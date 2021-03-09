<?php

require_once "../controladores/contratos.controlador.php";
require_once "../modelos/contratos.modelo.php";


class AjaxContratos{

  /*=============================================
    GUARDAR Contrato
    =============================================*/ 
    public $idcliente;
    public $fechaContrato;
    public $ciudad;
    public $fondo;
    public $sello;
    public $idvehiculo;
    public $placa;
    public $plan;



  public function ajaxGuardarContrato()
  {

      $datos = array("idcliente"=>$this->idcliente,
               "fechaContrato"=>$this->fechaContrato,
               "ciudad"=>$this->ciudad,
               "fondo"=>$this->fondo,
               "sello"=>$this->sello,
               "idvehiculo"=>$this->idvehiculo,
               "plan"=>$this->plan
              );

    $respuesta = ControladorContratos::ctrGuardarContrato($datos);

   echo json_encode(1);
  }
  /*=============================================
  ACTIVAR CONTRATO
  =============================================*/	

  public $activarContrato;
  public $activarId;

  public function ajaxActivarContrato(){



    $estado = ModeloContratos::mdlActualizarContrato("contrato", "estado", $this->activarContrato, "id", $this->activarId);
  

    echo $estado;


  }
  /*=============================================
  ACTUALIZAR CARACTERISTICAA CONTRATO
  =============================================*/ 

  public $caracteristica;
  public $estado;
  public $idContratoCaract;

  public function ajaxActualizarContrato(){

    $tabla = "contrato";

    $respuesta = ModeloContratos::mdlActualizarContrato($tabla, $this->caracteristica, $this->estado, "id", $this->idContratoCaract);

    echo $this->caracteristica;
    echo $this->estado;
    echo $this->idContratoCaract;

  }

  /*=============================================
  EDITAR CONTRATO
  =============================================*/ 

  public $idContrato;

  public function ajaxEditarContrato(){

    $item = "id";
    $valor = $this->idContrato;

    $respuesta = ControladorContratos::ctrMostrarContratos($item, $valor, 1);

    echo json_encode($respuesta);

  }

}

/*=============================================
ACTIVAR CONTRATO
=============================================*/

if(isset($_POST["activarContrato"])){

	$activarContrato = new AjaxContratos();
	$activarContrato -> activarContrato = $_POST["activarContrato"];
	$activarContrato -> activarId = $_POST["activarId"];
	$activarContrato -> ajaxActivarContrato();

}

/*=============================================
ACTUALIZAR CARACTERITICA
=============================================*/

if(isset($_POST["caracteristica"])){

  $CaracteristicaContrato = new AjaxContratos();
  $CaracteristicaContrato -> caracteristica = $_POST["caracteristica"];
  $CaracteristicaContrato -> estado = $_POST["estado"];
  $CaracteristicaContrato -> idContratoCaract = $_POST["idContratoCaract"];
  $CaracteristicaContrato -> ajaxActualizarContrato();

}

/*=============================================
EDITAR CONTRATO
=============================================*/
if(isset($_POST["idContrato"])){

  $editar = new AjaxContratos();
  $editar -> idContrato = $_POST["idContrato"];
  $editar -> ajaxEditarContrato();

}


/*=============================================
GUARDAR Venta
=============================================*/
if (isset($_POST["idcliente"])) {

  $guardarContrato = new AjaxContratos();
  $guardarContrato -> idcliente = $_POST["idcliente"];
  $guardarContrato -> fechaContrato = $_POST["fechaContrato"];
  $guardarContrato -> ciudad = $_POST["ciudad"];
  if (isset($_POST["sello"])) {

    $guardarContrato -> sello = 1;
    
  }else{

    $guardarContrato -> sello = 0;

  }
  if (isset($_POST["fondo"])) {

    $guardarContrato -> fondo = 1;
    
  }else{

    $guardarContrato -> fondo = 0;

  }

  $guardarContrato -> idvehiculo = $_POST["idvehiculo"];
  $guardarContrato -> plan = $_POST["plan"];
  $guardarContrato -> ajaxGuardarContrato();

}