<?php

// if($_SESSION["perfil"] != "administrador"){

// echo '<script>

//   window.location = "inicio";

// </script>';

// return;

// }

?>
<div class="content-wrapper">

  <section class="content-header">

    <h1>
      Gestor plantilla
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Gestor plantilla</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">

      <div class="col-md-6 col-xs-12">
        
      <!--=====================================
      BLOQUE 1
      ======================================-->
      
      <?php

        /*=============================================
        ADMINISTRACIÓN DE LOGOTIPO E ICONO
        =============================================*/

        include "plantilla/logotipo.php";

        /*=====================================
        ADMINISTRAR COLORES
        ======================================*/
  
        
        //include "plantilla/colores.php";

        /*=====================================
        ADMINISTRAR REDES SOCIALES
        ======================================*/
  
        //include "plantilla/redSocial.php";

        /*=====================================
        ADMINISTRAR DATOS EMPRESA
        ======================================*/

        //include "plantilla/empresa.php";
        
      ?>
      
      </div>


      <div class="col-md-6 col-xs-12">
        
      <!--=====================================
      BLOQUE 2
      ======================================-->

        <?php
        
       /*=====================================
        ADMINISTRAR ROLES
        ======================================*/
  
        include "plantilla/roles.php";

        /*=====================================
        ADMINISTRAR COMERCIO
        ======================================*/
  
        //include "plantilla/informacion.php";


        /*=====================================
        ADMINISTRAR DATOS EMPRESA
        ======================================*/

        include "plantilla/empresa.php";
        ?>
   
      </div>

    </div>
 
  </section>

</div>