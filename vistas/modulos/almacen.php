<?php 

if (isset($rutas[1])) {

  $item = "almacen";
  $valor = $rutas[1];

  $almacenes = ControladorAlmacenes::ctrMostrarAlmacenes($item, $valor);

  $item1 = null;
  $valor1 = null;

  $servicios = ControladorServicios::ctrMostrarServicios($item1, $valor1);

?>

<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Almacen / <?php  echo $rutas[1]; ?>
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Almacen</a></li>
      <li class="active"><?php  echo $rutas[1]; ?></li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
       
      <div class="box-header with-border">
        <hr>
         
<!--         <button class="btn btn-primary" data-toggle="modal" data-target="#modalMovimiento">
          
          Registrar Movimiento

        </button> -->

      </div>

      <div class="box-body">

        <div class="row"> 
          <div class="col-xs-6">

            <h3>LISTA DE PRODUCTOS</h3>
            <ul class="todo-list">
              <?php 

              foreach ($servicios as $key => $value) {

                if ($value["imagen"] != "") {

                  $imagen = "<img src='".$url.$value["imagen"]."' width='50px'>";
                
                }else{
                  $imagen = "<img src='".$url."vistas/img/servicios/default/default.png' width='50px'>";
                }
                
                echo '

                <li>
                  <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                  <input type="checkbox" value="">
                  <span class="text">'.$value["nombre"].'</span>

                  <small>'.$imagen.'</small>

                   <input class="input-sm" type="number" min="0" placeholder="Cantidad" name="cantidadProducto">

                  <div class="tools">
                    <i class="fa fa-edit"></i>
                    <i class="fa fa-trash-o"></i>
                  </div>
                </li>
                  


                ';

              }

               ?>
            </ul>

          </div>
          <div class="col-xs-6">
            
            
            <table class="table table-bordered table-striped dt-responsive tablaAlmacenes" width="100%">
          
              <thead>
             
                <tr>

                  <input type="hidden" value="<?php echo $almacenes["id"];?>" class="AlmacenSeleccionado">
                 
                   <th style="width:10px">#</th>
                   <th>Producto</th>
                   <th>Categoria</th>
                   <th>Almacen</th>
                   <th>Stock</th>
                   <th>Imagen</th>

                </tr> 

              </thead>   
       
            </table>

          </div>


        </div>

          
      </div>


    </div>

  </section>

</div>


<?php
}else{



  include "almacen/almacen.php";



}

?>

<!--=====================================
MODAL AGREGAR CATEGORÍA
======================================-->

<div id="modalMovimiento" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Registrar Movimiento</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL TITULO
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md validarServicio nombreServicio" placeholder="Ingresar Producto/Servicio" name="nombreServicio" required> 

              </div> 

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar</button>

        </div>

      </form>

      <?php

        
          $crearServicio = new ControladorServicios();
          $crearServicio -> ctrCrearServicio();

      ?>

    </div>

  </div>

</div>