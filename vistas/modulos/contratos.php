<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Contratos
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="contratos"><i class="fa fa-laptop"></i> Contratos</a></li>

      <li class="active">Gestor Contratos</li>

    </ol>

  </section>

  <section class="content">


    <div class="box agregarContratos" style="display:none;">

      <form method="post" enctype="multipart/form-data" name="formularioContrato" id="formularioContrato" class="style_form formularioContrato">
        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <label>Cliente(*):</label>
          <div class="input-group">
              <select name="idcliente" class="form-control select2 idcliente" data-live-search="true" required>

              </select>

              <div class="input-group-btn">

                <button type="button" class="btn btn-danger btnAgregarCliente" data-toggle="modal" data-target="#modalAgregarCliente">...</button>
              </div>
              <!-- /btn-group -->

          </div>
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">

          <label>Fecha(*):</label>
          <input type="text" class="form-control pull-right fechaContrato" id="datepicker" name="fechaContrato" required="">

        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label>Ciudad(*):</label>
          <select name="ciudad" class="form-control ciudad" required="">
            <?php

            $ciudad = ControladorPlantilla::ctrSeleccionarCiudad();

           // var_dump($ciudad);

            foreach ($ciudad as $key => $value) {

              echo "<option value='".$value['nombre']."'>".$value['nombre']."</option>";
            }
             ?>

          </select>
        </div>
                <!-- checkbox -->
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


        <div class="form-group col-xs-12">
          <a data-toggle="modal" href="#modalAgregarArticuloContrato">
            <button id="btnAgregarVehiculo" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Vehiculo</button>
          </a>
        </div>

        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
          <table id="detallesvehiculos" class="table table-bordered table-striped dt-responsive table-hover tblListadoArcticulosContrato">
            <thead style="background-color:#A9D0F5">
                  <th>Opciones</th>
                  <th>Placa</th>
                  <th>Plan</th>
              </thead>
              <tfoot>
                  <th></th>
                  <th></th>
                  <th>

                  </th>
              </tfoot>
              <tbody>

              </tbody>
          </table>
        </div>

        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <button class="btn btn-primary guardarContrato" type="button"><i class="fa fa-save"></i> Guardar</button>

          <button class="btn btn-danger btnCancelar" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
        </div>
      </form>



    </div>




    <div class="box listaContratos">
      <?php


      if ($_SESSION["ventas"] == "true") {

       ?>
      <div class="box-header with-border">

        <button class="btn btn-primary btnAgregarContrato">

          Añadir Contratos

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive table-hover tablaContratos" width="100%">

          <thead>

            <tr>
                <th style="width:10px">#</th>
                <th>Descargar</th>
                <th>Cliente</th>
                <th>Vehiculos</th>
                <th>Ciudad</th>
                <th>Plan</th>
                <th>Fecha</th>
                <th>Caracteristicas</th>
                <th>Estado</th>
                <th>Editar</th>


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
MODAL AÑADIR VEHICULO
======================================-->

<div id="modalAgregarArticuloContrato" class="modal fade" role="dialog">

  <div class="modal-dialog modal-md">

    <div class="modal-content">
      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->

      <div class="modal-header" style="background:#3c8dbc; color:white">

        <button type="button" class="close" data-dismiss="modal">&times;</button>

        <h4 class="modal-title">Agregar Vehiculos</h4>

      </div>
      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->
      <div class="modal-body">

        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive table-responsive table-hover tablaAddVehiculoContratos" width="100%">

            <thead>

              <tr>

               <th style="width:10px">#</th>
               <th>Placa</th>
               <th>Marca</th>
               <th>Modelo</th>
               <th>Flota</th>
               <th>Acciones</th>

              </tr>

            </thead>

          </table>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        </div>
      </div>


    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR CONTRATO
======================================-->

<div id="modalEditarContrato" class="modal fade" role="dialog">

  <div class="modal-dialog">

    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar Contrato</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <div class="form-group col-xs-12">
              <label>Cliente(*):</label>
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md editarClienteContrato" placeholder="Cliente" name="editarClienteContrato" readonly="">

                <input type="hidden" class="editarIdContrato" name="editarIdContrato">

              </div>

            </div>



            <div class="form-group col-sm-6 col-xs-12">
              <label>Fecha(*):</label>
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>


                <input type="text" class="form-control pull-right editarFechaContrato datepicker" id="datepickerEditar" name="editarFechaContrato">
              </div>

            </div>

            <div class="form-group col-sm-6 col-xs-12">
              <label>Ciudad(*):</label>
              <div class="input-group">

                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                <select name="contratoEditarciudad" class="form-control contratoEditarciudad" required="">
                  <?php

                  $ciudad = ControladorPlantilla::ctrSeleccionarCiudad();

                 // var_dump($ciudad);

                  foreach ($ciudad as $key => $value) {

                    echo "<option value='".$value['nombre']."'>".$value['nombre']."</option>";
                  }
                   ?>

                </select>
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


           $editarContrato = new ControladorContratos();
           $editarContrato -> ctrEditarContrato();

      ?>

    </div>

  </div>

</div>


 <?php


    $eliminarContrato = new ControladorContratos();
    $eliminarContrato -> ctrEliminarContrato();

  ?>




<?php
include "modals/clientes.php";
 ?>
