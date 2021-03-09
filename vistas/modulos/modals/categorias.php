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

