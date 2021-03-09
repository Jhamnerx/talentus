<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Ventas
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="ventas"><i class="fa fa-laptop"></i> Ventas</a></li>

      <li class="active">Gestor Ventas</li>

    </ol>

  </section>

  <section class="content">


    <div class="box agregarVentas" style="display:none;">

      <form method="post" enctype="multipart/form-data" name="formularioVenta" id="formularioVenta" class="style_form formularioVenta">

        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label>Empresa</label>
          <select name="nEmpresa" class="form-control nEmpresa">
             <option value="Talentus">Talentus</option>
             <option value="Katary + IGV">Katary</option>
          </select>
        </div>

        <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">

          <label>Cliente(*):</label>

          <div class="input-group">

              <select name="idcliente" class="form-control select2 idclienteVenta" data-live-search="true" required>

              </select>

              <div class="input-group-btn">
              </div>
              <!-- /btn-group -->
              
          </div>

        </div>

        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label>Fecha(*):</label>
          <input type="date" class="form-control fecha" name="fecha_hora" id="fecha_hora" required="">
        </div>
        <div class="form-group col-lg-2 col-md-2 col-sm-2 col-xs-12">
          <label>Tipo Comprobante(*):</label>
          <select name="tipo_comprobante" class="form-control tipo_comprobante" required="">
             <option value="Boleta">Boleta</option>
             <option value="Factura + IGV">Factura + IGV</option>
             <option value="Factura IGV INC">Factura IGV INC</option>
             <option value="Ticket">Ticket</option>
             <option value="Recibo">Recibo</option>
          </select>
        </div>
        <div class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-12">
          <label>Divisa:</label>
          <select name="divisa" class="form-control divisa" required="">
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
        <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
          <label>Tipo Pago:</label>
          <input type="text" class="form-control tipoPago" name="tipoPago" required="">
        </div>

        <div class="form-group col-xs-12">
          <a data-toggle="modal" href="#modalAgregarArticuloVenta">           
            <button id="btnAgregarArt" type="button" class="btn btn-primary"> <span class="fa fa-plus"></span> Agregar Artículos</button>
          </a>
        </div>

        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
          <table id="detalles" class="table table-bordered table-striped dt-responsive table-hover tblListadoArcticulosVenta">
            <thead style="background-color:#A9D0F5">
                  <th>Opciones</th>
                  <th>Artículo</th>
                  <th>Cantidad</th>
                  <th>Precio Venta</th>
                  <th>Descuento</th>
                  <th>Subtotal</th>
              </thead>
              <tfoot>
                  <th>TOTAL</th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th><h4 id="total">S/. 0.00</h4><input type="hidden" name="total_venta" id="total_venta"></th> 
              </tfoot>
              <tbody>
                
              </tbody>
          </table>
        </div>

        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <button class="btn btn-primary guardarVenta" type="button"><i class="fa fa-save"></i> Guardar</button>

          <button class="btn btn-danger btnCancelar" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
        </div>
      </form>



    </div>




    <div class="box listaVentas">
      <?php 


      if ($_SESSION["ventas"] == "true") {
        
       ?>
      <div class="box-header with-border">
         
        <button class="btn btn-primary btnAgregarVenta">
          
          Añadir Ventas

        </button>

      </div>

      <div class="box-body">

        <table class="table table-bordered table-striped dt-responsive table-hover tablaVentas" width="100%">
        
          <thead>
         
            <tr>
             
               <th style="width:10px">#</th>
               <th style="width:120px">Opciones</th>
               <th>Empresa</th>
               <th>Cliente</th>
               <th>Usuario</th>
               <th>Documento</th>
               <th>Numero</th>
               <th>Total Venta</th>
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

<div id="modalAgregarArticuloVenta" class="modal fade" role="dialog">
  
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
          <table class="table table-bordered table-striped dt-responsive table-hover tablaAddArticulosVentas" width="100%">
      
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

<?php 
include "modals/clientes.php";
 ?>