<?php 

require_once "../controladores/notifaciones.controlador.php";
require_once "../modelos/notificaciones.modelo.php";



class AjaxNotificaciones{

  /*=============================================
  LEER NOTIFACIONES
  =============================================*/	

  public $leerNotifacion;
  public $LeerId;

  public function ajaxLeerNotifacion(){



    $estado = ModeloNotificaciones::mdlActualizarNotificacion("notificaciones", "estado", $this->leerNotifacion, "id", $this->LeerId);
  

    echo $estado;


  }


}

/*=============================================
LEER NOTIFACIONES
=============================================*/

if(isset($_POST["leerNotifacion"])){

	$leerNotifacion = new ajaxLeerNotifacion();
	$leerNotifacion -> leerNotifacion = $_POST["leerNotifacion"];
	$leerNotifacion -> LeerId = $_POST["LeerId"];
	$leerNotifacion -> ajaxLeerNotifacion();

}


 ?>