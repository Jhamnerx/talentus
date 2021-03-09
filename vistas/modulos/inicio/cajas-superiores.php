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



 ?>

<!--=====================================
CAJAS SUPERIORES
======================================-->

<!-- col -->
<div class="col-lg-3 col-xs-6">

  <!-- small box -->
  <div class="small-box bg-aqua">
    
    <!-- inner -->
    <div class="inner">
      
      <h3><?php  echo count($vehiculos); ?></h3>
      <p>Vehiculos</p>
    
    </div>
    <!-- inner -->

    <!-- icon -->
    <div class="icon">
    
      <i class="fa fa-car"></i>
    
    </div>
    <!-- icon -->
    
    <a href="vehiculo" class="small-box-footer">Más Info <i class="fa fa-arrow-circle-right"></i></a>
  
  </div>
  <!-- small-box -->

</div>
<!-- col -->

<!--===========================================================================-->

<!-- col -->
<div class="col-lg-3 col-xs-6">
  
  <!-- small box -->
  <div class="small-box bg-green">

    <!-- inner -->
    <div class="inner">
      
      <h3><?php echo count($clientes); ?></h3>

      <p>Clientes</p>
    
    </div>
    <!-- inner -->
    
    <!-- icon -->
    <div class="icon">
      
      <i class="ion ion-stats-bars"></i>
    
    </div>
    <!-- icon -->

    <a href="clientes" class="small-box-footer">Ver Más <i class="fa fa-arrow-circle-right"></i></a>
  
  </div>
  <!-- small box -->

</div>
<!-- col -->

<!--===========================================================================-->

<!-- col -->
<div class="col-lg-3 col-xs-6">
  
  <!-- small box -->
  <div class="small-box bg-yellow">
    
    <!-- inner -->
    <div class="inner">
    
      <h3><?php echo count($usuarios); ?></h3>

      <p>Usuarios</p>
    
    </div>
    <!-- inner -->

    <!-- icon -->
    <div class="icon">
      
      <i class="ion ion-person-add"></i>
    
    </div>
    <!-- icon -->

    <a href="usuarios" class="small-box-footer">Más Info <i class="fa fa-arrow-circle-right"></i></a>
  
  </div>
  <!-- small box -->

</div>
<!-- col -->

<!--===========================================================================-->

<!-- col -->
<div class="col-lg-3 col-xs-6">
  
  <!-- small box -->
  <div class="small-box bg-red">
  
    <!-- inner -->
    <div class="inner">
    
      <h3><?php echo count($servicios); ?></h3>

      <p>Productos</p>

    </div>
    <!-- inner -->
    
    <!-- icon -->
    <div class="icon">
      
      <i class="ion ion-pie-graph"></i>
    
    </div>
    <!-- icon -->
    
    <a href="servicios" class="small-box-footer">Más Info <i class="fa fa-arrow-circle-right"></i></a>
  
  </div>
  <!-- small box -->

</div>
<!-- col -->

<!-- col -->
<div class="col-lg-3 col-xs-6">
  
  <!-- small box -->
  <div class="small-box bg-red">
  
    <!-- inner -->
    <div class="inner">
    
      <h3><?php echo count($notificaciones); ?></h3>

      <p>Notificaciones</p>

    </div>
    <!-- inner -->
    
    <!-- icon -->
    <div class="icon">
      
      <i class="fa fa-bell-o"></i>
    
    </div>
    <!-- icon -->
    
    <a href="notificaciones" class="small-box-footer">Más Info <i class="fa fa-arrow-circle-right"></i></a>
  
  </div>
  <!-- small box -->

</div>
<!-- col -->