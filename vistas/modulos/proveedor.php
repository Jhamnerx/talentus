<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Proveedor
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="proveedor"><i class="fa fa-user"></i> Proveedor</a></li>

      <li class="active">Gestor Proveedor</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
      <?php 


      if ($_SESSION["compras"] == "true") {
        
       ?>
      <div class="box-header with-border">
         
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProveedor">
          
          Agregar Proveedor

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive tablaProveedor" width="100%">
        
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
MODAL AGREGAR PROVEEDOR
======================================-->

<div id="modalAgregarProveedor" class="modal fade modalAgregarProveedor" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data" class="style_form">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Agregar Proveedor</h4>

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

                <input type="text" class="form-control input-lg validarProveedorJ nombreProveedorJ" placeholder="Ingresar Nombre" name="nombreProveedor" required> 

              </div> 

            </div>


            <!-- NATURAL -->

            <div class="personaNatural" style="display:none;">

              <div class="form-group row">
                
                <div class="col-xs-12 col-md-6">

                  <div class="input-group">
                
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control input-lg validarProveedorN nombreProveedorN" placeholder="Ingresar Nombres" name="nombreProveedor" required> 

                  </div> 


                </div>

                <div class="col-xs-12 col-md-6 paddingFix">

                  <div class="input-group">
                
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control input-lg validarProveedor apellidoProveedor" placeholder="Ingresar Apellidos" name="apellidoProveedor"> 

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

                    <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"  class="form-control input-lg numDocumento" placeholder="Ingreso N° documento" name="numDocumento" required> 

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

                <input type="text" class="form-control input-lg direccionProveedor" placeholder="Direccion" name="direccionProveedor"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA TELEFONO
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg telefonoProveedor" placeholder="TELEFONO (coma)" name="telefonoProveedor"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA EMAIL
            ======================================-->

            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInput input-lg emailProveedor" placeholder="EMAIL (coma)" name="emailProveedor"> 

              </div> 

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary guardarProveedor">Guardar</button>

        </div>

      </form>


    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR
======================================-->

<div id="modalEditarProveedor" class="modal fade modalEditarProveedor" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Proveedor</h4>

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

                <input type="hidden" class="editarIdProveedor" name="editarIdProveedor">

              </div>

            </div>

            <!--=====================================
            ENTRADA DEL NOMBRE
            ======================================-->

            <!-- JURIDICA -->
            <div class="form-group personaJuridica">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-user"></i></span>

                <input type="text" class="form-control input-lg validarProveedorJ nombreProveedorJ" placeholder="Ingresar Nombre Proveedor" name="nombreProveedor" required> 

              </div> 

            </div>


            <!-- NATURAL -->

            <div class="personaNatural" style="display:none;">

              <div class="form-group row">
                
                <div class="col-xs-6">

                  <div class="input-group">
                
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control input-lg nombreProveedorN" placeholder="Ingresar Nombres" name="nombreProveedor" required> 

                  </div> 


                </div>

                <div class="col-xs-6">

                  <div class="input-group">
                
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>

                    <input type="text" class="form-control input-lg apellidoProveedor" placeholder="Ingresar Apellidos" name="apellidoProveedor"> 

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

                    <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');"  class="form-control input-lg numDocumento" placeholder="Ingreso N° documento" name="numDocumento" required> 

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

                <input type="text" class="form-control input-lg direccionProveedor" placeholder="Direccion" name="direccionProveedor"> 

              </div> 

            </div>

            <!--=====================================
            ENTRADA TELEFONO
            ======================================-->

            <div class="form-group editarTelefonoProveedor">
              
              <!-- <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-phone"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg " placeholder="TELEFONO (coma)" name="telefonoProveedor"> 

              </div>  -->

            </div>

            <!--=====================================
            ENTRADA EMAIL
            ======================================-->

            <div class="form-group editarEmailProveedor">
              
<!--               <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>

                <input data-role="tagsinput" type="text" class="form-control tagsInput input-lg emailProveedor" placeholder="EMAIL (coma)" name="emailProveedor"> 

              </div>  -->

            </div>


          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary editarProveedor">Guardar</button>

        </div>

      </form>


    </div>

  </div>

</div>

 <?php

        
    // $eliminarPersona = new ControladorPersona();
    // $eliminarPersona -> ctrEliminarProveedor();

  ?>

