<?php 
  $usuarios = ControladorUsuarios::ctrMostrarUsuarios(null, null);
 ?>
<div class="content-wrapper">

  <section class="content-header">

   <h1>
      Gestor Usuarios
    </h1>

    <ol class="breadcrumb">

      <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      <li><a href="usuarios"><i class="fa fa-laptop"></i> Usuarios</a></li>

      <li class="active">Gestor Usuarios</li>

    </ol>

  </section>

  <section class="content">

    <div class="box">
      <?php 


      if ($_SESSION["administracion"] == "true") {
        
       ?>
      <div class="box-body">

        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#usuarios" data-toggle="tab">Usuarios</a></li>
            <li><a href="#agregar" data-toggle="tab">Agregar usuario</a></li>
          </ul>
          <div class="tab-content">
            <div class="active tab-pane" id="usuarios">
              
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Lista de Usuarios</h3>


                  <div class="box-tools pull-right">
                    <span class="label label-danger"><?php echo count($usuarios); ?> Usuarios</span>
    
                  </div>
                </div>

                <div class="box-body no-padding">

                  <table class="table table-bordered table-striped dt-responsive tablaUsuarios" width="100%">
        
                    <thead>
                   
                      <tr>
                       
                         <th style="width:10px">#</th>
                         <th>Nombre</th>
                         <th>Num Documento</th>
                         <th>Direccion</th>
                         <th>Telefono</th>
                         <th>Email</th>
                         <th>Usuario</th>
                         <th>Contraseña</th>
                         <th>Ciudad</th>
                         <th>Foto</th>
                         <th>Estado</th>
                         <th>Acciones</th>
                      </tr> 

                    </thead>   
               
                  </table>
                
                  <!-- /.users-list -->
                </div>

              </div>

            </div>
            <div class="tab-pane" id="agregar">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title">Agregar Usuario</h3>
                </div>

                <div class="box-body no-padding">

                  <form method="post" enctype="multipart/form-data" name="formularioUsuario" id="formularioUsuario" class="style_form formularioUsuario">
                    <!-- nombre -->
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                      <label>Nombre:</label>
                      <input type="text" class="form-control nombreUsuario" name="nombreUsuario" required="" placeholder="Nombres">
                    </div>
                    <!-- apellido -->
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                      <label>Apellido:</label>
                      <input type="text" class="form-control apellidoUsuario" name="apellidoUsuario" required="" placeholder="Apellidos">
                    </div>
                    <!-- tipo documento -->
                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                       <label style="overflow:hidden;white-space:nowrap; text-overflow: ellipsis;">Tipo Documento:</label>
                      <select class="form-control input-md tipoDocumento" name="tipoDocumento" required>
                          <option value="RUC">RUC</option>
                          <option selected="" value="DNI">DNI</option>
                        </select>
                    </div>
                    <!-- numero documento -->
                    <div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12">
                      <label style="overflow:hidden;white-space:nowrap; text-overflow: ellipsis;">Numero Documento:</label>
                      <input type="text" class="form-control numDocumento" maxlength="12" name="numDocumento" required="" placeholder="N° Documento">
                    </div>
                    <!-- Direccion -->
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                      <label>Direccion:</label>
                      <input type="text" class="form-control direccion" name="direccion" placeholder="Direccion">
                    </div>
                    <!-- cargo -->
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                      <label>Cargo:</label>
                        <select name="cargo" class="form-control cargo">
                          <?php 

                          $rol = ControladorRoles::ctrMostrarRoles(null, null);

                         // var_dump($ciudad);

                          foreach ($rol as $key => $value) {

                            echo "<option value='".$value['id']."'>".strtoupper($value['rol'])."</option>";
                          }
                           ?>

                        </select>
                    </div>
                    <!-- ciudad -->
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                         <label>Ciudad:</label>
                        <select class="form-control ciudad" name="ciudad">
                            <?php 

                            $ciudad = ControladorPlantilla::ctrSeleccionarCiudad();

                            // var_dump($ciudad);

                            foreach ($ciudad as $key => $value) {

                                echo "<option value='".$value['id']."'>".$value['nombre']."</option>";
                            }
                            ?>
                          </select>
                    </div>
                    <!-- Telefono -->
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                      <label>Telefono:</label>
                      <input data-role="tagsinput" type="text" class="form-control tagsInputTelefono telefono" placeholder="Telefonos" name="telefono">
                    </div>
                    <!-- email -->
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                      <label>Email:</label>
                      <input type="email" class="form-control email" placeholder="Correo Electronico" name="email">
                    </div>
                    <!-- login -->
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12">
                      <label>Login:</label>
                      <input type="text" class="form-control login" placeholder="Login" name="login" required="">
                    </div>
                    <!-- password -->
                    <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                      <label>Contraseña:</label>
                      <input type="password" autocomplete="pcurrent-password" class="form-control passUsuario" placeholder="password" name="passUsuario" required>
                    </div>
                    <br>
                    <hr>
                      <!-- FOTO PERFIL-->
                      <div class="form-group upload-perfil">
                        
                        

                        <div class="col-md-6 col-xs-12">
                          <label>Change profile image</label>
                          <div class="actions">
                              <a class="btn-file file-btn">
                                  <span>Seleccionar Imagen</span>
                                  <input type="file" id="uploadPerfil"  id="subirPerfil" value="Choose a file" accept="image/*" />
                              </a>
                          </div>
                          <p class="help-block">Tamaño recomendado 300px * 300px</p>  
                          
                        </div>

                        <div class="col-md-6 col-xs-12">
                          <div class="upload-msg-perfil">
                              Selecciona tu imagen
                            </div>

                          <div class="upload-perfil-wrap">

                            <div id="upload-perfil"></div>

                          </div>

                        </div>
                                            
                      </div>  

                    <div class="form-group">
                      <div class="col-xs-12">
                        <button style="padding-right: 50px;text-align: center;vertical-align: center;width: 150px;height: 40px;font-size: 25px;" type="button" class="btn btn-danger btnGuardarUsuario">GUARDAR</button>
                      </div>
                    </div>
                    <br>

                  </form>

                
                  
                </div>

              </div>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
<!-- 
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
     
        </table> -->
          
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
MODAL EDITAR USUARIO
======================================-->

<div id="modalEditarUsuario" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar Usuario</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL NOMBRE
            ======================================-->

            <div class="form-group col-lg-6 col-xs-6">

              <label>Nombre (*):</label>     

                <input type="text" class="form-control input-lg validarUsuario nombreUsuario" placeholder="Ingresar Usuario" name="editarNombreUsuario" required> 

                <input type="hidden" class="editarIdUsuario editarIdUsuario" name="editarIdUsuario">


            </div>
            <!--=====================================
            ENTRADA DEL APELLIDO
            ======================================-->

            <div class="form-group col-lg-6 col-xs-6">

              <label>Apellido (*):</label>     
                
                <input type="text" class="form-control input-lg apellidoUsuario" placeholder="Ingresar Apellido" name="editarApellidoUsuario" required> 


            </div>
            <!--=====================================
            ENTRADA DEL TIPO DOC
            ======================================-->
            <div class="form-group col-sm-6 col-xs-12">

               <label>Tipo Documento:</label>

              <select class="form-control input-lg tipoDocumento editarTipoDocumento" name="editarTipoDocumento" required>

                  <option value="RUC">RUC</option>

                  <option selected="" value="DNI">DNI</option>

                </select>
            </div>
            <!--=====================================
            ENTRADA DEL NUM DOC
            ======================================-->

            <div class="form-group col-lg-6 col-xs-6">

              <label>Num Doc (*):</label>     
                
                <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" class="form-control input-lg numDocumento editarNumDocumento" placeholder="Ingresar Num Documento" name="editarNumDocumento" required> 


            </div>
            <!--=====================================
            ENTRADA DE LA DIRECCION
            ======================================-->

            <div class="form-group col-lg-12 col-xs-12">

              <label>Direccion:</label>     
                
                <input type="text" class="form-control input-md editarDireccion" placeholder="Ingresar Direccion" name="editarDireccion"> 


            </div>
            <!--=====================================
            ENTRADA DEL CARGO
            ======================================-->

            <div class="form-group col-lg-6 col-xs-6">

              <label>Cargo (*):</label>     
              <select name="editarCargo" class="form-control input-lg editarCargo">
                <?php 

                $rol = ControladorRoles::ctrMostrarRoles(null, null);

               // var_dump($ciudad);

                foreach ($rol as $key => $value) {

                  echo "<option value='".$value['id']."'>".strtoupper($value['rol'])."</option>";
                }
                 ?>

              </select>

            </div>
            <!--=====================================
            ENTRADA DE LA CIUDAD
            ======================================-->

            <div class="form-group col-lg-6 col-xs-6">

              <label>ciudad (*):</label>     

              <select name="editarCiudad" class="form-control input-lg editarCiudad">
                <?php 

                $ciudad = ControladorPlantilla::ctrSeleccionarCiudad();

               // var_dump($ciudad);

                foreach ($ciudad as $key => $value) {

                  echo "<option value='".$value['id']."'>".$value['nombre']."</option>";
                }
                 ?>

              </select>
            </div>
            <!--=====================================
            ENTRADA DEL TELEFONO
            ======================================-->

            <div class="form-group col-lg-6 col-xs-6 editarTelefonoUsuario">

             <!--  <label>Telefonos (*):</label>     
                
                <input type="text" class="form-control input-lg tagsInputTelefono editarTelefono" placeholder="Ingresar Telefono" name="editarTelefono" >  -->


            </div>
            <!--=====================================
            ENTRADA DEL EMAIL
            ======================================-->

            <div class="form-group col-lg-6 col-xs-6">

              <label>Email (*):</label>     
                
                <input type="text" class="form-control input-lg editarEmail" placeholder="Ingresar Email" name="editarEmail" > 


            </div>
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </div>

      </form>

      <?php 
      $editarUsuario = new ControladorUsuarios();
      $editarUsuario -> ctrEditarUsuario();
       ?>



    </div>

  </div>

</div>







<!--=====================================
MODAL CAMBIAR CONTRASEÑA USUARIO
======================================-->

<div id="modalCambiarPassword" class="modal fade" role="dialog">
  
  <div class="modal-dialog">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Cambiar Contraseña</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">

            <!--=====================================
            ENTRADA DEL NOMBRE
            ======================================-->

            <div class="form-group col-xs-12">

              <label>Nombre (*):</label>     

                <input type="text" class="form-control input-md PasswordNombreUsuario" name="PasswordNombreUsuario" readonly=""> 
                <input type="hidden" class="PasswordIdUsuario" name="PasswordIdUsuario">


            </div>

            <div class="form-group col-xs-6">

              <label>Contraseña (*):</label>     

                <input type="password" class="form-control input-md PasswordUsuario" name="PasswordUsuario">


            </div>

            <div class="form-group col-xs-6">

              <label>Confirmar Contraseña (*):</label>     

                <input type="password" class="form-control input-md PasswordUsuario" name="PasswordUsuario2">


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
        $editarUsuario = new ControladorUsuarios();
        $editarUsuario -> ctrCambiarPassword();
       ?>



    </div>

  </div>

</div>