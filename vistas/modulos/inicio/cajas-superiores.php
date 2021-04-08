<?php
$ventasTotales = 0;

$totalVenta = "";
$ventas = ControladorVentas::ctrMostrarVentas(null, null);


  // $valor_divisa = Ruta::currencyConverter("PEN", "USD");

  // $valor = json_encode($valor_divisa);



foreach ($ventas as $key => $value) {



  $ventasTotales+=$value["total_venta"];
}


$visitas = "";

$usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);

$servicios = ControladorServicios::ctrMostrarServicios(null, null);

$vehiculos = ControladorVehiculos::ctrMostrarVehiculos(null, null);

$clientes = ControladorPersona::ctrMostrarPersona("tipo", "Cliente", 0);

$notificaciones = ControladorNotificaciones::ctrMostrarNotificaciones(null, null);

$flotas = ControladorFlotas::ctrMostrarFlotas(null, null);


$contratos = ControladorContratos::ctrMostrarContratos(null, null, 2);

$actas = ControladorActas::ctrMostrarActa(null, null);



 ?>

<!--=====================================
CAJAS SUPERIORES
======================================-->

<!-- col -->
<div class="col-lg-3 col-xs-6">
  <div class="info-box">
    <span class="info-box-icon bg-aqua"><i class="fa fa-car"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Vehiculos</span>
      <span class="info-box-number"><?php  echo count($vehiculos); ?><small></small></span>
    </div>
  </div>


</div>
<!-- col -->
<div class="col-lg-3 col-xs-6">
  <div class="info-box">
    <span class="info-box-icon bg-aqua"><i class="fa fa-car"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Flotas</span>
      <span class="info-box-number"><?php  echo count($flotas); ?><small></small></span>
    </div>
  </div>


</div>
<!--===========================================================================-->

<!-- col -->
<div class="col-lg-3 col-xs-6">

  <div class="info-box">
    <span class="info-box-icon bg-green"><i class="ion ion-stats-bars"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Clientes</span>
      <span class="info-box-number"><?php  echo count($clientes); ?><small></small></span>
    </div>
  </div>

</div>
<!-- col -->
<!-- col -->
<div class="col-lg-3 col-xs-6">

  <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fa fa-file-pdf-o"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Contratos</span>
      <span class="info-box-number"><?php  echo count($contratos); ?><small></small></span>
    </div>
  </div>

</div>
<!-- col -->

<!-- col -->
<div class="col-lg-3 col-xs-6">

  <div class="info-box">
    <span class="info-box-icon bg-green"><i class="fa fa-file-pdf-o"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Actas</span>
      <span class="info-box-number"><?php  echo count($actas); ?><small></small></span>
    </div>
  </div>

</div>
<!-- col -->
<!--===========================================================================-->

<!-- col -->
<div class="col-lg-3 col-xs-6">

  <div class="info-box">
    <span class="info-box-icon bg-yellow"><i class="ion ion-person-add"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Usuarios</span>
      <span class="info-box-number"><?php  echo count($usuarios); ?><small></small></span>
    </div>
  </div>


</div>
<!-- col -->

<!--===========================================================================-->

<!-- col -->
<div class="col-lg-3 col-xs-6">
  <div class="info-box">
    <span class="info-box-icon bg-red"><i class="ion ion-pie-graph"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Productos</span>
      <span class="info-box-number"><?php  echo count($servicios); ?><small></small></span>
    </div>
  </div>

</div>
<!-- col -->

<!-- col -->
<div class="col-lg-3 col-xs-6">
  <div class="info-box">
    <span class="info-box-icon bg-red"><i class="ion ion-pie-graph"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Notificaciones</span>
      <span class="info-box-number"><?php  echo count($notificaciones); ?><small></small></span>
    </div>
  </div>


</div>
<!-- col -->
