<!--=====================================
MODAL ADMINISTRAR TECNICOS
======================================-->

<div id="modalTecnicos" class="modal fade modalTecnicos" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">


        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Administrar Tecnicos</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">
            
            <ul class="nav nav-pills">
              <li class="active"><a data-toggle="tab" href="#listaTecnicos">Lista Tenicos</a></li>
              <li><a data-toggle="tab" href="#CrearTecnico">Añadir Tecnico</a></li>

            </ul>

            <div class="tab-content">

              <div id="listaTecnicos" class="tab-pane fade in active">
                <h3>LISTA TECNICOS</h3>
                  <table class="table table-bordered table-striped dt-responsive tablaTecnicos" width="100%">
        
                    <thead>
                   
                      <tr>
                       
                         <th style="width:10px">#</th>
                         <th>Nombre</th>
                         <th>Telefono</th>
                         <th>Email</th>
                         <th>Acciones</th>
                      </tr> 

                    </thead>   
               
                  </table>


              </div>

              <div id="CrearTecnico" class="tab-pane fade">
                <h3>AÑADIR TECNICO</h3>

                <form method="post" enctype="multipart/form-data" class="style_form">

                </form>

              </div>

            </div>




          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        <!--<button type="button" class="btn btn-primary guardarProveedor">Guardar</button> -->

        </div>

      


    </div>

  </div>

</div>


<div id="whatsapp"></div>