<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Cliente
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="Cliente"><i class="fa fa-user"></i> Cliente</a></li>

      <li class="active">Gestor Cliente</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
      <?php 


      if ($_SESSION["ventas"] == "true") {
        
       ?>
      <div class="box-header with-border">
         
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
          
          Agregar Cliente

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaCliente" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Nombre</th>
               <th>Tipo Doc.</th>
               <th>Numero Doc.</th>
               <th>Direccion</th>
               <th>Telefonos</th>
               <th>Email's</th>
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
MODAL AGREGAR
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

          <button type="button" class="btn btn-primary guardarCliente">Guardar</button>

        </div>

      </form>


    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR
======================================-->

<div id="modalEditarCliente" class="modal fade modalEditarCliente" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Cliente</h4>

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

                <input type="hidden" class="editarIdCliente" name="editarIdCliente">

              </div>

            </div>

            <!--=====================================
            ENTRADA DEL NOMBRE
            ======================================-->

            <!-- JURIDICA -->
            <div class="form-group personaJuridica">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg validarClienteJ nombreClienteJ" placeholder="Ingresar Nombre Cliente" name="nombreCliente" required> 

              </div> 

            </div>


            <!-- NATURAL -->

            <div class="personaNatural" style="display:none;">

              <div class="form-group row">
                
                <div class="col-xs-6">

                  <div class="input-group">
                
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control input-lg nombreClienteN" placeholder="Ingresar Nombres" name="nombreCliente" required> 

                  </div> 


                </div>

                <div class="col-xs-6">

                  <div class="input-group">
                
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control input-lg apellidoCliente" placeholder="Ingresar Apellidos" name="apellidoCliente"> 

                  </div> 


                </div>

              </div>

            </div>
            
            <!-- INFORMACION DOCUMENTOS -->

            <div class="infoDocumentos">

              <div class="form-group row">
                
                <div class="col-xs-6">

                  <div class="input-group">
              
                    <span class="input-group-addon"><i class="fa fa-book"></i></span> 

                    <select class="form-control input-lg tipoDocumento" name="tipoDocumento" required>
                      

                      <option selected="" value="RUC">RUC</option>
                      <option value="DNI">DNI</option>
                      


                    </select>

                  </div>


                </div>

                <div class="col-xs-6">

                  <div class="input-group">
                
                    <span class="input-group-addon"><i class="fa fa-book"></i></span>

                    <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" class="form-control input-lg numDocumento" placeholder="Ingreso N° documento" name="numDocumento" required> 

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

            <div class="form-group editarTelefonoCliente">
              
              <!-- <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg " placeholder="TELEFONO (coma)" name="telefonoCliente"> 

              </div>  -->

            </div>

            <!--=====================================
            ENTRADA EMAIL
            ======================================-->

            <div class="form-group editarEmailCliente">
              
<!--               <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInput input-lg emailCliente" placeholder="EMAIL (coma)" name="emailCliente"> 

              </div>  -->

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary editarCliente">Guardar</button>

        </div>

      </form>


    </div>

  </div>

</div>

 <?php

        
    // $eliminarPersona = new ControladorPersona();
    // $eliminarPersona -> ctrEliminarCliente();

  ?>

