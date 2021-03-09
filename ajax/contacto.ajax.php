<?php

require_once "../controladores/contacto.controlador.php";
require_once "../modelos/contacto.modelo.php";


class AjaxContacto{


  /*=============================================
  EDITAR CATEGORIA
  =============================================*/ 

  public $idContacto;

  public function ajaxEditaContacto(){

    $item = "id";
    $valor = $this->idContacto;

    $respuesta = ControladorContacto::ctrMostrarContacto($item, $valor);

    echo json_encode($respuesta);

  }

}


/*=============================================
EDITAR CATEGORIA
=============================================*/
if(isset($_POST["idContacto"])){

  $editar = new AjaxContacto();
  $editar -> idContacto = $_POST["idContacto"];
  $editar -> ajaxEditaContacto();

}

