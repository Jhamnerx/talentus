<?php

require_once "../controladores/contacto.controlador.php";
require_once "../modelos/contacto.modelo.php";
require_once "../controladores/flotas.controlador.php";
require_once "../modelos/flotas.modelo.php";
class TablaContacto{

  /*=============================================
  MOSTRAR LA TABLA DE CONTACTO
  =============================================*/ 

  public function mostrarTabla(){ 

  $item = null;
  $valor = null;

  $contacto = ControladorContacto::ctrMostrarContacto($item, $valor); 
  
  if(count($contacto) == 0){

      $datosJson = '{ "data":[]}';

      echo $datosJson;

      return;

    }

  $datosJson = '{
     
      "data": [ ';

  for($i = 0; $i < count($contacto); $i++){
  
      /*=============================================
        CREAR LAS ACCIONES
        =============================================*/

          $acciones = "<div class='btn-group'><button class='btn btn-warning btnEditarContacto' idContacto='".$contacto[$i]["id"]."' data-toggle='modal' data-target='#modalEditarContacto'><i class='fa fa-pencil'></i></button></div>";

        $flota = ControladorFlotas::ctrMostrarFlotas("id", $contacto[$i]["flota"]);

      
      $datosJson   .= '[
              "'.($i+1).'",
              "'.$contacto[$i]["nombre"].'",
              "'.$flota["nombre"].'",
              "'.$contacto[$i]["telefono"].'",
              "'.$contacto[$i]["email"].'",
              "'.$acciones.'"
            ],';

  }

  $datosJson = substr($datosJson, 0, -1);

  $datosJson.=  ']
      
  }'; 

  echo $datosJson;


  }


}

/*=============================================
ACTIVAR TABLA DE CONTACTO
=============================================*/ 
$activar = new TablaContacto();
$activar -> mostrarTabla();