<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarCliente" class="modal fade modalAgregarCliente" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data" class="style_form">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">
            
         <!--    SELECCIONAR TIPO PERSONA -->
            <div class="form-group">

              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-th"></i></span> 

                <select class="form-control input-lg seleccionarTipoPersona" name="seleccionarTipo" required>
                  

                  <option selected="" value="juridica">Persona Jurídica</option>
                  <option value="natural">Persona Natural</option>
                  


                </select>

              </div>

            </div>

            <!--=====================================
            ENTRADA DEL NOMBRE
            ======================================-->

            <!-- JURIDICA -->
            <div class="form-group personaJuridica">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg validarClienteJ nombreClienteJ" placeholder="Ingresar Nombre" name="nombreCliente" required> 

              </div> 

            </div>


            <!-- NATURAL -->

            <div class="personaNatural" style="display:none;">

              <div class="form-group row">
                
                <div class="col-xs-12 col-md-6">

                  <div class="input-group">
                
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control input-lg validarClienteN nombreClienteN" placeholder="Ingresar Nombres" name="nombreCliente" required> 

                  </div> 


                </div>

                <div class="col-xs-12 col-md-6 paddingFix">

                  <div class="input-group">
                
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control input-lg validarCliente apellidoCliente" placeholder="Ingresar Apellidos" name="apellidoCliente"> 

                  </div> 


                </div>

              </div>

            </div>
            
            <!-- INFORMACION DOCUMENTOS -->

            <div class="infoDocumentos">

              <div class="form-group row">
                
                <div class="col-xs-12 col-md-6">

                  <div class="input-group">
              
                    <span class="input-group-addon"><i class="fa fa-book"></i></span> 

                    <select class="form-control input-lg tipoDocumento" name="tipoDocumento" required>
                      

                      <option selected="" value="RUC">RUC</option>
                      <option value="DNI">DNI</option>
                      


                    </select>

                  </div>


                </div>

                <div class="col-xs-12 col-md-6 paddingFix">

                  <div class="input-group">
                
                    <span class="input-group-addon"><i class="fa fa-book"></i></span>

                    <input type="text" class="form-control input-lg numDocumento" placeholder="Ingreso N° documento" name="numDocumento" required> 

                  </div> 


                </div>

              </div>

            </div>

            <!--=====================================
            ENTRADA DIRECCIOON
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-home"></i></span>

                <input type="text" class="form-control input-lg direccionCliente" placeholder="Direccion" name="direccionCliente"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA TELEFONO
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg telefonoCliente" placeholder="TELEFONO (coma)" name="telefonoCliente"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA EMAIL
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInput input-lg emailCliente" placeholder="EMAIL (coma)" name="emailCliente"> 

              </div> 

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary guardarClienteVenta">Guardar</button>

        </div>

      </form>


    </div>

  </div>

</div>
