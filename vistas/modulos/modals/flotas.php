<!--=====================================
MODAL AGREGAR FLOTA
======================================-->

<div id="modalAgregarFlota" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Flota</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL NOMBRE DE LA FLOTA
            ======================================-->

            <div class="form-group col-lg-12 col-xs-12">
              <label>Nombre Flota(*):</label>                
                
                <input type="text" class="form-control input-md validarFlota nombreFlota" placeholder="Ingresar Flota" name="nombreFlota" required> 


            </div>

            <div class="form-group col-xs-12">

              <label>Cliente(*):</label>
              <div class="input-group">
                  <select name="idcliente" class="form-control select2 idcliente" data-live-search="true" required>

                  </select>

                  <div class="input-group-btn" style="padding-left: 10px;">

                    <button type="button" class="btn btn-danger btnAgregarCliente" data-toggle="modal" data-target="#modalAgregarCliente">...</button>
                  </div>
                  <!-- /btn-group -->
                  
              </div>
            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary guardarFlotaVehiculo">Guardar</button>

        </div>

      </form>


    </div>

  </div>

</div>