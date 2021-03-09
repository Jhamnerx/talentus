<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Vehiculos
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Vehiculos</a></li>

      <li class="active">Gestor Vehiculos</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
      <?php 


      if ($_SESSION["vehiculos"] == "true") {
        
       ?>
      <div class="box-header with-border">
         
        <button class="btn btn-primary modalAgregarVehiculo" data-toggle="modal" data-target="#modalAgregarVehiculo">
          
          Agregar Vehiculo

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaVehiculos" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Acciones</th>
               <th>Placa</th>
               <th>Marca</th>
               <th>Modelo</th>
               <th>Tipo</th>
               <th>Año</th>
               <th>Flota</th>
               <th>Sim</th>
               <th>Dispositivo</th>
               <th>Estado</th>

            </tr> 

          </thead>   
     
        </table>
          
      </div>
      <?php 
        }else{


          echo '<div class="alert alert-danger alert-dismissible">
                
                <h4><i class="icon fa fa-ban"></i> No tienes permisos!</h4>
                Lo Sentimos no tienes permisos para acceder a esta pagina.
              </div>';
        }
       ?>
    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR VEHICULO
======================================-->

<div id="modalAgregarVehiculo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Vehiculo</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DE LA PLACA DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label for="placa">Placa:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-car"></i></span>

                <input type="text" class="form-control input-md placa" placeholder="Placa" name="placa" required> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DE LA MARCA DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="Marca">Marca:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-copyright"></i></span>

                <input type="text" class="form-control input-md marca" placeholder="Marca" name="marca"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL MODELO DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label for="Modelo">Modelo:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-laptop"></i></span>

                <input type="text" class="form-control input-md modelo" placeholder="Modelo" name="modelo"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL TIPO DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label for="Tipo">Tipo:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-car"></i></span>

                <input type="text" class="form-control input-md tipo" placeholder="Tipo" name="tipo"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL AÑO DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="year">Año:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-car"></i></span>

                <input type="text" class="form-control input-md year" placeholder="Año" name="year"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL COLOR DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label for="color">Color:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-paint-brush"></i></span>

                <input type="text" class="form-control input-md color" placeholder="Color" name="color"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL MOTOR DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="motor">Motor:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>

                <input type="text" class="form-control input-md motor" placeholder="Motor" name="motor"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL SERIE DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label for="serie">Serie:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-md serie" placeholder="Serie" name="serie"> 

              </div> 

            </div>
            <!--=====================================
            ENTRADA FLOTA DEL VEHICULO
            ======================================-->
            <div class="form-group col-xs-12">

              <label>Flota:</label>

              <div class="input-group">

                  <select name="flota" class="form-control select2 idflota" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn">

                    <button type="button" class="btn btn-danger btnAgregarFlota" data-toggle="modal" data-target="#modalAgregarFlota">...</button>
                  </div>
                  <!-- /btn-group -->
                  
              </div>

            </div>

            <!--=====================================
            ENTRADA DEL SIM DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12 addAlert">

              <label>Sim:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control comprobarSim input-md sim" placeholder="Num Sim" name="sim" > 

              </div> 

            </div>
            <div class="fix"></div>

            <!--=====================================
            ENTRADA DEL OPERADOR DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Operador:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md operador" placeholder="Operador" name="operador"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA PARA LA DESCRIPCIÓN DE LA VEHICULO
            ======================================-->

            <div class="form-group col-xs-12">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <textarea maxlength="120" class="form-control input-lg descripcion" name="descripcion"  rows="3" placeholder="Ingresar descripción vehiculo"></textarea>

              </div> 

            </div>

            <!--=====================================
            ENTRADA DISPOSITIVO DEL VEHICULO
            ======================================-->
            <div class="form-group col-xs-6">

              <label>Dispositivo:</label>

              <div class="input-group">

                  <select name="dispositivo" class="form-control select2 dispositivo" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn">

                    <button type="button" class="btn btn-danger btnAgregarDispositivo" data-toggle="modal" data-target="#modalAgregarDispositivo">...</button>
                  </div>
                  <!-- /btn-group -->
                  
              </div>
              
            </div>

            <!--=====================================
            ENTRADA DEL GPS IS DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="idgps">ID GPS:</label>
              <div class="input-group">
                
                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>

                <input type="text" class="form-control input-md idgps idgps" placeholder="ID GPS" name="idgps"> 

              </div> 

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Vehiculo</button>

        </div>

      </form>

      <?php

        
           $crearVehiculo = new ControladorVehiculos();
           $crearVehiculo -> ctrCrearVehiculos();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR VEHICULO
======================================-->

<div id="modalEditarVehiculo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Vehiculo</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DE LA PLACA DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label for="placa">Placa:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-car"></i></span>

                <input type="text" class="form-control input-md editarPlaca" placeholder="Placa" name="editarPlaca" required> 
                <input type="hidden" class="editarIdVehiculo" name="editarIdVehiculo"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DE LA MARCA DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="Marca">Marca:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-copyright"></i></span>

                <input type="text" class="form-control input-md editarMarca" placeholder="Marca" name="editarMarca"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL MODELO DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label for="Modelo">Modelo:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-laptop"></i></span>

                <input type="text" class="form-control input-md editarModelo" placeholder="Modelo" name="editarModelo"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL TIPO DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label for="Tipo">Tipo:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-car"></i></span>

                <input type="text" class="form-control input-md editarTipo" placeholder="Tipo" name="editarTipo"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL AÑO DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="year">Año:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-car"></i></span>

                <input type="text" class="form-control input-md editarYear" placeholder="Año" name="editarYear"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL COLOR DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label for="color">Color:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-paint-brush"></i></span>

                <input type="text" class="form-control input-md editarColor" placeholder="Color" name="editarColor"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL MOTOR DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="motor">Motor:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>

                <input type="text" class="form-control input-md editarMotor" placeholder="Motor" name="editarMotor"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL SERIE DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label for="serie">Serie:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-key"></i></span>

                <input type="text" class="form-control input-md editarSerie" placeholder="Serie" name="editarSerie"> 

              </div> 

            </div>
            <!--=====================================
            ENTRADA FLOTA DEL VEHICULO
            ======================================-->
            <div class="form-group col-xs-12">

              <label>Flota:</label>

              <div class="input-group">

                  <select name="editaridflota" class="form-control select2 idflota editaridflota" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn">

                    <button type="button" class="btn btn-danger btnAgregarFlota" data-toggle="modal" data-target="#modalAgregarFlota">...</button>
                  </div>
                  <!-- /btn-group -->
                  
              </div>

            </div>

            <!--=====================================
            ENTRADA DEL SIM DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Sim:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md editarSim" placeholder="Num Sim" name="editarSim"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL OPERADOR DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Operador:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md editarOperador" placeholder="Operador" name="editarOperador"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA PARA LA DESCRIPCIÓN DE LA VEHICULO
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <textarea maxlength="120" class="form-control input-lg editarDescripcionVehiculo" name="editarDescripcionVehiculo"  rows="3" placeholder="Ingresar descripción vehiculo"></textarea>

              </div> 

            </div>

            <!--=====================================
            ENTRADA DISPOSITIVO DEL VEHICULO
            ======================================-->
            <div class="form-group col-xs-6">

              <label>Dispositivo:</label>

              <div class="input-group">

                  <select name="editarDispositivo" class="form-control select2 dispositivo" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn">

                    <button type="button" class="btn btn-danger btnAgregarDispositivo" data-toggle="modal" data-target="#modalAgregarDispositivo">...</button>
                  </div>
                  <!-- /btn-group -->
                  
              </div>
              
            </div>

            <!--=====================================
            ENTRADA DEL GPS IS DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="idgps">ID GPS:</label>
              <div class="input-group">
                
                <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>

                <input type="text" class="form-control input-md editaridgps" placeholder="ID GPS" name="editaridgps"> 

              </div> 

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios Vehiculo</button>

        </div>

      </form>

      <?php

        
          $editarVehiculo = new ControladorVehiculos();
          $editarVehiculo -> ctrEditarVehiculo();

      ?>

    </div>

  </div>

</div>

 <?php

        
    // $eliminarVehiculo = new ControladorVehiculos();
    // $eliminarVehiculo -> ctrEliminarVehiculo();

  ?>

<?php 
include "modals/flotas.php";
 ?>