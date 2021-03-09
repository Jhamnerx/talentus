<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Lineas
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="lineas"><i class="fa fa-laptop"></i> Administracion</a></li>

      <li class="active">Gestor Lineas</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <?php 


      if ($_SESSION["administracion"] == "true") {
        
       ?>
       
      <div class="box-header with-border">
         
        <button class="btn btn-primary btnAgregarLinea" data-toggle="modal" data-target="#modalAgregarLinea">
          
          Registrar Linea

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaLineas" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Numero/Telefono</th>
               <th>Sim-Card</th>
               <th>Placa</th>
               <th>Paquetes Soluciones</th>
               <th>Estado</th>
               <th>Acciones</th>

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
MODAL AGREGAR LINEAS
======================================-->

<div id="modalAgregarLinea" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Registrar Linea</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            NUMERO
            ======================================-->
            <div class="form-group col-sm-6 col-xs-12">

              <label for="numero">Numero:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md numero" maxlength="10" placeholder="numero" name="numeroLinea" required> 

              </div> 

            </div>

            <!--=====================================
            placa
            ======================================-->
            <div class="form-group col-sm-6 col-xs-12">

              <label for="placa">Placa:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md placa" placeholder="Placa" name="placaLinea"> 

              </div> 

            </div>
            <!--=====================================
            SIM CARD
            ======================================-->
            <div class="form-group col-sm-6 col-xs-12">

              <label for="simCard">Sim Card:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md simCard" placeholder="sim Card" name="sim_card"> 

              </div> 

            </div>
                <!--=====================================
                ENTRADA DE LA EMPRESA
                ======================================-->
                <?php
                    $opciones = ControladorCobros::ctrMostrarClientes();
                ?>

                <input type="hidden" class="autocomplete" value='<?php echo $opciones;?>'>

              <div class="form-group col-sm-6 col-xs-12">

                  <label for="empresa">Empresa:</label>

                  <div class="input-group" >
              
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>

                      <input type="text" id="autocomplete-ajax" class="form-control input-md empresa" value="" placeholder="Nombre Empresa" name="empresa" required> 
                        <input type="hidden" class="nameEmpresa" name="nameEmpresa">
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

        
          $crearLinea = new ControladorLineas();
          $crearLinea -> ctrCrearLinea();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR LINEAS
======================================-->

<div id="modalEditarLinea" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">EDITAR LINEAS</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            NUMERO
            ======================================-->
            <div class="form-group col-sm-6 col-xs-12">

              <label for="numero">Numero:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md numero" maxlength="10" placeholder="numero" name="editarNumeroLinea"> 
                <input type="hidden" class="form-control input-md idLinea" name="idLinea"> 

              </div> 

            </div>

            <!--=====================================
            placa
            ======================================-->
            <div class="form-group col-sm-6 col-xs-12">

              <label for="placa">Placa:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md editarPlaca" placeholder="Placa" name="editarPlaca"> 

              </div> 

            </div>
            <!--=====================================
            SIM CARD
            ======================================-->
            <div class="form-group col-sm-6 col-xs-12">

              <label for="simCard">Sim Card:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md simCard" placeholder="sim Card" name="editarSim_card"> 

              </div> 

            </div>
                <!--=====================================
                ENTRADA DE LA EMPRESA
                ======================================-->
                <?php
                    $opciones = ControladorCobros::ctrMostrarClientes();
                ?>

                <input type="hidden" class="autocomplete" value='<?php echo $opciones;?>'>

              <div class="form-group col-sm-6 col-xs-12">

                  <label for="empresa">Empresa:</label>

                  <div class="input-group" >
              
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>

                      <input type="text" id="autocomplete-ajax-linea" class="form-control input-md empresa" value="" placeholder="Nombre Empresa" name="editarEmpresa" required> 
                        <input type="hidden" class="nameEmpresa" name="editarNameEmpresa">
                  </div> 

              </div>





          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

      <?php

        
          $editarLinea = new ControladorLineas();
          $editarLinea -> ctrEditarLinea();

      ?>

    </div>

  </div>

</div>

 <?php

        
    // $eliminarLinea = new ControladorLineas();
    // $eliminarLinea -> ctrEliminarLinea();

  ?>

