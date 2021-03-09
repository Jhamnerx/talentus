<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Cobranzas
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li class="active">Gestor Cobranzas</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
       
      <div class="box-header with-border">
         
        <button class="btn btn-primary btnAgregarCobro" data-toggle="modal" data-target="#modalAgregarCobranzas">
          
          Agregar Registro

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaCobranzas" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th style="width:10px">Ver</th>
               <th>Empresa</th>
               <th>Estado</th>
               <th>Fecha Vencimiento</th>
               <th>Periodo</th>
               <th>Monto x unidad</th>
               <th>N/Unidades</th>

               <th>Acciones</th>



            </tr> 

          </thead>   
     
        </table>
          
      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR COBRO
======================================-->

<div id="modalAgregarCobranzas" class="modal fade modalAgregarCobranzas" role="dialog">
  
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Registro Cobro</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
            <div class="box-body">


                <!--=====================================
                ENTRADA DE LA EMPRESA
                ======================================-->
                <?php
                    $opciones = ControladorCobros::ctrMostrarClientes();
                ?>

                <input type="hidden" class="autocomplete" value='<?php echo $opciones;?>'>

                <div class="form-group col-sm-5 col-xs-12">

                    <label for="empresa">Empresa:</label>

                    <div class="input-group" >
                
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" id="autocomplete-ajax" class="form-control input-md empresa" value="" placeholder="Nombre Empresa" name="empresa" required> 
                          <input type="hidden" class="nameEmpresa" name="nameEmpresa">
                    </div> 

                </div>
                <!--FECHA---->
                <div class="form-group col-sm-4 col-xs-12">

                    <label for="fecha_hora">Fecha Vencimiento:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                        <input type="date" class="form-control input-md fecha" name="fecha_hora" id="fecha_hora" required="">
                    
                    </div> 

                </div>

                <div class="form-group col-sm-3 col-xs-12">

                    <label for="periodo">Periodo:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>

                        <select name="periodo" class="form-control periodo" required="">
                            <option value="QUINCENAL">QUINCENAL</option>
                            <option value="MENSUAL">MENSUAL</option>
                            <option value="BIMENSUAL">BIMENSUAL</option>
                            <option value="TRIMESTRAL">TRIMESTRAL</option>
                            <option value="ANUAL">ANUAL</option>

                        </select> 

                    </div> 

                </div>

                <div class="form-group col-sm-3 col-xs-12">

                    <label for="monto">S/. X unidad:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>

                        <input type="text" class="form-control input-md montoxunidad" placeholder="Monto por unidad" name="monto"> 

                    </div> 

                </div>

                <div class="form-group col-sm-3 col-xs-12">

                    <label for="cantidadunidad">Cantidad unidades:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-car"></i></span>

                        <input type="number" min="1" value='1' class="form-control input-md cantidadunidad" placeholder="Cantidad de unidades" name="cantidadunidad"> 

                    </div> 

                </div>

                <div class="form-group col-sm-3 col-xs-12">

                    <label for="ciudad">Ciudad:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-plus"></i></span>

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

                </div>



                <div class="form-group col-sm-3 col-xs-12">

                    <label for="tipoPago">Tipo de pago</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>

                        <input type="text" class="form-control input-md tipoPago" placeholder="Tipo de pago" name="tipoPago"> 

                    </div> 

                </div>

                <div class="form-group col-sm-12 col-xs-12">

                    <label for="observacion">Observacion</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-eye"></i></span>

                        <textarea rows="5" class="form-control input-md observacion" placeholder="" name="observacion"></textarea>

                    </div> 

                </div>

            </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Registro</button>

        </div>

      </form>

      <?php

        
          $crearRegistroCobro = new ControladorCobros();
           $crearRegistroCobro -> ctrCrearRegistroCobro();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR COBRO
======================================-->

<div id="modalEditarCobro" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Registro Cobro</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
            <div class="box-body">


                <!--=====================================
                ENTRADA DE LA EMPRESA
                ======================================-->
                <?php
                    $opciones = ControladorCobros::ctrMostrarClientes();
                ?>

                <input type="hidden" class="autocomplete" value='<?php echo $opciones;?>'>

                <div class="form-group col-sm-5 col-xs-12">

                    <label for="empresa">Empresa:</label>

                    <div class="input-group" >
                
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="hidden" class="idEditarCobro" name="idEditarCobro">

                        <input type="text" readonly="" class="form-control input-md editarEmpresa" name="editarEmpresa"> 
                        
                    </div> 

                </div>
                <!--FECHA---->
                <div class="form-group col-sm-4 col-xs-12">

                    <label for="fecha_hora">Fecha Vencimiento:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                        <input type="date" class="form-control input-md editarFecha" name="editarFecha">
                    
                    </div> 

                </div>

                <div class="form-group col-sm-3 col-xs-12">

                    <label for="periodo">Periodo:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>

                        <select name="editarPeriodo" class="form-control editarPeriodo">
                            <option value="QUINCENAL">QUINCENAL</option>
                            <option value="MENSUAL">MENSUAL</option>
                            <option value="BIMENSUAL">BIMENSUAL</option>
                            <option value="TRIMESTRAL">TRIMESTRAL</option>
                            <option value="ANUAL">ANUAL</option>

                        </select> 

                    </div> 

                </div>

                <div class="form-group col-sm-3 col-xs-12">

                    <label for="monto">S/. X unidad:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>

                        <input type="text" class="form-control input-md editarMonto" name="editarMonto"> 

                    </div> 

                </div>

                <div class="form-group col-sm-3 col-xs-12">

                    <label for="cantidadunidad">Cantidad unidades:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-car"></i></span>

                        <input type="number" min="1" class="form-control input-md editarCantidadunidad" name="editarCantidadunidad"> 

                    </div> 

                </div>

                <div class="form-group col-sm-3 col-xs-12">

                    <label for="ciudad">Ciudad:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-plus"></i></span>

                        <select name="editarCiudad" class="form-control editarCiudad" required="">
                            <?php 

                            $ciudad = ControladorPlantilla::ctrSeleccionarCiudad();

                            // var_dump($ciudad);

                            foreach ($ciudad as $key => $value) {

                                echo "<option value='".$value['id']."'>".$value['nombre']."</option>";
                            }
                            ?>

                        </select> 

                    </div> 

                </div>



                <div class="form-group col-sm-3 col-xs-12">

                    <label for="tipoPago">Tipo de pago</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>

                        <input type="text" class="form-control input-md editarTipoPago" placeholder="Tipo de pago" name="editarTipoPago"> 

                    </div> 

                </div>

                <div class="form-group col-sm-12 col-xs-12">

                    <label for="observacion">Observacion</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-eye"></i></span>

                        <textarea rows="5" class="form-control input-md editarObservacion" placeholder="" name="editarObservacion"></textarea>

                    </div> 

                </div>

            </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Registro</button>

        </div>

      </form>

      <?php

        
            $editarRegistroCobro = new ControladorCobros();
            $editarRegistroCobro -> ctrEditarRegistroCobro();

      ?>

    </div>

  </div>

</div>
<!--=====================================
MODAL PAGAR
======================================-->

<div id="modalPagar" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Marcar como Pagado</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
            <div class="box-body">

                <div class="form-group col-sm-8 col-xs-12">

                    <label for="empresa">Empresa:</label>

                    <div class="input-group" >
                
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>

                        <input type="text" readonly="" class="form-control input-md PagarEmpresa" name="PagarEmpresa"> 
                        <input type="hidden" name="pagarIdCobro" class="pagarIdCobro">
                    </div> 

                </div>
                <!--FECHA---->
                <div class="form-group col-sm-4 col-xs-12">

                    <label for="fecha_hora">Fecha Vencimiento:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                        <input type="date" class="form-control input-md pagarFecha" name="pagarFecha">
                    
                    </div> 

                </div>

                <div class="form-group col-sm-3 col-xs-12">

                    <label for="monto">S/. X unidad:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>

                        <input type="text" class="form-control input-md pagarMonto" readonly="" name="pagarMonto"> 

                    </div> 

                </div>

                <div class="form-group col-sm-3 col-xs-12">

                    <label for="cantidadunidad">Cantidad unidades:</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-car"></i></span>

                        <input type="number" readonly="" min="1" class="form-control input-md pagarCantidadunidad" name="pagarCantidadunidad"> 

                    </div> 

                </div>





                <div class="form-group col-sm-3 col-xs-12">

                    <label for="tipoPago">Tipo de pago</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-money"></i></span>

                        <input required="" type="text" class="form-control input-md pagoTipoPago" placeholder="Tipo de pago" name="pagoTipoPago" > 

                    </div> 

                </div>

                <div class="form-group col-sm-12 col-xs-12">

                    <label for="descripcion">Descripcion</label>

                    <div class="input-group">
                
                        <span class="input-group-addon"><i class="fa fa-eye"></i></span>

                        <textarea rows="4" class="form-control input-md pagoDescripcion" name="pagoDescripcion"></textarea>

                    </div> 

                </div>


            </div>
                <hr>
                <span class="totalPagar">TOTAL:</span>
                <input class="cantidadPago" type="hidden" name="cantidadPago">
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Marcar Pagado</button>

        </div>

      </form>

      <?php

        
          $marcarRegistroCobro = new ControladorCobros();
           $marcarRegistroCobro -> ctrPagarRegistroCobro();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL VER
======================================-->

<div id="modalVerInfoCobro" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-md">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Informacion</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
            <div class="box-body">

                <ul class="list-group">
                    <li class="list-group-item"><b>Empresa: </b><span class="empresa"></span></li>
                    <li class="list-group-item"><b>Fecha Venci: </b><span class="fechavencimiento"></span></li>
                    <li class="list-group-item"><b>Periodo: </b><span class="periodo"></span></li>
                    <li class="list-group-item"><b>Monto x unidad: </b><span class="montoxunidad"></span></li>
                    <li class="list-group-item"><b># Unidades: </b><span class="cantunidades"></span></li>
                    <li class="list-group-item"><b>Ciudad: </b><span class="ciudad"></span></li>
                    <li class="list-group-item"><b>Tipo Pago: </b><span class="tipopago"></span></li>
                    <li class="list-group-item"><b>Observacion: </b><span class="observacion"></span></li>
                </ul>

                <div class="col-md-12">
                    <div class="box box-default collapsed-box">

                        <div class="box-header with-border">
                            <h3 class="box-title">Ver Registro Pagos</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="box-body tablaRegistro">
                            <div class="table100 ver4 m-b-110 table-responsive">
                                <table data-vertable="ver4" class="table no-margin">
                                    <thead>
                                        <tr class="row100 head">
                                            <th class="column100 column1" data-column="column1">#</th>
                                            <th class="column100 column2" data-column="column2">Tipo Pago</th>
                                            <th class="column100 column3" data-column="column3">Cantidad</th>
                                            <th class="column100 column4" data-column="column4">Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody class="listaRegistro" id="listaRegistro">

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
                
        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Marcar Pagado</button>

        </div>

      </form>


    </div>

  </div>

</div>



 <?php

        
    // $eliminarCobranzas = new ControladorCobranzas();
    // $eliminarCobranzas -> ctrEliminarCobranzas();

  ?>

