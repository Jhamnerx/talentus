<?php

require_once "../controladores/categorias.controlador.php";
require_once "../modelos/categorias.modelo.php";
require_once "../modelos/servicios.modelo.php";


class AjaxCategorias{

  /*=============================================
  ACTIVAR CATEGORIA
  =============================================*/	

  public $activarCategoria;
  public $activarId;

  public function ajaxActivarCategoria(){



    $estado = ModeloCategorias::mdlActualizarCategoria("categorias", "estado", $this->activarCategoria, "id", $this->activarId);
  

    echo $estado;


  }

  /*=============================================
  VALIDAR NO REPETIR CATEGORÍA
  =============================================*/ 

  public $validarCategoria;

  public function ajaxValidarCategoria(){

    $item = "categoria";
    $valor = $this->validarCategoria;

    $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);

    echo json_encode($respuesta);

  }

  /*=============================================
  EDITAR CATEGORIA
  =============================================*/ 

  public $idCategoria;

  public function ajaxEditarCategoria(){

    $item = "id";
    $valor = $this->idCategoria;

    $respuesta = ControladorCategorias::ctrMostrarCategorias($item, $valor);

    echo json_encode($respuesta);

  }

}

/*=============================================
ACTIVAR CATEGORIA
=============================================*/

if(isset($_POST["activarCategoria"])){

	$activarCategoria = new AjaxCategorias();
	$activarCategoria -> activarCategoria = $_POST["activarCategoria"];
	$activarCategoria -> activarId = $_POST["activarId"];
	$activarCategoria -> ajaxActivarCategoria();

}

/*=============================================
VALIDAR NO REPETIR CATEGORÍA
=============================================*/

if(isset( $_POST["validarCategoria"])){

  $valCategoria = new AjaxCategorias();
  $valCategoria -> validarCategoria = $_POST["validarCategoria"];
  $valCategoria -> ajaxValidarCategoria();

}

/*=============================================
EDITAR CATEGORIA
=============================================*/
if(isset($_POST["idCategoria"])){

  $editar = new AjaxCategorias();
  $editar -> idCategoria = $_POST["idCategoria"];
  $editar -> ajaxEditarCategoria();

}

