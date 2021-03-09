<html lang="es">
<head>
  <?php

    /*=============================================
    MANTENER LA RUTA FIJA DEL PROYECTO
    =============================================*/

    $url = Ruta::ctrRuta();

    $datosEmpresa = ModeloPlantilla::mdlSeleccionarPlantilla("plantilla");

    $datos = json_decode($datosEmpresa["empresa"],true);



  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $datos[0]["nombre"]; ?></title>
  <meta name="theme-color" content="#052c52" />

  <link rel="icon" href="<?php echo $url; ?>vistas/img/plantilla/icono.png">

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!--=====================================
  PLUGINS DE CSS
  ======================================-->
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="<?php echo $url; ?>vistas/dist/css/skins/_all-skins.css">

  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/js/plugins/iCheck/all.css">

  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/morris.js/morris.css">

   <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/jvectormap/jquery-jvectormap.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

   <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">

  <!-- bootstrap slider -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/js/plugins/bootstrap-slider/slider.css">

  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/css/buttons.dataTables.css">

  <!-- bootstrap tags input -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/js/plugins/tags/bootstrap-tagsinput.css">

  <!-- bootstrap datepicker -->
   <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">

  <!-- Dropzone -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/js/plugins/dropzone/dropzone.css">
  <!-- IZITOAST -->
   <link rel="stylesheet" href="<?php echo $url; ?>vistas/js/plugins/izitoast/iziToast.min.css">

   <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/plugins/sweetalert.css">

   <link rel="stylesheet" href="<?php echo $url; ?>vistas/js/plugins/croppie/croppie.css">


   <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

  <!--=====================================
  CSS PERSONALIZADO
  ======================================-->

  <link rel="stylesheet" href="<?php echo $url; Utiles::auto_version('vistas/css/plantilla.css'); ?>" type="text/css">

  <link rel="stylesheet" href="<?php echo $url; Utiles::auto_version('vistas/css/login.css');?>" type="text/css" >
  <link rel="stylesheet" href="<?php echo $url; Utiles::auto_version('vistas/css/formstyle.css');?>" type="text/css" >
  <link rel="stylesheet" href="<?php echo $url; Utiles::auto_version('vistas/css/usuarios.css');?>" type="text/css" >
  <link rel="stylesheet" href="<?php echo $url; Utiles::auto_version('vistas/css/whatsapp.css');?>" type="text/css" >
  <link rel="stylesheet" href="<?php echo $url; Utiles::auto_version('vistas/css/slide.css');?>" type="text/css" >



  <!--=====================================
  PLUGINS DE JAVASCRIPT
  ======================================-->

  <!-- jQuery 3 -->
  <script src="<?php echo $url; ?>vistas/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo $url; ?>vistas/bower_components/jquery/dist/jquery.autocomplete.js"></script>
  <script src="<?php echo $url; ?>vistas/bower_components/jquery/dist/jquery.mockjax.js"></script>

  <!-- jQuery UI 1.11.4 -->
  <script src="<?php echo $url; ?>vistas/bower_components/jquery-ui/jquery-ui.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo $url; ?>vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- AdminLTE App -->
  <script src="<?php echo $url; ?>vistas/dist/js/adminlte.min.js"></script>

  <!-- iCheck http://icheck.fronteed.com/-->
  <script src="<?php echo $url; ?>vistas/js/plugins/iCheck/icheck.min.js"></script>

    <!-- Morris.js charts -->
  <script src="<?php echo $url; ?>vistas/bower_components/raphael/raphael.min.js"></script>

  <script src="<?php echo $url; ?>vistas/bower_components/morris.js/morris.min.js"></script>

  <!-- jQuery Knob Chart -->
  <script src="<?php echo $url; ?>vistas/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>

  <!-- jvectormap -->
  <script src="<?php echo $url; ?>vistas/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>

  <script src="<?php echo $url; ?>vistas/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

  <!-- ChartJS -->
  <script src="<?php echo $url; ?>vistas/bower_components/chart.js/Chart.js"></script>

  <!-- SweetAlert 2 https://sweetalert2.github.io/-->
  <script src="<?php echo $url; ?>vistas/js/plugins/sweetalert2/sweetalert2.all.js"></script>

  <!-- bootstrap color picker https://farbelous.github.io/bootstrap-colorpicker/v2/-->
  <script src="<?php echo $url; ?>vistas/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

  <!-- Bootstrap slider http://seiyria.com/bootstrap-slider/-->
  <script src="<?php echo $url; ?>vistas/js/plugins/bootstrap-slider/bootstrap-slider.js"></script>

  <!-- DataTables https://datatables.net/-->
  <script src="<?php echo $url; ?>vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
  <script src="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
  <script src="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/js/buttons.colVis.min.js"></script>
  <script src="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/js/buttons.html5.min.js"></script>
  <script src="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/js/pdfmake.min.js"></script>
  <script src="<?php echo $url; ?>vistas/bower_components/datatables.net-bs/js/vfs_fonts.js"></script>

  <!-- bootstrap tags input https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/-->
  <script src="<?php echo $url; ?>vistas/js/plugins/tags/bootstrap-tagsinput.min.js"></script>

   <!-- bootstrap datetimepicker http://bootstrap-datepicker.readthedocs.io-->
  <script src="<?php echo $url; ?>vistas/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

   <!-- Dropzone http://www.dropzonejs.com/-->
  <script src="<?php echo $url; ?>vistas/js/plugins/dropzone/dropzone.js"></script>

   <!-- IZITOAST -->

   <script src="<?php echo $url; ?>vistas/js/plugins/izitoast/iziToast.min.js"></script>
   <script src="<?php echo $url; ?>vistas/js/plugins/croppie/croppie.min.js"></script>

   <script src="<?php echo $url; ?>vistas/js/plugins/kendo.all.min.js"></script>

  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo $url; ?>vistas/bower_components/select2/dist/css/select2.css">
  <script src="<?php echo $url; ?>vistas/bower_components/select2/dist/js/select2.full.js"></script>
</head>
<!-- <body  onload="loaderPagina()"> -->



<?php
if (isset($_SESSION["validarSesion"]) && $_SESSION["validarSesion"] == "ok") {
  echo '<body onload="loaderPagina()" class="hold-transition skin-yellow-light sidebar-mini login-page">';

    echo '<div class="wrapper">';

    echo '
    <div class="spinner-content" id="spinner-content" align="center">
    <div class="spinner">
        <div class="rect1"></div>
        <div class="rect2"></div>
        <div class="rect3"></div>
        <div class="rect4"></div>
        <div class="rect5"></div>
    </div>
</div>';

    /*=============================================
     CABEZOTE
     =============================================*/

     include "modulos/cabezote.php";

    /*=============================================
     LATERAL
     =============================================*/

     include "modulos/lateral.php";

     /*=============================================
     CONTENIDO
     =============================================*/

    $rutas = array();

    if(isset($_GET["ruta"])){

      $rutas = explode("/", $_GET["ruta"]);

      $ruta = $rutas[0];

    }else{

      $ruta = "inicio";

    }


     if(isset($_GET["ruta"])){

        if($rutas[0] == "inicio" ||
           $rutas[0] == "almacen" ||
           $rutas[0] == "almacenes" ||
           $rutas[0] == "categorias" ||
           $rutas[0] == "servicios" ||
           $rutas[0] == "compras" ||
           $rutas[0] == "gps" ||
           $rutas[0] == "sim" ||
           $rutas[0] == "proveedor" ||
           $rutas[0] == "ingresos" ||
           $rutas[0] == "clientes" ||
           $rutas[0] == "ventas" ||
           $rutas[0] == "contratos" ||
           $rutas[0] == "flota" ||
           $rutas[0] == "contacto" ||
           $rutas[0] == "vehiculo" ||
           $rutas[0] == "acta" ||
           $rutas[0] == "usuarios" ||
           $rutas[0] == "dispositivos" ||
           $rutas[0] == "cobros" ||
           $rutas[0] == "lineas" ||
           $rutas[0] == "ciudad" ||
           $rutas[0] == "plantilla" ||
           $rutas[0] == "salir" ||
           $rutas[0] == "reporte" ||
           $rutas[0] == "gps" ||
           $rutas[0] == "recibir" ||
           $rutas[0] == "perfil" ||
           $rutas[0] == "tareas" ||
           $rutas[0] == "notificaciones" ||
           $rutas[0] == "recibo" ||
           $rutas[0] == "slide" ||
           $rutas[0] == "certificado"){


            include "modulos/".$rutas[0].".php";



        }else{

          include "modulos/inicio.php";
        }

     }else{

        include "modulos/inicio.php";

     }

     /*=============================================
     FOOTER
     =============================================*/

     include "modulos/footer.php";


    echo '</div>';

 }else{

  include "modulos/login.php";

 }





?>

<!--=====================================
JS PERSONALIZADO
======================================-->
<input type="hidden" class="rutaOculta" value="<?php echo $url?>">
<script src="<?php echo $url; Utiles::auto_version('vistas/js/plantilla.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorPersona.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorCategorias.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorServicios.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorAlmacenes.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorProveedor.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorClientes.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorIngresos.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorVentas.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorUsuarios.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorDispositivos.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorContratos.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorVehiculos.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorFlotas.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorContacto.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorActas.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorCiudad.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorCertificados.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorCobros.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorNotificaciones.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorRoles.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorLineas.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorReportes.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorTareas.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorTecnicos.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorRecibos.js'); ?>"></script>
<script src="<?php echo $url; Utiles::auto_version('vistas/js/gestorSlide.js'); ?>"></script>


<script src="<?php echo $url; ?>vistas/js/whatsapp.js"></script>



</body>

</html>
