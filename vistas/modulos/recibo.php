<div class="content-wrapper">

  <section class="content-header">

   <h1 class="reciboTitulo">
      Gestor Recibos
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="recibos"><i class="fa fa-laptop"></i> Recibos</a></li>

      <li class="active">Gestor Recibos</li>

    </ol>

  </section>

  <section class="content">


    <div class="box agregarRecibos" style="display:none;">

      <form method="post" enctype="multipart/form-data" name="formularioRecibo" id="formularioRecibo" class="style_form formularioRecibo">

        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label>Empresa</label>
          <select name="nEmpresa" class="form-control nEmpresa">
             <option value="Talentus">Talentus</option>
             <option value="Katary">Katary</option>
          </select>
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <!--=====================================
            ENTRADA DE LA EMPRESA
            ======================================-->
            <?php
                $opciones = ControladorCobros::ctrMostrarClientes();
            ?>

            <input type="hidden" class="autocomplete" value='<?php echo $opciones;?>'>


            <label for="empresa">Cliente:</label>



            <input type="text" id="autocomplete-ajax" class="form-control input-md empresa" value="" placeholder="Nombre Cliente" name="empresa" required>
            <input type="hidden" class="nameEmpresa" name="nameEmpresa">




        </div>

        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label>Fecha(*):</label>
          <input type="date" class="form-control fecha" name="fecha_hora" id="fecha_hora" required="">
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
          <label>Divisa:</label>
          <select name="divisa" class="form-control divisa" required="">
             <option value="PEN">PEN</option>
             <option value="USD">USD</option>
             <option value="EUR">EUR</option>
             <option value="MXN">MXN</option>
          </select>
        </div>

        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
          <label>Número Recibo:</label>
          <input type="text" class="form-control num_recibo" name="num_recibo" maxlength="10" placeholder="Número" required="">
        </div>

        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
          <label>Tipo Pago:</label>
          <select name="tipoPago" class="form-control tipoPago" required="">
             <option value="CREDITO">CREDITO</option>
             <option value="CONTADO">CONTADO</option>
             <option value="EFECTIVO">EFECTIVO</option>
             <option value="DEPOSITO EN CUENTA">DEPOSITO EN CTA</option>
          </select>
        </div>

        <div class="form-group col-xs-12">
          <a data-toggle="modal" href="#modalAgregarArticuloRecibo">
            <button onclick="agregarDetalleRecibos()" id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar</button>
          </a>
        </div>

        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
          <table id="detalles" class="table table-bordered table-striped dt-responsive table-hover tblListadoArcticulosRecibo">
            <thead style="background-color:#A9D0F5">
                  <th>Opciones</th>
                  <th>Cantidad</th>
                  <th>Descripcion</th>
                  <th>Precio Unitario</th>
                  <th>Importe</th>
              </thead>
              <tfoot>
                  <th>TOTAL</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th><h4 id="total">S/. 0.00</h4><input type="hidden" name="total_recibo" id="total_recibo"></th>
              </tfoot>
              <tbody>

              </tbody>
          </table>
        </div>

        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <button class="btn btn-primary guardarRecibo" type="button"><i class="fa fa-save"></i> Guardar</button>

          <button class="btn btn-danger btnCancelar" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
        </div>
      </form>



    </div>




    <div class="box listaRecibos">
      <?php


      if ($_SESSION["ventas"] == "true") {

       ?>
      <div class="box-header with-border">

        <button class="btn btn-primary btnAgregarRecibo">

          Añadir Recibos

        </button>

        <button class="btn btn-success btnObtenerReporte" data-toggle="modal" data-target="#modalObtenerReporte">

          Reporte Diario

        </button>
      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive table-hover tablaRecibos" width="100%">

          <thead>

            <tr>

               <th style="width:10px">#</th>
               <th style="width:120px">Opciones</th>
               <th>Cliente</th>
               <th>Numero</th>
               <th>Tipo pago</th>
               <th>Total Recibo</th>
               <th>Fecha</th>
               <th>Estado</th>
               <th></th>


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

 <?php


    $eliminarRecibo = new ControladorRecibos();
    $eliminarRecibo -> ctrEliminarRecibo();

  ?>

<!--=====================================
MODAL EDITAR RECIBO
======================================-->

<div id="modalEditarRecibo" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="post" enctype="multipart/form-data" class="formularioEditarRecibo">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar Recibo</h4>

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

              <label>Empresa:</label>
              <select name="nEmpresa" class="form-control nEmpresa">
                   <option value="Talentus">Talentus</option>
                   <option value="Katary">Katary</option>
              </select>

              <input type="hidden" class="idReciboEditar" name="idReciboEditar">
                  <!-- /btn-group -->


            </div>

            <div class="form-group col-sm-6 col-xs-12">

              <label>Cliente:</label>


              <input type="text" class="form-control clienteEditar" name="clienteEditar" readonly="">
              <input type="hidden" class="form-control clienteIdEditar" name="clienteIdEditar">
                  <!-- /btn-group -->

            </div>
            <div class="form-group col-sm-6 col-xs-12">

              <label>Fecha(*):</label>

              <input type="date" class="form-control fechaEditar" name="fechaEditar" id="fechaEditar" required="" >

            </div>

            <div class="form-group col-sm-6 col-xs-12">

              <label>Divisa(*):</label>
              <select name="divisaEditar" class="form-control divisaEditar" required="">
                <option value="PEN">PEN</option>
                <option value="USD">USD</option>
                <option value="EUR">EUR</option>
                <option value="MXN">MXN</option>
              </select>

            </div>


            <div class="form-group col-sm-6 col-xs-12">

              <label>Número Recibo(*):</label>
              <input type="text" class="form-control num_reciboEditar" name="num_reciboEditar" maxlength="10" required="">


            </div>

            <div class="form-group col-sm-6 col-xs-12">


              <label>Tipo Pago(*):</label>

              <select name="tipoPagoEditar" class="form-control tipoPagoEditar" required="">
                 <option value="CREDITO">CREDITO</option>
                 <option value="CONTADO">CONTADO</option>
                 <option value="EFECTIVO">EFECTIVO</option>
              </select>

            </div>

            <div class="form-group col-lg-12 col-xs-12">


              <div class="ListaDetalleReporte">
                <span><b>Lista de Acciones:</b></span>

              </div>

            </div>

            <div class="col-xs-6">
               <label>Cancelado</label>
              <a href="" style="text-decoration: none;" class="CambiarEstado" estado="0">
                <div class="info-box" style=" width: 50; min-height: 50;">
                  <span class="info-box-icon bg-green" style="height: 50px; width: 50px;"><i class="fa fa-check"></i></span>
                  <!-- /.info-box-content -->
                </div>
              </a>
              <!-- /.info-box -->
            </div>
            <div class="col-xs-6">
              <label>Por Cobrar</label>
              <a href="" style="text-decoration: none;" class="CambiarEstado" estado="1">
                <div class="info-box" style=" width: 50; min-height: 50;">
                  <span class="info-box-icon bg-orange" style="height: 50px; width: 50px;"><i class="fa fa-bell-o"></i></span>
                  <!-- /.info-box-content -->
                </div>
              </a>
              <!-- /.info-box -->
            </div>

            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 table-responsive">
              <table id="detallesEditar" class="table table-bordered table-striped dt-responsive table-hover">
                <thead style="background-color:#A9D0F5">
                      <th>Descripcion</th>
                      <th>Cantidad</th>
                      <th>Precio Unitario</th>
                      <th>Importe</th>
                  </thead>
                  <tfoot>
                      <th>TOTAL</th>
                      <th></th>
                      <th style="text-align: right;" colspan="2"><h4 id="totalEditar" class="totalEditar">S/. 0.00</h4><input class="total_reciboEditar" type="hidden" name="total_reciboEditar" id="total_reciboEditar"></th>
                  </tfoot>
                  <tbody class="tblDetalleRecibo">

                  </tbody>
              </table>
            </div>



          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary btnGuardarEditar">Guardar</button>

        </div>

      </form>

      <?php


          // $editarReporte = new ControladorReportes();
          // $editarReporte -> ctrCrearDetalleReporte();

      ?>

    </div>

  </div>

</div>




<!-- reporte diario -->

<!--=====================================
MODAL REPORTE RECIBO
======================================-->

<div id="modalObtenerReporte" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="post" enctype="multipart/form-data" class="formularioEditarRecibo">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">REPORTE DIARIO DE RECIBOS</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
        <div class="col-md-12">
          <div class="box box-warning box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">SELECCIONAR FECHAS</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">


              <div class="form-group col-xs-6">
                <label>Fecha Inicio(*):</label>
                <input type="date" class="form-control fechaReciboChange fechaReciboInicio" name="fechaReciboInicio" id="fechaReciboInicio" required="">
              </div>

              <div class="form-group col-xs-6">
                <label>Fecha Fin(*):</label>
                <input type="date" class="form-control fechaReciboChange fechaReciboFin" name="fechaReciboFin" id="fechaReciboFin" required="">
              </div>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>


        <div class="modal-body">

          <div class="box-body table-responsive">
            <table class="table table-bordered table-striped dt-responsive table-hover tablaReporteRecibo" width="100%">

              <thead>

                <tr>

                   <th style="width:10px">#</th>
                   <th>Cliente</th>
                   <th>Numero</th>
                   <th>Tipo pago</th>
                   <th>Total Recibo</th>
                   <th>Fecha</th>
                   <th>Estado</th>

                </tr>

              </thead>

            </table>



          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>


        </div>

      </form>



    </div>

  </div>

</div>
