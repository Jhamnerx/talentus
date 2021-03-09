<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Productos / Servicios
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="almacen"><i class="fa fa-laptop"></i> Almacen</a></li>

      <li class="active"> Gestor Productos / Servicios</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
      <?php 


      if ($_SESSION["almacen"] == "true") {
        
       ?>
      <div class="box-header with-border">
         
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarServicio">
          
          Agregar Producto / Servicio

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaServicios" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Servicio</th>
               <th>Categoria</th>
               <th>Precio</th>
               <th>Stock</th>
               <th>Imagen</th>
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
MODAL AGREGAR SERVICIOS
======================================-->

<div id="modalAgregarServicio" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data" class="style_form">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Productos / Servicio</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL TITULO
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md validarServicio nombreServicio" placeholder="Ingresar Producto/Servicio" name="nombreServicio" required> 

              </div> 

            </div>

             <!--=====================================
            ENTRADA PARA EDITAR LA SELECCIÓN DE LA CATEGORÍA
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-md seleccionarCategoria" name="seleccionarCategoria" required>
                  

                  <?php

                  $item = null;
                  $valor = null;

                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';
                  }

                  ?>
  
                </select>

              </div>

            </div>

            <!--=====================================
            ENTRADA PARA EDITAR LA SELECCIÓN DEL TIPO
            ======================================-->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-md seleccionarTipo" name="seleccionarTipo" required>

                  <option value="articulo">Articulo</option>
                  <option value="servicio">Servicio</option>

  
                </select>

              </div>

            </div>

            <div class="form-group row">
                
              <div class="col-xs-6">

                <div class="panel">PRECIO</div>

                <div class="input-group">
              
                  <span class="input-group-addon"><i class="ion ion-social-usd"></i></span> 
                  <input class="form-control input-md precio" type="number" id="precioServicio" name="precioServicio" min="0" placeholder="Precio" required step="any"> 

                </div>

              </div>

              <div class="col-xs-6 ContenedorStock">

                <div class="panel">STOCK</div>
                   
                <div class="input-group">
                   
                  <input class="form-control input-md stock" type="number" id="stockServicio" name="stockServicio" min="0" placeholder="Stock">
                  <span class="input-group-addon"><i class="fa fa-laptop"></i></span>

                </div>

              </div>

            </div>

            <!--=====================================
            ENTRADA PARA LA DESCRIPCIÓN
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <textarea maxlength="120" class="form-control input-md" name="descripcionServicio"  rows="3" placeholder="Ingresar descripción"></textarea>

              </div> 

            </div>


            <!--=====================================
              FOTO
              ======================================-->

              <div class="form-group">
                
                <div class="panel">SUBIR FOTO</div>

                <input type="file" class="fotoServicio" name="fotoServicio" accept="image/x-png,image/jpeg">

                <p class="help-block">Tamaño recomendado 640px * 430px <br> Peso máximo de la foto 2MB</p>

                <img src="vistas/img/servicios/default/default.png" class="img-thumbnail previsualizaServicio" width="100px">

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

        
          $crearServicio = new ControladorServicios();
          $crearServicio -> ctrCrearServicio();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR SERVICIOS
======================================-->
<div id="modalEditarServicio" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Productos / Servicio</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL TITULO
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="text" class="form-control input-md nombreServicio" placeholder="Ingresar Producto/Servicio" name="editarNombreServicio" required> 

                <input type="hidden" name="editarIdServicio" class="editarIdServicio">

              </div> 

            </div>

             <!--=====================================
            ENTRADA PARA EDITAR LA SELECCIÓN DE LA CATEGORÍA
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-md seleccionarCategoria" name="seleccionarCategoria" required>
                  
                <?php

                  $item = null;
                  $valor = null;

                  $categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);

                  foreach ($categorias as $key => $value) {
                    
                    echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';
                  }

                  ?>
                </select>

              </div>

            </div>

            <!--=====================================
            ENTRADA PARA EDITAR LA SELECCIÓN DEL TIPO
            ======================================-->

             <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-md editar seleccionarTipo" name="seleccionarTipo" required>

                  <option value="articulo">Articulo</option>
                  <option value="servicio">Servicio</option>

  
                </select>

              </div>

            </div>

            <div class="form-group row">
                
              <div class="col-xs-6">

                <div class="panel">PRECIO</div>

                <div class="input-group">
              
                  <span class="input-group-addon"><i class="ion ion-social-usd"></i></span> 
                  <input class="form-control input-md precio" type="number" id="editarprecioServicio" name="editarprecioServicio" min="0" placeholder="Precio" required step="any">

                </div>

              </div>

              <div class="col-xs-6 contenedorStockEditar">

                <div class="panel">STOCK</div>
                   
                <div class="input-group">
                   
                  <input class="form-control input-md stock" type="number" id="stock" name="editarstockServicio" min="0" placeholder="Stock">
                  <span class="input-group-addon"><i class="fa fa-laptop"></i></span>

                </div>

              </div>

            </div>

            <!--=====================================
            ENTRADA PARA LA DESCRIPCIÓN
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-pencil"></i></span>

                <textarea maxlength="120" class="form-control input-md descripcionServicio" name="EditardescripcionServicio"  rows="3" placeholder="Ingresar descripción"></textarea>

              </div> 

            </div>


            <!--=====================================
              FOTO 
            ======================================-->

              <div class="form-group">
                
                <div class="panel">SUBIR FOTO</div>
                <input type="hidden" class="antiguaFotoServicio" name="antiguaFotoServicio">
                <input type="file" class="fotoServicio" name="fotoServicio" accept="image/x-png,image/jpeg">

                <p class="help-block">Tamaño recomendado 640px * 430px <br> Peso máximo de la foto 2MB</p>

                <img src="vistas/img/servicios/default/default.png" class="img-thumbnail previsualizaServicio" width="100px">

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

        
          $editarServicio = new ControladorServicios();
          $editarServicio -> ctrEditarServicio();

      ?>

    </div>

  </div>

</div>


 <?php

        
    // $eliminarServicio = new ControladorServicios();
    // $eliminarServicio -> ctrEliminarServicio();

  ?>

