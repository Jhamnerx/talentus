<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Flotas
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Flotas</a></li>

      <li class="active">Gestor Flotas</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
       
      <div class="box-header with-border">
         
        <button class="btn btn-primary AgregarFlota" data-toggle="modal" data-target="#modalAgregarFlota">
          
          Agregar Flota

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaFlotas" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Flota</th>
               <th>Cliente</th>
               <th>Estado</th>
               <th>Acciones</th>
            </tr> 

          </thead>   
     
        </table>
          
      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR FLOTA
======================================-->

<div id="modalAgregarFlota" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Flota</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL NOMBRE DE LA FLOTA
            ======================================-->

            <div class="form-group col-lg-12 col-xs-12">
              <label>Nombre Flota(*):</label>                
                
                <input type="text" class="form-control input-md validarFlota nombreFlota" placeholder="Ingresar Flota" name="nombreFlota" required> 


            </div>

            <div class="form-group col-xs-12">

              <label>Cliente(*):</label>
              <div class="input-group">
                  <select name="idcliente" class="form-control select2 idcliente" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn" style="padding-left: 10px;">

                    <button type="button" class="btn btn-danger btnAgregarCliente" data-toggle="modal" data-target="#modalAgregarCliente">...</button>
                  </div>
                  <!-- /btn-group -->
                  
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

        
          $crearFlota = new ControladorFlotas();
          $crearFlota -> ctrCrearFlota();

      ?>


    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR FLOTA
======================================-->

<div id="modalEditarFlota" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Flota</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL NOMBRE DE LA FLOTA
            ======================================-->

            <div class="form-group col-lg-12 col-xs-12">

              <label>Nombre Flota(*):</label>   

               <input type="hidden" class="editarIdflota"  name="editarIdflota"> 
                <input type="text" class="form-control input-md EditarNombreFlota" placeholder="Ingresar Flota" name="editarNombreflota" required> 

            </div>


            <div class="form-group col-xs-12">

              <label>Cliente(*):</label>

              <div class="input-group">
                  <select name="editarClienteflota" class="form-control select2 editarClienteflota" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn" style="padding-left: 10px;">

                    <button type="button" class="btn btn-danger btnAgregarCliente" data-toggle="modal" data-target="#modalAgregarCliente">...</button>
                  </div>
                  <!-- /btn-group -->
                  
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

        
          $editarFlota = new ControladorFlotas();
          $editarFlota -> ctrEditarflota();

      ?>
    </div>

  </div>

</div>


<?php 
include "modals/clientes.php";
 ?>

