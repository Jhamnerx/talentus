<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Dispositivos
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Dispositivos</a></li>

      <li class="active">Gestor Dispositivos</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
       
      <div class="box-header with-border">
         
        <button class="btn btn-primary modalAgregarDispositivo" data-toggle="modal" data-target="#modalAgregarDispositivo">
          
          Agregar Dispositivos

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaDispositivos" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Modelo</th>
               <th>Marca</th>
               <th>Codigo de Homologacion</th>
               <th>Caracteristicas</th>
               <th>Acciones</th>

            </tr> 

          </thead>   
     
        </table>
          
      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR DISPOSITIVO
======================================-->

<div id="modalAgregarDispositivo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Dispositivo</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL MODELO DEL DISPOSITIVO
            ======================================-->

            <div class="form-group">
              <label>Modelo:</label>
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg validarModelo modelo" placeholder="Ingresar Modelo" name="modelo" required> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA PARA LA MARCA DEL DISPOSITIVO
            ======================================-->

            <div class="form-group">
              <label>Marca:</label>
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                 <input type="text" class="form-control input-lg validarMarca Marca" placeholder="Ingresar Marca" name="marca" required> 

              </div> 

            </div>
            <!--=====================================
            ENTRADA PARA EL CODIGO DE H DEL DISPOSITIVO
            ======================================-->

            <div class="form-group">
              <label>Codigo de Homologacion:</label>
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                 <input type="text" class="form-control input-lg Codigo" placeholder="Ingresar Codigo de Homologacion" name="codeHomologacion"> 

              </div> 

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Dispositivo</button>

        </div>

      </form>
      <?php

        
          $crearDispositivo = new ControladorDispositivos();
          $crearDispositivo -> ctrCrearDispositivo();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR DISPOSITIVO
======================================-->

<div id="modalEditarDispositivo" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

     <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Dispositivo</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL MODELO DEL DISPOSITIVO
            ======================================-->

            <div class="form-group">
              <label>Modelo:</label>
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg validarModelo modelo" placeholder="Ingresar Modelo" name="editarmodelo" required> 
                <input type="hidden" class="idDispositivoEditar" name="editarIdDispositivo">

              </div> 

            </div>

            <!--=====================================
            ENTRADA PARA LA MARCA DEL DISPOSITIVO
            ======================================-->

            <div class="form-group">
              <label>Marca:</label>
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                 <input type="text" class="form-control input-lg validarMarca Marca" placeholder="Ingresar Marca" name="editarmarca" required> 

              </div> 

            </div>
            <!--=====================================
            ENTRADA PARA EL CODIGO DE H DEL DISPOSITIVO
            ======================================-->

            <div class="form-group">
              <label>Codigo de Homologacion:</label>
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                 <input type="text" class="form-control input-lg Codigo" placeholder="Ingresar Codigo de Homologacion" name="editarcodeHomologacion"> 

              </div> 

            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Dispositivo</button>

        </div>

      </form>

      <?php

        
          $editarDispositivo = new ControladorDispositivos();
          $editarDispositivo -> ctrEditarDispositivo();

      ?>

    </div>

  </div>

</div>


