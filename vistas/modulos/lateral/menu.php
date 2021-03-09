<!--=====================================
MENU
======================================--> 
<?php 

// $item1 = "id";
// $item2 = "permiso";
// $valor1 = $_SESSION["cargo"];
// $valor2 = "almacen";



// $permisos = ModeloRoles::mdlMostrarPermisosMenu("permisos", $item1, $valor1, $item2, $valor2);

//var_dump($_SESSION["ventas"]);


if ($_SESSION["cargo"] != "cliente") {
  # code...


 ?>
<ul class="sidebar-menu">

  <li class="active inicio"><a href="inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li>


<?php 

if ($_SESSION["almacen"] == "true") {
  echo '  <li class="treeview">
      
    <a href="#">
      <i class="fa fa-laptop"></i>
      <span>Almacen</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>

    <ul class="treeview-menu">
        
      <li><a href="categorias"><i class="fa fa-circle-o"></i> Categorias</a></li>
      <li><a href="servicios"><i class="fa fa-circle-o"></i> Productos/Servicios</a></li>
      
    </ul>

  </li>';
}
if ($_SESSION["compras"] == "true") {
  echo '  <li class="treeview">
      
    <a href="#">
      <i class="fa fa-cart-plus"></i>
      <span>Compras</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>

    <ul class="treeview-menu">
      
      <li><a href="proveedor"><i class="fa fa-circle-o"></i> Proveedores</a></li>
      <li><a href="ingresos"><i class="fa fa-circle-o"></i> Ingresos</a></li>
    
    </ul>

  </li>';
}

if ($_SESSION["ventas"] == "true") {
 echo '  <li class="treeview">
    <a href="#">
      <i class="fa fa-shopping-cart"></i>
       <span>Ventas</span>
        <i class="fa fa-angle-left pull-right"></i>
     </a>
    <ul class="treeview-menu">
      <li><a href="clientes"><i class="fa fa-circle-o"></i> Clientes</a></li>
      <li><a href="ventas"><i class="fa fa-circle-o"></i> Ventas</a></li>
      <li><a href="recibo"><i class="fa fa-circle-o"></i> Recibos</a></li>
      <li><a href="contratos"><i class="fa fa-circle-o"></i> Contratos</a></li>
    </ul>
 </li>';
}

if ($_SESSION["vehiculos"] == "true") {
  echo '  <li class="treeview">
    <a href="#">
      <i class="fa fa-car"></i>
      <span>Vehiculos</span>
       <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">

    ';
    if ($_SESSION["nombre"] != "monitoreo") {
        echo '      <li><a href="flota"><i class="fa fa-circle-o"></i> Flotas</a></li>
      <li><a href="contacto"><i class="fa fa-circle-o"></i> Contactos</a></li>
      <li><a href="vehiculo"><i class="fa fa-circle-o"></i> Vehiculos</a></li>
      <li><a href="acta"><i class="fa fa-circle-o"></i> Actas </a></li>
      <li><a href="certificado"><i class="fa fa-circle-o"></i> Certificados </a></li>
      <li><a href="reporte"><i class="fa fa-circle-o"></i> Reportes</a></li>';
      }

      if ($_SESSION["nombre"] == "monitoreo") {
        echo '<li><a href="reporte"><i class="fa fa-circle-o"></i> Reportes</a></li>';
      }
    
echo '</ul>
  </li>';
}
if ($_SESSION["administracion"] == "true") {
  echo '  <li class="treeview">
    <a href="#">
      <i class="fa fa-folder"></i> <span>Administracion</span>
       <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li><a href="usuarios"><i class="fa fa-circle-o"></i> Usuarios</a></li>
      <li><a href="cobros"><i class="fa fa-circle-o"></i> Registro Cobros</a></li>
      <li><a href="lineas"><i class="fa fa-circle-o"></i> Lineas</a></li>
      
      <li><a href="dispositivos"><i class="fa fa-circle-o"></i> Dispositivos</a></li>
      <li><a href="ciudad"><i class="fa fa-circle-o"></i> Ciudades</a></li>
      <li><a href="plantilla"><i class="fa fa-circle-o"></i> Ajustes</a></li>
      <li><a href="slide"><i class="fa fa-circle-o"></i> Gestor Slide</a></li>
    </ul>
  </li>';
}
 ?>







<?php 

if ($_SESSION["tecnico"] == "true") {

  echo '  <li><a href="tareas"><i class="fa fa-wrench"></i> <span>Servicio Tecnico</span></a></li>';
  # code...
}

 ?>






</ul> 

<?php 

}else{

echo '<ul class="sidebar-menu"><li><a href="soporte"><i class="fa fa-wrench"></i> <span>Soporte Tecnico</span></a></li></ul> ';
  
}


 ?>