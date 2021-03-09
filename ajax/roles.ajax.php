<?php 

require "../controladores/roles.controlador.php";
require "../modelos/roles.modelo.php";


Class ajaxRoles{


  /*=============================================
  MOSTRAR PERMISOS
  =============================================*/ 

  public $idRol;

  public function ajaxMostrarPermisos(){



    $item = "rol";
    $valor = $this->idRol;

    $permisos = ControladorRoles::ctrMostrarPermisos($item, $valor);

    echo json_encode($permisos);

  }
  /*=============================================
  GUARDAR PERMISOS
  =============================================*/ 

  public $idRolGuardar;
  public $Palmacen;
  public $Pcompras;
  public $Pventas;
  public $Pvehiculos;
  public $Padministracion;
  public $Ptecnico;

  public function ajaxGuardarPermisos(){

    $datos = array("almacen"=>$this->Palmacen,
                "id"=>$this->idRolGuardar,
                "compras"=>$this->Pcompras,
                "ventas"=>$this->Pventas,
                "vehiculos"=>$this->Pvehiculos,
                "administracion"=>$this->Padministracion,
                "tecnico"=>$this->Ptecnico
                );

      $respuesta = ControladorRoles::ctrGuardarPermisos($datos);



     echo $respuesta;
    

  }

}




/*=============================================
MOSTRAR PERMISOS
=============================================*/
if (isset($_POST["idRol"])) {


	$mostrarPermisos = new ajaxRoles;
	$mostrarPermisos -> idRol = $_POST["idRol"];
	$mostrarPermisos -> ajaxMostrarPermisos();
	# code...
}


/*=============================================
MOSTRAR PERMISOS
=============================================*/
if (isset($_POST["idRolGuardar"])) {


  $guardarPermisos = new ajaxRoles;
  $guardarPermisos -> idRolGuardar = $_POST["idRolGuardar"];
  $guardarPermisos -> Palmacen = $_POST["Palmacen"];
  $guardarPermisos -> Pcompras = $_POST["Pcompras"];
  $guardarPermisos -> Pventas = $_POST["Pventas"];
  $guardarPermisos -> Pvehiculos = $_POST["Pvehiculos"];
  $guardarPermisos -> Padministracion = $_POST["Padministracion"];
  $guardarPermisos -> Ptecnico = $_POST["Ptecnico"];
  $guardarPermisos -> ajaxGuardarPermisos();
  # code...
}

 ?>