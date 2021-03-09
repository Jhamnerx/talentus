<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Ingresos
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="ingresos"><i class="fa fa-laptop"></i> Compras</a></li>

      <li class="active">Gestor Ingresos</li>

    </ol>

  </section>

  <section class="content">


    <div class="box agregarIngresos" style="display:none;">
        
      <form method="post" enctype="multipart/form-data" name="formularioIngreso" id="formularioIngreso" class="style_form formularioIngreso">


        <div class="form-group col-lg-5 col-md-5 col-sm-5 col-xs-12">

          <label>Proveedor(*):</label>

          <div class="input-group">

              <select name="idproveedor" class="form-control select2 idproveedor" data-live-search="true" required>

              </select>

              <div class="input-group-btn">

                <button type="button" class="btn btn-danger btnAgregarProveedor" data-toggle="modal" data-target="#modalAgregarProveedorIn">...</button>
              </div>
              <!-- /btn-group -->
              
          </div>

        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">
          <label>Fecha(*):</label>
          <input type="date" class="form-control fecha" name="fecha_hora" id="fecha_hora" required="">
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label>Tipo Comprobante(*):</label>
          <select name="tipo_comprobante" class="form-control selectpicker tipo_comprobante" required="">
             <option value="Boleta">Boleta</option>
             <option value="Factura + IGV">Factura + IGV</option>
             <option value="Factura IGV INC">Factura IGV INC</option>
             <option value="Ticket">Ticket</option>
          </select>
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label>Divisa:</label>
          <select name="divisa" class="form-control selectpicker divisa" required="">
             <option value="PEN">PEN</option>
             <option value="USD">USD</option>
             <option value="EUR">EUR</option>
             <option value="MXN">MXN</option>
          </select>
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
          <label>Serie:</label>
          <input type="text" class="form-control serie_comprobante" name="serie_comprobante" maxlength="8" required="" placeholder="Serie">
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
          <label>Número:</label>
          <input type="text" class="form-control num_comprobante" name="num_comprobante" maxlength="10" placeholder="Número" required="">
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
          <label>Impuesto:</label>
          <input type="text" class="form-control impuesto" name="impuesto" required="">
        </div>
        <div class="form-group col-xs-12">
          <a data-toggle="modal" href="#modalAgregarArticulo">           
            <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Artículos</button>
          </a>
        </div>

        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
          <table id="detalles" class="table table-bordered table-striped dt-responsive table-hover tblListadoArcticulosIngresos">
            <thead style="background-color:#A9D0F5">
                  <th>Opciones</th>
                  <th>Artículo</th>
                  <th>Cantidad</th>
                  <th>Precio Compra</th>
                  <th>Precio Venta</th>
                  <th>Subtotal</th>
              </thead>
              <tfoot>
                  <th>TOTAL</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th><h4 id="total">S/. 0.00</h4>
                    <input class="total_compra" type="hidden" name="total_compra" id="total_compra">
                  </th> 
              </tfoot>
              <tbody>
                
              </tbody>
          </table>
        </div>

        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <button class="btn btn-primary guardarIngreso"  type="button"><i class="fa fa-save"></i> Guardar</button>

          <button class="btn btn-danger btnCancelarIngreso" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
        </div>
      </form>



    </div>




    <div class="box listaIngresos">
      <?php 


      if ($_SESSION["compras"] == "true") {
        
       ?>
      <div class="box-header with-border">
         
        <button class="btn btn-primary btnAgregarIngreso">
          
          Añadir Ingresos

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive table-hover tablaIngresos" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th>Opciones</th>
               <th>Proveedor</th>
               <th>Usuario</th>
               <th>Documento</th>
               <th>Numero</th>
               <th>Total Compra</th>
               <th>Fecha</th>
               <th>Estado</th>
               

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
MODAL AÑADIR ARTICULO
======================================-->

<div id="modalAgregarArticulo" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">
      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->
      
      <div class="modal-header" style="background:#3c8dbc; color:white">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        <h4 class="modal-title">Agregar Productos</h4>

      </div>
      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->
      <div class="modal-body">
          
        <div class="box-body">
          <table class="table table-bordered table-striped dt-responsive table-hover tablaAddIngresos" width="100%">
      
            <thead>
           
              <tr>
                 
                 <th>Servicio</th>
                 <th>Categoria</th>
                 <th>Precio</th>
                 <th>Stock</th>
                 <th>Imagen</th>
                 <th>Acciones</th>

              </tr> 

            </thead>   
       
          </table>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

        </div>
      </div>
      

    </div>

  </div>

</div>
<!--=====================================
MODAL AGREGAR PROVEEDOR
======================================-->

<div id="modalAgregarProveedorIn" class="modal fade modalAgregarProveedorIn" role="dialog">
  
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

          <button type="button" class="btn btn-primary guardarProveedorIn">Guardar</button>

        </div>

      </form>


    </div>

  </div>

</div>
