<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Reportes
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Almacen</a></li>

      <li class="active">Gestor Reportes</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
       
      <div class="box-header with-border">
         
        <button class="btn btn-primary modalAgregarReporte" data-toggle="modal" data-target="#modalAgregarReporte">
          
          Agregar Reporte

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaReportes" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Placa</th>
               <th>Flota</th>
               <th>Estado</th>
               <th>Fecha Transmision</th>
               <th>Hora Transmision</th>
               <th>Fecha reporte</th>
               <th>Acciones</th>
               <th>Modificaciones</th>


            </tr> 

          </thead>   
     
        </table>
          
      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR REPORTE
======================================-->

<div id="modalAgregarReporte" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar reporte</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL VEHICULO
            ======================================-->

            <div class="form-group col-xs-12">
              
              <label>Vehiculo:</label>

              <div class="input-group">

                  <select name="idvehiculoreporte" class="form-control select2 idvehiculoreporte" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn">

                    <button type="button" class="btn btn-danger btnAgregarVehiculo" data-toggle="modal" data-target="#modalAgregarVehiculo">...</button>
                  </div>
                  <!-- /btn-group -->
                  
              </div>

            </div>
            <div class="form-group col-sm-6 col-xs-12">

              <label>Fecha Ultima Transmision(*):</label>

              <input type="date" class="form-control fecha" name="fechaReporte" id="fecha" required="">

            </div>
            <div class="form-group col-sm-6 col-xs-12">

              <label>Hora Transmision(*):</label>

              <input type="time" class="form-control hora" name="horaReporte" id="hora" required="">

            </div>
            <!--=====================================
            ENTRADA PARA LA DESCRIPCIÓN DE LA REPORTE
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <textarea maxlength="120" class="form-control input-lg" name="descripcionReporte"  rows="3" placeholder="Ingresar descripción reporte"></textarea>

              </div> 

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar reporte</button>

        </div>

      </form>

      <?php

        
          $crearReporte = new ControladorReportes();
          $crearReporte -> ctrCrearReporte();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR REPORTE
======================================-->

<div id="modalVerReporte" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar reporte</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">
            <!--=====================================
            ENTRADA DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              
              <label>Vehiculo:</label>

              <div class="input-group">

                  <input type="text" class="form-control idVehiculoEditar" name="idVehiculoEditar" readonly="" style="width: 250px;">
                  <input type="hidden" class="idReporteEditar" name="idReporteEditar">
                  <!-- /btn-group -->
                  
              </div>

            </div>
            <div class="form-group col-sm-6 col-xs-12">
              
              <label>Flota:</label>

              <div class="input-group">

                  <input type="text" class="form-control flotaEditar" name="flotaEditar" readonly="" style="width: 250px;">
                  <!-- /btn-group -->
                  
              </div>

            </div>
            <div class="form-group col-sm-6 col-xs-12">

              <label>Fecha Ultima Transmision(*):</label>

              <input type="date" class="form-control fechaReporteEditar" name="fechaReporteEditar" readonly="">

            </div>
            <div class="form-group col-sm-6 col-xs-12">

              <label>Hora Transmision(*):</label>

              <input type="time" class="form-control horaReporteEditar" name="horaReporteEditar" readonly="">

            </div>
            <!--=====================================
            ENTRADA PARA LA DESCRIPCIÓN DE LA REPORTE
            ======================================-->
            <div class="form-group col-lg-12 col-xs-12">
              
              <label>Agregar Accion:</label>

              <div class="input-group" style=" width: 100%; height: 20px;">

                  <input type="text" class="form-control accionReporte" name="accionReporte" style="height: 50px;">
                  <!-- /btn-group -->
                  
              </div>

            </div>
            <div class="form-group col-lg-12 col-xs-12">
              

              <div class="ListaDetalleReporte">
                <span><b>Lista de Acciones:</b></span>
                  
              </div>

            </div>

            <div class="col-xs-4">
               <label>Solucionado</label>
              <a href="" style="text-decoration: none;" class="CambiarEstado" estado="2">
                <div class="info-box" style=" width: 50; min-height: 50;">
                  <span class="info-box-icon bg-green" style="height: 50px; width: 50px;"><i class="fa fa-check"></i></span>
                  <!-- /.info-box-content -->
                </div>
              </a>
              <!-- /.info-box -->
            </div>
            <div class="col-xs-4">
              <label>En Espera</label>
              <a href="" style="text-decoration: none;" class="CambiarEstado" estado="1">
                <div class="info-box" style=" width: 50; min-height: 50;">
                  <span class="info-box-icon bg-orange" style="height: 50px; width: 50px;"><i class="fa fa-bell-o"></i></span>
                  <!-- /.info-box-content -->
                </div>
              </a>
              <!-- /.info-box -->
            </div>
            <div class="col-xs-4">
              <label>Accionar</label>
              <a href="" style="text-decoration: none;" class="CambiarEstado" estado="0">
                <div class="info-box" style=" width: 50; min-height: 50;">
                  <span class="info-box-icon bg-red" style="height: 50px; width: 50px;"><i class="fa fa-times"></i></span>
                  <!-- /.info-box-content -->
                </div>
              </a>
              <!-- /.info-box -->
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

        
          $editarReporte = new ControladorReportes();
          $editarReporte -> ctrCrearDetalleReporte();

      ?>

    </div>

  </div>

</div>


