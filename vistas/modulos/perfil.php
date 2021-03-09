  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Perfil
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Perfil</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="<?php echo $url.$_SESSION["foto"]; ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $_SESSION["nombre"].' '. $_SESSION["apellido"]; ?></h3>

              <p class="text-muted text-center"><?php echo $_SESSION["cargo"]; ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">13,287</a>
                </li>
              </ul>

              <a href="#" class="btn btn-primary btn-block"><b>Seguir</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-body">

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Ubicacion</strong>

              <p class="text-muted"><?php echo $_SESSION["ciudad"]; ?>, Peru</p>

              <hr>


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">Datos</a></li>
            </ul>
            <div class=" tab-content">

              <div class="active tab-pane" id="settings">
                <form class="form-horizontal">

                  <div class="form-group">
                    <label for="nombre" class="col-sm-2 control-label">Nombre:</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nombre" placeholder="Nombre" value=" <?php echo $_SESSION["nombre"] ?> ">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="apellido" class="col-sm-2 control-label">Apellido:</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="apellido" placeholder="Apellido" value=" <?php echo $_SESSION["apellido"] ?> ">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="documento" class="col-sm-2 control-label">Documento:</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="documento" placeholder="Num Documento" value=" <?php echo $_SESSION["num_documento"] ?> ">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email:</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email" value=" <?php echo $_SESSION["email"] ?> ">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="telefono" class="col-sm-2 control-label">Telefono:</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="telefono" placeholder="Telefono" value=" <?php echo $_SESSION["telefono"] ?> ">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Guardar</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->