<?php

require_once "../controladores/certificado.controlador.php";
require_once "../modelos/certificado.modelo.php";



/**
 * 
 */
class ajaxCertificados{
	
  /*=============================================
  ACTIVAR FLOTA
  =============================================*/	

  public $activarCertificado;
  public $activarId;

	public function ajaxActivarCertificado()
	{


    $estado = ModeloCertificados::mdlActualizarCertificado("certificado", "estado", $this->activarCertificado, "id", $this->activarId);
  

    echo $estado;
	}

  /*=============================================
  MOSTRAR FLOTAS
  =============================================*/ 

  public $idCertificado;

  public function ajaxMostrarCertificados(){



    $item = $this->itemCertificado;
    $valor = $this->idCertificado;

    $certificado = ControladorCertificados::ctrMostrarCertificado($item, $valor);

    echo json_encode($certificado);

  }


  /*=============================================
  ACTUALIZAR CARACTERISTICAA ACTA
  =============================================*/ 

  public $caracteristica;
  public $estado;
  public $idCertificadoCaract;

  public function ajaxActualizarCertificado(){

    $tabla = "certificado";

    $respuesta = ModeloCertificados::mdlActualizarCertificado($tabla, $this->caracteristica, $this->estado, "id", $this->idCertificadoCaract);

    echo $this->caracteristica;
    echo $this->estado;
    echo $this->idCertificadoCaract;

  }
}
/*=============================================
ACTIVAR CERTIFICADO
=============================================*/

if(isset($_POST["activarCertificado"])){

  $activarCertificado = new AjaxCertificados();
  $activarCertificado -> activarCertificado = $_POST["activarCertificado"];
  $activarCertificado -> activarId = $_POST["activarId"];
  $activarCertificado -> ajaxActivarCertificado();

}
/*=============================================
MOSTRAR CERTIFICADO
=============================================*/

if(isset($_POST["idCertificado"])){

  $mostrarCertificado = new ajaxCertificados();
  $mostrarCertificado -> idCertificado = $_POST["idCertificado"];
  $mostrarCertificado -> itemCertificado = $_POST["item"];
  $mostrarCertificado -> ajaxMostrarCertificados();

}



/*=============================================
ACTUALIZAR CARACTERITICA
=============================================*/

if(isset($_POST["caracteristica"])){

  $CaracteristicaCertificado = new AjaxCertificados();
  $CaracteristicaCertificado -> caracteristica = $_POST["caracteristica"];
  $CaracteristicaCertificado -> estado = $_POST["estado"];
  $CaracteristicaCertificado -> idCertificadoCaract = $_POST["idCertificadoCaract"];
  $CaracteristicaCertificado -> ajaxActualizarCertificado();

}

?>