<div class="col-xs-12 col-sm-6">
  <p class="text-center">
    <strong>Estado de Tareas</strong>
  </p>
  <!-- /.progress-group -->
  <div class="progress-group">
    <span class="progress-text">Tareas Sin Leer</span>
    <span class="progress-number"><b><?php if (count($tareasSL) >= 0 ) {echo count($tareasSL);}else{echo "0";} ?></b>/<?php if (count($tareasTotal) >= 0 ) {echo count($tareasTotal);}else{echo "0";} ?></span>

    <div class="progress sm">
      <!-- /


        3 - 100

        1 - x

        3x= 1*100/3



       -->
      <?php 

        $porcentajeSL = (count($tareasSL)*100)/count($tareasTotal);
        $porcentajeT = (count($tareasT)*100)/count($tareasTotal);
        $porcentajeP = (count($tareasP)*100)/count($tareasTotal);
        $porcentajeC = (count($tareasC)*100)/count($tareasTotal);


       ?>

      <div class="progress-bar progress-bar-aqua" style="width: <?php echo round($porcentajeSL)?>%"></div>
    </div>
  </div>

  <!-- /.progress-group -->
  <div class="progress-group">
    <span class="progress-text">Tareas Completadas</span>
    <span class="progress-number"><b><?php if (count($tareasT) >= 0 ) {echo count($tareasT);}else{echo "0";} ?></b>/<?php if (count($tareasTotal) >= 0 ) {echo count($tareasTotal);}else{echo "0";} ?></span>

    <div class="progress sm">
      <div class="progress-bar progress-bar-green" style="width: <?php echo round($porcentajeT)?>%"></div>
    </div>
  </div>


  <!-- /.progress-group -->
  <div class="progress-group">
    <span class="progress-text">Tareas En progreso</span>
    <span class="progress-number"><b><?php if (count($tareasP) >= 0 ) {echo count($tareasP);}else{echo "0";} ?></b>/<?php if (count($tareasTotal) >= 0 ) {echo count($tareasTotal);}else{echo "0";} ?></span>

    <div class="progress sm">
      <div class="progress-bar progress-bar-yellow" style="width: <?php echo round($porcentajeP)?>%"></div>
    </div>
  </div>

  <!-- /.progress-group -->
  <div class="progress-group">
    <span class="progress-text">Tareas Canceladas</span>
    <span class="progress-number"><b><?php if (count($tareasC) >= 0 ) {echo count($tareasC);}else{echo "0";} ?></b>/<?php if (count($tareasTotal) >= 0 ) {echo count($tareasTotal);}else{echo "0";} ?></span>

    <div class="progress sm">
      <div class="progress-bar progress-bar-red" style="width: <?php echo round($porcentajeC)?>%"></div>
    </div>
  </div>


</div>

<div class="col-xs-12 col-sm-6">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Historial de Tareas</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="table-responsive">
        <table class="table no-margin tablaVerTareas">
          <thead>
          <tr>
            <th>#</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Costo</th>
          </tr>
          </thead>
          <tbody>


          </tbody>
        </table>
      </div>
      <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
      
      <?php 


      if ($_SESSION["ventas"] == "true") {

        echo '<a class="btn btn-sm btn-info btn-flat pull-left modalCrearTarea" data-toggle="modal" data-target="#modalCrearTarea">Crear Tarea</a>';
      }
            
      ?>
      <a class="btn btn-sm btn-default btn-flat pull-right" data-toggle="modal" data-target="#modalTecnicos">Administrar Tecnicos</a>
    </div>
    <!-- /.box-footer -->
  </div>
</div>

<div class="col-xs-12">
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Descripción de Tareas</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <div class="table-responsive">
        <table class="table no-margin tablaVerTipoTareas">
          <thead>
          <tr>
            <th>#</th>
            <th>Tipo de Tarea</th>
            <th>Costo</th>
            <th>Acciones</th>
          </tr>
          </thead>
          <tbody>


          </tbody>
        </table>
      </div>
      <!-- /.table-responsive -->
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
      
      <?php 


      if ($_SESSION["ventas"] == "true") {

        echo '<a class="btn btn-sm btn-info btn-flat pull-left modalCrearTipoTarea" data-toggle="modal" data-target="#modalCrearTipoTarea">Crear Tipo Tarea</a>';
      }
            
      ?>
    </div>
    <!-- /.box-footer -->
  </div>
</div>




<!--=====================================
MODAL CREAR TAREA
======================================-->

<div id="modalCrearTarea" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Crear Tarea</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DE LA PLACA DEL VEHICULO
            ======================================-->

            <div class="form-group col-xs-12">

              <label for="placa">Tipo de Tarea:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-copyright"></i></span>

                <select type="text" class="form-control input-md tipoTarea" name="tipoTarea" required>

                  <?php 

                  $tareas = ControladorTareas::ctrMostrarTipoTareas(null, null);

                  foreach ($tareas as $key => $value) {
                    # code...

                    echo '<option value="'.$value["id"].'">'.$value["tipo"].'</option>';
                  }

                   ?>



                </select>

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="Vehiculo">Vehiculo:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-car"></i></span>

                  <select name="idVehiculo" class="form-control select2 idVehiculo" data-live-search="true">

                  </select>

              </div> 

            </div>
            <!--=====================================
            ENTRADA DEL DISPOSITIVO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="dispositivo">Dispositivo:</label>
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-cog"></i></span>

                  <select name="dispositivo" class="form-control select2 dispositivo" data-live-search="true">

                  </select>

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL SIM DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Numero:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input maxlength="9" type="text" class="form-control input-md simTarea" placeholder="Numero Sim" name="simTarea"> 

              </div> 

            </div>


            <!--=====================================
            ENTRADA DEL NUMERO SIM CARD
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Sim Card:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md simCardTarea" name="simCardTarea"> 

              </div> 

            </div>





            <!--=====================================
            ENTRADA DEL NUEVO SIM DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12 divNuevo" style="display: none;">

              <label>Nuevo Numero sim:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input maxlength="9" type="text" class="form-control input-md nuevoSimTarea" placeholder="Num Sim" name="nuevoSimTarea"> 

              </div> 

            </div>


            <!--=====================================
            ENTRADA DEL NUEVO NUMERO SIM CARD
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12 divNuevo" style="display: none;">

              <label>Nuevo Sim Card:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input type="text" class="form-control input-md nuevoSimCardTarea" placeholder="Num Card Sim" name="nuevoSimCardTarea"> 

              </div> 

            </div>



            <!--=====================================
            ENTRADA DE LA FECHA
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Fecha Tarea:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa  fa-calendar-times-o"></i></span>

                <input type="date" class="form-control input-md fechaTarea" name="fechaTarea" id="fechaTarea" required="">

              </div> 

            </div>

            <!--=====================================
            ENTRADA DE LA HORA
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Hora Tarea:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>


                <input type="time" class="form-control input-md horaTarea" name="horaTarea" id="horaTarea" required="">
              </div> 

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Crear Tarea</button>

        </div>

      </form>

      <?php 
       $crearTarea = new ControladorTareas;
       $crearTarea -> ctrCrearTarea();
       ?>


    </div>

  </div>

</div>





<!--=====================================
MODAL TIPO TAREA
======================================-->

<div id="modalCrearTipoTarea" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Crear Tipo Tarea</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL TIPO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="Marca">Tarea:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-folder"></i></span>

                <input type="text" class="form-control input-md crearTipoTarea" placeholder="Tarea Descripcion" name="crearTipoTarea"> 

              </div> 


            </div>

            <!--=====================================
            ENTRADA DEL SIM DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Costo Servicio:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-money"></i></span>

                <input type="number" class="form-control input-md costoTarea" placeholder="Costo de Tarea" name="costoTarea"> 

              </div> 

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Crear Tipo Tarea</button>

        </div>

      </form>

      <?php 
       $crearTarea = new ControladorTareas;
       $crearTarea -> ctrCrearTipoTarea();
       ?>


    </div>

  </div>

</div>




<!--=====================================
MODAL EDITAR TIPO TAREA
======================================-->

<div id="modalEditarTipoTarea" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Tipo Tarea</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL TIPO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              <label for="Tarea">Tarea:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-folder"></i></span>

                <input type="text" class="form-control input-md editarTipoTarea" placeholder="Tarea Descripcion" name="editarTipoTarea"> 

              </div> 


            </div>

            <!--=====================================
            ENTRADA DEL SIM DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">

              <label>Costo Servicio:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-money"></i></span>

                <input type="number" class="form-control input-md editarCostoTarea" placeholder="Costo de Tarea" name="editarCostoTarea"> 

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
       // $crearTarea = new ControladorTareas;
       // $crearTarea -> ctrCrearTipoTarea();
       ?>


    </div>

  </div>

</div>