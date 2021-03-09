<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Contacto
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Almacen</a></li>

      <li class="active">Gestor Contacto</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
       
      <div class="box-header with-border">
         
        <button class="btn btn-primary modalAgregarContacto" data-toggle="modal" data-target="#modalAgregarContacto">
          
          Agregar Contacto

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaContacto" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Flota</th>
               <th>Nombres</th>
               <th>Telefono</th>
               <th>Email</th>
               <th>Opciones</th>

            </tr> 

          </thead>   
     
        </table>
          
      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR CONTACTO
======================================-->

<div id="modalAgregarContacto" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar contacto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL NAME DE LA CONTACTO
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg nombreContacto" placeholder="Ingresar Contacto" name="nombreContacto" required> 

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
            ENTRADA TELEFONO
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg telefonoContacto" placeholder="TELEFONO (coma)" name="telefonoContacto"> 

              </div> 

            </div>
            <!--=====================================
            ENTRADA EMAIL
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInput input-lg emailContacto" placeholder="EMAIL (coma)" name="emailContacto"> 

              </div> 

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar contacto</button>

        </div>

      </form>

      <?php

        
          $crearContacto = new ControladorContacto();
          $crearContacto -> ctrCrearContacto();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR CONTACTO
======================================-->

<div id="modalEditarContacto" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar contacto</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">
            <!--=====================================
            ENTRADA DEL NAME DE LA CONTACTO
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg editarNombreContacto" placeholder="Ingresar Contacto" name="editarNombreContacto" required> 
                <input type="hidden" class="form-control input-lg editarIdContacto"  name="editarIdContacto" > 

              </div> 

            </div>
             <!--=====================================
            ENTRADA FLOTA DEL VEHICULO
            ======================================-->
            <div class="form-group col-xs-12">

              <label>Flota:</label>

              <div class="input-group">

                  <select name="flota" class="form-control select2 idflota editarFlota" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger btnAgregarFlota" data-toggle="modal" data-target="#modalAgregarFlota">...</button> 
                  </div>
                  <!-- /btn-group -->
                  
              </div>

            </div>
            <!--=====================================
            ENTRADA TELEFONO
            ======================================-->

            <div class="form-group editarTelefonoContacto">
<!--               
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg editarTelefono" placeholder="TELEFONO (coma)" name="telefonoContacto"> 

              </div>  -->

            </div>
            <!--=====================================
            ENTRADA EMAIL
            ======================================-->

            <div class="form-group editarEmailContacto">
<!--               
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInput input-lg editarEmail" placeholder="EMAIL (coma)" name="emailContacto"> 

              </div>  -->

            </div>





          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios contacto</button>

        </div>

      </form>

      <?php

        
          $editarContacto = new ControladorContacto();
          $editarContacto -> ctrEditarContacto();

      ?>

    </div>

  </div>

</div>

 <?php

        
    // $eliminarContacto = new ControladorContacto();
    // $eliminarContacto -> ctrEliminarContacto();

  ?>

