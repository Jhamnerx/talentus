<?php 


require_once "../controladores/cobros.controlador.php";
require_once "../modelos/cobros.modelo.php";

/**
 * MOSTRAR INFO REGISTRO
 */


class AjaxCobros
{
	public $idCobro;

	public function ajaxMostrarInfoCobro(){

		$item = "id";
		$valor = $this->idCobro;

		$respuesta = ControladorCobros::ctrMostrarCobros($item, $valor);
		echo json_encode($respuesta);
		
	}

	public $idCobroRegistro;

	public function ajaxMostrarRegistroCobro(){

		$item = "idcobro";
		$valor = $this->idCobroRegistro;

		$respuesta = ControladorCobros::ctrMostrarRegistroCobro($item, $valor);
		echo json_encode($respuesta);
		
	}
}

/*=============================================
MOSTRAR INFO REGISTRO
=============================================*/
if(isset($_POST["idCobro"])){

  $editar = new AjaxCobros();
  $editar -> idCobro = $_POST["idCobro"];
  $editar -> ajaxMostrarInfoCobro();

}



if(isset($_POST["idCobroRegistro"])){

  $verRegistro = new AjaxCobros();
  $verRegistro -> idCobroRegistro = $_POST["idCobroRegistro"];
  $verRegistro -> ajaxMostrarRegistroCobro();

}

 ?>