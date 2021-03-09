<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Actas
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Almacen</a></li>

      <li class="active">Gestor Actas</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
       
      <div class="box-header with-border">
         
        <button class="btn btn-primary modalAgregarActa" data-toggle="modal" data-target="#modalAgregarActa">
          
          Agregar Acta

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaActas" width="100%">
        
          <thead>
         
            <tr>
             
                <th style="width:10px">#</th>
                <th>Codigo</th>
                <th>Descargar</th>
                <th>Vehiculo</th>
                <th>Inicio Cober</th>
                <th>Fin Cober</th>
                <th>Fecha </th>
                <th>Caracteristicas </th>
                <th>Estado</th>
                <th>Acciones </th>

            </tr> 

          </thead>   
     
        </table>
          
      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR CATEGORÍA
======================================-->

<div id="modalAgregarActa" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Acta</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL NUMERO DE CERTIFICADO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Numero Acta:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md numActa" placeholder="Ejem. 205" name="numActa" required> 
                

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              
              <label>Vehiculo:</label>

              <div class="input-group">

                  <select name="idvehiculo" class="form-control select2 idvehiculo" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn">

                    <button type="button" class="btn btn-danger btnAgregarVehiculo" data-toggle="modal" data-target="#modalAgregarVehiculo">...</button>
                  </div>
                  <!-- /btn-group -->
                  
              </div>

            </div>
            <!--=====================================
            ENTRADA DEL INICIO COBERTURA
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              
              <label>Inicio Cobertura:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md inicio" placeholder="20-02-2029" name="inicio" required> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL FIN COBERTURA
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              
              <label>Fin Cobertura:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md fin" placeholder="20-02-2029" name="fin" required> 

              </div> 

            </div>
            <!--=====================================
            ENTRADA DEL CIUDAD
            ======================================-->
           <div class="form-group col-xs-12">

              <label>Ciudad:</label>

              <select name="ciudad" class="form-control ciudad" required="">
                <?php 

                $ciudad = ControladorPlantilla::ctrSeleccionarCiudad();

               // var_dump($ciudad);

                foreach ($ciudad as $key => $value) {

                  echo "<option value='".$value['id']."'>".$value['nombre']."</option>";
                }
                 ?>

              </select>
           </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">

              <label style="padding-bottom: 20px;">Caracteristicas</label><br>
              <label>
                <input type="checkbox" class="flat-red fondo" name="fondo">
                Fondo  
              </label> <br>
              <label>
                <input type="checkbox" class="flat-red sello" name="sello">
                 Sello
              </label>

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Acta</button>

        </div>

      </form>

      <?php

        
          $crearActa = new ControladorActas();
          $crearActa -> ctrCrearActa();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->

<div id="modalEditarActa" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

            <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Acta</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL NUMERO DE CERTIFICADO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Numero Acta:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md editarNumActa" placeholder="Ejem. 205" name="editarNumActa" required> 
                <input type="hidden" class="editaridActa" name="editaridActa" required> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              
              <label>Vehiculo:</label>

              <div class="input-group">

                  <select name="editaractavehiculo" class="form-control select2 editaractavehiculo" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn">

                    <button type="button" class="btn btn-danger btnAgregarVehiculo" data-toggle="modal" data-target="#modalAgregarVehiculo">...</button>
                  </div>
                  <!-- /btn-group -->
                  
              </div>

            </div>
            <!--=====================================
            ENTRADA DEL INICIO COBERTURA
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              
              <label>Inicio Cobertura:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md editarinicio" placeholder="20-02-2029" name="editarinicio" required> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL FIN COBERTURA
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              
              <label>Fin Cobertura:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md editarfin" placeholder="20-02-2029" name="editarfin" required> 

              </div> 

            </div>

            <input type="hidden" name="editarfecha" class="editarfecha">
            <!--=====================================
            ENTRADA DEL CIUDAD
            ======================================-->
           <div class="form-group col-xs-12">

              <label>Ciudad:</label>

              <select name="editarciudad" class="form-control editarciudad" required="">
                <?php 

                $ciudad = ControladorPlantilla::ctrSeleccionarCiudad();

               // var_dump($ciudad);

                foreach ($ciudad as $key => $value) {

                  echo "<option value='".$value['id']."'>".$value['nombre']."</option>";
                }
                 ?>

              </select>
           </div>

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">

              <label style="padding-bottom: 20px;">Caracteristicas</label><br>
              <label>
                <input type="checkbox" class="flat-red fondo editarfondo" name="editarfondo">
                Fondo  
              </label> <br>
              <label>
                <input type="checkbox" class="flat-red fondo editarsello" name="editarsello">
                 Sello
              </label>

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Acta</button>

        </div>

      </form>

      <?php

        
          $editarActa = new ControladorActas();
          $editarActa -> ctrEditarActa();

      ?>

    </div>

  </div>

</div>

 <?php

        
    // $eliminarActa = new ControladorActas();
    // $eliminarActa -> ctrEliminarActa();

  ?>

