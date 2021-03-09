<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Certificado
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Almacen</a></li>

      <li class="active">Gestor Certificado</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
       
      <div class="box-header with-border">
         
        <button class="btn btn-primary modalAgregarCertificado" data-toggle="modal" data-target="#modalAgregarCertificado">
          
          Agregar Certificado

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaCertificado" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Codigo</th>
               <th>Descargar</th>
               <th>Cliente</th>
               <th>Dispositivo</th>
               <th>Fin Cobe</th>
               <th>Fecha </th>
               <th>Caracteristicas </th>
               <th>Estado </th>
               <th>Acciones </th>

            </tr> 

          </thead>   
     
        </table>
          
      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR CERTIFICADO
======================================-->

<div id="modalAgregarCertificado" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Certificado</h4>

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

              <label>Numero Certificado:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md numCertificado" placeholder="Ejem. 205" name="numCertificado" required> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              
              <label>Cliente:</label>

              <div class="input-group">

	              <select name="idcliente" class="form-control select2 idcliente" data-live-search="true" required>

	              </select>


	              <div class="input-group-btn">

	                <button type="button" class="btn btn-danger btnAgregarCliente" data-toggle="modal" data-target="#modalAgregarCliente">...</button>
	              </div>
                  <!-- /btn-group -->
                  
              </div>

            </div>

            <!--=====================================
            ENTRADA DEL DISPOSITIVO
            ======================================-->

            <div class="form-group col-xs-6">

              <label>Dispositivo:</label>

              <div class="input-group">

                  <select name="dispositivo" class="form-control select2 dispositivo" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn">
                  	<a href="dispositivos">
                  		<button type="button" class="btn btn-danger btnAgregarDispositivo" href="dispositivos" data-toggle="modal" data-target="#modalAgregarDispositivo">...</button>

                  	</a>

                  </div>
                  <!-- /btn-group -->
                  
              </div>
              
            </div>

            <div class="form-group col-sm-6 col-xs-12">
                <!--=====================================
                ENTRADA DE LA EMPRESA
                ======================================-->
                <?php
                    $opciones = ControladorCertificados::ctrMostrarVehiculos(null, null);

                ?>

                <input type="hidden" class="autocompleteVehiculos" value='<?php echo $opciones;?>'>
              <label>Vehiculo:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" id="autocomplete-ajax" class="form-control input-md vehiculo" placeholder="Placa Vehiculo" name="vehiculo" required> 
                <input type="hidden" class="idvehiculo" name="idvehiculo">

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL CIUDAD
            ======================================-->
           <div class="form-group col-sm-6 col-xs-12">

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

          <button type="submit" class="btn btn-primary">Guardar Certificado</button>

        </div>

      </form>

      <?php

        
          $crearCertificado = new ControladorCertificados();
         $crearCertificado -> ctrCrearCertificado();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR CERTIFICADO
======================================-->

<div id="modalEditarCertificado" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Certificado</h4>

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

              <label>Numero Certificado:</label>

              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md editarnumCertificado" placeholder="Ejem. 205" name="editarnumCertificado" required> 
                <input type="hidden" class="editaridCertificado" name="editaridCertificado"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA DEL VEHICULO
            ======================================-->

            <div class="form-group col-sm-6 col-xs-12">
              
              <label>Cliente:</label>

              <div class="input-group">

                <select name="certificadoidcliente" class="form-control select2 idcliente certificadoidcliente" data-live-search="true" required>

                </select>


                <div class="input-group-btn">

                  <button type="button" class="btn btn-danger btnAgregarCliente" data-toggle="modal" data-target="#modalAgregarCliente">...</button>
                </div>
                  <!-- /btn-group -->
                  
              </div>

            </div>

            <!--=====================================
            ENTRADA DEL DISPOSITIVO
            ======================================-->

            <div class="form-group col-xs-6">

              <label>Dispositivo:</label>

              <div class="input-group">

                  <select name="editardispositivo" class="form-control select2 dispositivo editardispositivo" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn">
                    <a href="dispositivos">
                      <button type="button" class="btn btn-danger btnAgregarDispositivo" href="dispositivos" data-toggle="modal" data-target="#modalAgregarDispositivo">...</button>

                    </a>

                  </div>
                  <!-- /btn-group -->
                  
              </div>
              
            </div>

                <!--=====================================
                ENTRADA DEL VEHICULO
                ======================================-->
                <?php
                    $opciones = ControladorCertificados::ctrMostrarVehiculos(null, null);
                ?>

                <input type="hidden" class="autocompleteVehiculosEditar" value='<?php echo $opciones;?>'>

                <div class="form-group col-sm-6 col-xs-12">

                    <label for="empresa">Vehiculo:</label>

                    <div class="input-group" >
                
                        <span class="input-group-addon"><i class="fa fa-th"></i></span>

                        <input type="text" id="autocomplete-ajax-editar" class="form-control input-md editarVehiculo" name="editarVehiculo"> 
                        <input type="hidden"   class="idEditarVehiculo" name="idEditarVehiculo">

                    </div> 

                </div>
            <!--=====================================
            ENTRADA DEL CIUDAD
            ======================================-->
           <div class="form-group col-sm-6 col-xs-12">

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

            <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">

              <label style="padding-bottom: 20px;">Caracteristicas</label><br>
              <label>
                <input type="checkbox" class="flat-red editarfondo" name="editarfondo">
                Fondo  
              </label> <br>
              <label>
                <input type="checkbox" class="flat-red editarsello" name="editarsello">
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

          <button type="submit" class="btn btn-primary">Guardar Certificado</button>

        </div>

      </form>


      <?php

        
          $editarCertificado = new ControladorCertificados();
          $editarCertificado -> ctrEditarCertificado();

      ?>

    </div>

  </div>

</div>


