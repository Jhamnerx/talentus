<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Ciudades
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Almacen</a></li>

      <li class="active">Gestor Ciudades</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
       
      <div class="box-header with-border">
         
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCiudad">
          
          Agregar Ciudad

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaCiudades" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Ciudad</th>
               <th>Prefijo</th>
               <th>Estado</th>
               <th>Acciones</th>

            </tr> 

          </thead>   
     
        </table>
          
      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR CIUDAD
======================================-->

<div id="modalAgregarCiudad" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Ciudad</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL NOMBRE DE LA CIUDAD
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg validarCiudad nombreCiudad" placeholder="Ingresar Ciudad" name="nombreCiudad" required> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA PARA LA DESCRIPCIÓN DE LA CIUDAD
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <input type="text" class="form-control input-lg prefijoCiudad" placeholder="Ingresar prefijo" name="prefijoCiudad" required> 

              </div> 

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Ciudad</button>

        </div>

      </form>

      <?php

        
          $crearCiudad = new ControladorCiudad();
          $crearCiudad -> ctrCrearCiudad();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR CIUDAD
======================================-->

<div id="modalEditarCiudad" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Ciudad</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL NOMBRE DE LA CIUDAD
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg validarCiudad editarNombreCiudad" placeholder="Ingresar Ciudad" name="editarNombreCiudad" required> 
                <input type="hidden" class="editarIdCiudad" name="editarIdCiudad" required> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA PARA LA DESCRIPCIÓN DE LA CIUDAD
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <input type="text" class="form-control input-lg editarPrefijoCiudad" placeholder="Ingresar prefijo" name="editarPrefijoCiudad" required> 

              </div> 

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar Cambios Ciudad</button>

        </div>

      </form>

      <?php

        
          $editarCiudad = new ControladorCiudad();
          $editarCiudad -> ctrEditarCiudad();

      ?>

    </div>

  </div>

</div>



