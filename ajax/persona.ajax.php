<?php

require_once "../controladores/persona.controlador.php";
require_once "../modelos/persona.modelo.php";


class AjaxPersona{

  /*=============================================
  ACTIVAR PERSONA
  =============================================*/

  public $activarPersona;
  public $activarId;

  public function ajaxActivarPersona(){



    $estado = ModeloPersona::mdlActualizarPersona("persona", "estado", $this->activarPersona, "id", $this->activarId);


    echo $estado;


  }
  /*=============================================
  MOSTRAR PERSONAS
  =============================================*/

  public $tipoPersona;

  public function ajaxMostrarPersonas(){



    $item = "tipo";
    $valor = $this->tipoPersona;
    $count = 0;

    $persona = ControladorPersona::ctrMostrarPersona($item, $valor, $count);

    echo json_encode($persona);

  }

  /*=============================================
  GUARDAR PERSONA
  =============================================*/

  public $tipo;
  public $nombrePersona;
  public $apellidoPersona;
  public $tipoDocumento;
  public $numDocumento;
  public $direccionPersona;
  public $telefonoPersona;
  public $emailPersona;

  public function ajaxGuardarPersona(){
    $datos = array("tipo"=>$this->tipo,
             "nombre"=>strtoupper(trim($this->nombrePersona)),
             "apellido"=>isset($this->apellidoPersona)? strtoupper(trim($this->apellidoPersona)):null,
             "tipo_documento"=>$this->tipoDocumento,
             "num_documento"=>$this->numDocumento,
             "direccion"=>trim($this->direccionPersona),
             "telefono"=>$this->telefonoPersona,
             "email"=>$this->emailPersona
            );

  $respuesta = ControladorPersona::ctrGuardarPersona($datos);

  echo $respuesta;


  }


  /*=============================================
  MOSTRAR PERSONA
  =============================================*/

  public $idPersona;

  public function ajaxMostrarPersona(){

    $item = "id";
    $valor = $this->idPersona;
    $count = 1;

    $respuesta = ControladorPersona::ctrMostrarPersona($item, $valor, $count);

    echo json_encode($respuesta);

  }
  /*=============================================
  MOSTRAR PERSONA
  =============================================*/

  public $NombreCliente;

  public function ajaxMostrarPersonaNombre(){

    $item = "nombre";
    $valor = $this->NombreCliente;
    $count = 1;

    $respuesta = ControladorPersona::ctrMostrarPersona($item, $valor, $count);

    echo json_encode($respuesta);

  }
  /*=============================================
  EDITAR PERSONA
  =============================================*/

  public $idEditarPersona;
  public $tipoEditarPersona;
  public $nombreEditarPersona;
  public $apellidoEditarPersona;
  public $tipoDocumentoEditarPersona;
  public $numDocumentoEditarPersona;
  public $direccionEditarPersona;
  public $telefonoEditarPersona;
  public $emailEditarPersona;

  public function ajaxEditarPersona(){

    $datos = array(
             "idPersona"=>$this->idEditarPersona,
             "tipo"=>$this->tipoEditarPersona,
             "nombre"=>trim($this->nombreEditarPersona),
             "apellido"=>trim($this->apellidoEditarPersona),
             "tipo_documento"=>$this->tipoDocumentoEditarPersona,
             "num_documento"=>$this->numDocumentoEditarPersona,
             "direccion"=>trim($this->direccionEditarPersona),
             "telefono"=>$this->telefonoEditarPersona,
             "email"=>$this->emailEditarPersona
            );

    $respuesta = ControladorPersona::ctrEditarPersona($datos);

    echo $respuesta;

  }
}


/*=============================================
ACTIVAR PERSONA
=============================================*/

if(isset($_POST["activarPersona"])){

  $activarPersona = new AjaxPersona();
  $activarPersona -> activarPersona = $_POST["activarPersona"];
  $activarPersona -> activarId = $_POST["activarId"];
  $activarPersona -> ajaxActivarPersona();

}
/*=============================================
MOSTRAR PERSONAS
=============================================*/

if(isset($_POST["tipoPersona"])){

  $mostrarPersona = new AjaxPersona();
  $mostrarPersona -> tipoPersona = $_POST["tipoPersona"];
  $mostrarPersona -> ajaxMostrarPersonas();

}
/*=============================================
GUARDAR PERSONA
=============================================*/
if (isset($_POST["guardarPersona"])) {
  $guardarPersona = new AjaxPersona();
  $guardarPersona -> tipo = $_POST["tipo"];
  $guardarPersona -> nombrePersona = $_POST["nombrePersona"];
  $guardarPersona -> apellidoPersona = $_POST["apellidoPersona"];
  $guardarPersona -> tipoDocumento = $_POST["tipoDocumento"];
  $guardarPersona -> numDocumento = $_POST["numDocumento"];
  $guardarPersona -> direccionPersona = $_POST["direccionPersona"];
  $guardarPersona -> telefonoPersona = $_POST["telefonoPersona"];
  $guardarPersona -> emailPersona = $_POST["emailPersona"];
  $guardarPersona -> ajaxGuardarPersona();
}

/*=============================================
MOSTRAR PERSONA
=============================================*/
if(isset($_POST["idPersona"])){

  $mostrarPersona = new AjaxPersona();
  $mostrarPersona -> idPersona = $_POST["idPersona"];
  $mostrarPersona -> ajaxMostrarPersona();

}

/*=============================================
MOSTRAR PERSONA
=============================================*/
if(isset($_POST["NombreCliente"])){

  $mostrarPersona = new AjaxPersona();
  $mostrarPersona -> NombreCliente = $_POST["NombreCliente"];
  $mostrarPersona -> ajaxMostrarPersonaNombre();

}

/*=============================================
EDITAR PERSONA
=============================================*/
if(isset($_POST["idEditarPersona"])){

  $editarPersona = new AjaxPersona();
  $editarPersona -> idEditarPersona = $_POST["idEditarPersona"];
  $editarPersona -> tipoEditarPersona = $_POST["tipo"];
  $editarPersona -> nombreEditarPersona = $_POST["nombrePersona"];
  $editarPersona -> apellidoEditarPersona = $_POST["apellidoPersona"];
  $editarPersona -> tipoDocumentoEditarPersona = $_POST["tipoDocumento"];
  $editarPersona -> numDocumentoEditarPersona = $_POST["numDocumento"];
  $editarPersona -> direccionEditarPersona = $_POST["direccionPersona"];
  $editarPersona -> telefonoEditarPersona = $_POST["telefonoPersona"];
  $editarPersona -> emailEditarPersona = $_POST["emailPersona"];
  $editarPersona -> ajaxEditarPersona();

}
