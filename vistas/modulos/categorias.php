<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Categorias
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Almacen</a></li>

      <li class="active">Gestor Categorias</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">

      <?php 


      if ($_SESSION["almacen"] == "true") {
        
       ?>
       
      <div class="box-header with-border">
         
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">
          
          Agregar Categoria

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaCategorias" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Categoria</th>
               <th>Descripcion</th>
               <th>Estado</th>
               <th>Acciones</th>

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
MODAL AGREGAR CATEGORÍA
======================================-->

<div id="modalAgregarCategoria" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar categoría</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL TITULO DE LA CATEGORÍA
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg validarCategoria nombreCategoria" placeholder="Ingresar Categoria" name="nombreCategoria" required> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA PARA LA DESCRIPCIÓN DE LA CATEGORÍA
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <textarea maxlength="120" class="form-control input-lg" name="descripcionCategoria"  rows="3" placeholder="Ingresar descripción categoría"></textarea>

              </div> 

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar categoría</button>

        </div>

      </form>

      <?php

        
          $crearCategoria = new ControladorCategorias();
          $crearCategoria -> ctrCrearCategoria();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR CATEGORÍA
======================================-->

<div id="modalEditarCategoria" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar categoría</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL TITULO DE LA CATEGORÍA
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-lg validarCategoria nombreCategoria" placeholder="Ingresar Categoria" name="editarNombreCategoria" required> 

                <input type="hidden" class="editarIdCategoria" name="editarIdCategoria">

              </div> 

            </div>


            <!--=====================================
            ENTRADA PARA LA DESCRIPCIÓN DE LA CATEGORÍA
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <textarea maxlength="120" class="form-control input-lg descripcionCategoria" name="descripcionCategoria"  rows="3" placeholder="Ingresar descripción categoría"></textarea>

              </div> 

            </div>





          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios categoría</button>

        </div>

      </form>

      <?php

        
          $editarCategoria = new ControladorCategorias();
          $editarCategoria -> ctrEditarCategoria();

      ?>

    </div>

  </div>

</div>

 <?php

        
    $eliminarCategoria = new ControladorCategorias();
    $eliminarCategoria -> ctrEliminarCategoria();

  ?>

