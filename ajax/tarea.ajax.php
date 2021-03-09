<?php

require_once "../controladores/tarea.controlador.php";
require_once "../controladores/dispositivos.controlador.php";
require_once "../controladores/vehiculos.controlador.php";
require_once "../controladores/usuarios.controlador.php";

require_once "../modelos/tarea.modelo.php";
require_once "../modelos/dispositivos.modelo.php";
require_once "../modelos/vehiculos.modelo.php";
require_once "../modelos/usuarios.modelo.php";


class AjaxTarea{
  /*=============================================
  MOSTRAR TAREA NO LEIDA
  =============================================*/ 

  public function ajaxMostrarTareasNoLeidas(){
    setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');

    $tabla = "tareas";

    $datos = ModeloTarea::mdlMostrarTareas($tabla, "leido", "0");

    //var_dump($datos);
  

    if (count($datos)){

      $datanew = [];

      foreach ($datos as $key =>  $value) {

        $dispositivo = ControladorDispositivos::ctrMostrarDispositivos("id", $value["dispositivo"]);
        $vehiculo = ControladorVehiculos::ctrMostrarVehiculos("id", $value["vehiculo"]);
        $tipo = ControladorTareas::ctrMostrarTipoTareas("id", $value["tipo"]);
        $usuarios = ControladorUsuarios::ctrMostrarUsuarios("id", $value["id_admin"]);

        // code...
        $datacol['key']  = ($key+1);
        $datacol['id']  = $value['id'];
        $datacol['tipo']  = $tipo["tipo"];
        $datacol['id_admin']  = $usuarios['nombre'];

        $vehiculo = ControladorVehiculos::ctrMostrarVehiculos("id", $value['vehiculo']);

        $fecha = iconv('ISO-8859-2', 'UTF-8', strftime("%d de %B de %Y", strtotime($value["fecha"]))).'</p>';


        $datacol['descripcion'] = "<p>".$tipo["tipo"]." de GPS ".$dispositivo["modelo"]." en el vehiculo ".$vehiculo["placa"].",</p> <p>Fecha y Hora de instalacion ".$fecha." 01:30 PM</p>";


        $datacol['vehiculo']  = $vehiculo['placa'];
        $datacol['cliente']  = $value['cliente'];
        $datacol['leido']  = $value['leido'];
        $datacol['estado']  = $value['estado'];
        $datacol['fecha']  = $value['fecha'];


        $estado = ModeloTarea::mdlActualizarTarea("tareas", "leido", "1", "id", $value['id']);

        array_push($datanew,$datacol);
      }

      $response['registro'] = $datanew;
      $response['success'] = true;
    }
    else {
      $response['registro'] = null;
      $response['success'] = false;
    }

    // respuesta en json
    echo json_encode($response);


  }



  /*=============================================
  ACTUALIZAR TAREA
  =============================================*/	

  public $actualizarItemTarea;
  public $actualizarId;
  public $valorTarea;

  public function ajaxActualizarTarea(){



    $estado = ModeloTarea::mdlActualizarTarea("tareas", $this->actualizarItemTarea, $this->valorTarea, "id", $this->actualizarId);
  

    echo $estado;


  }

  /*=============================================
  EDITAR TAREA
  =============================================*/ 

  public $idTarea;

  public function ajaxEditarTarea(){

    $item = "id";
    $valor = $this->idTarea;

    $respuesta = ControladorTareas::ctrMostrarTareas($item, $valor);

    echo json_encode($respuesta);

  }

}

/*=============================================
ACTUALIZAR TAREA
=============================================*/

if(isset($_POST["actualizarItemTarea"])){

	$actualizarTarea = new AjaxTarea();
	$actualizarTarea -> actualizarItemTarea = $_POST["actualizarItemTarea"];
	$actualizarTarea -> actualizarId = $_POST["actualizarId"];
  $actualizarTarea -> valorTarea = $_POST["valorTarea"];
	$actualizarTarea -> ajaxActualizarTarea();

}


/*=============================================
EDITAR TAREA
=============================================*/
if(isset($_POST["idTarea"])){

  $editar = new AjaxTarea();
  $editar -> idTarea = $_POST["idTarea"];
  $editar -> ajaxEditarTarea();

}

/*=============================================
MOSTRAR TAREAS NO LEIDAS
=============================================*/ 
if(isset($_GET["verTareasNoleidas"])){
  $mostrar = new AjaxTarea();
  $mostrar -> ajaxMostrarTareasNoLeidas();
}