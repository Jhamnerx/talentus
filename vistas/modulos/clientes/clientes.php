<?php 

  $item = "num_documento";
  $valor = $_SESSION["num_documento"];
  $count = 0;
  $persona = ControladorPersona::ctrMostrarPersona($item, $valor, $count);

  var_dump($persona);


 ?>

      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 style="font-size: 30px">Deuda Actual</h3>

              <p style="font-size: 26px">S/ 65</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="#" class="small-box-footer">Ver comprobantes <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 style="font-size: 30px">Tickets Abierto</h3>

              <p style="font-size: 26px">1</p>
            </div>
            <div class="icon">
              <i class="fa fa-tags"></i>
            </div>
            <a href="#" class="small-box-footer">Ver tickets <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 style="font-size: 30px">Unidades Registradas</h3>

              <p style="font-size: 26px">14</p>
            </div>
            <div class="icon">
              <i class="fa fa-archive"></i>
            </div>
            <a href="#" class="small-box-footer">Ver mis unidades <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 style="font-size: 30px">Estado</h3>

              <p style="font-size: 26px">Activo</p>


            </div>
            <div class="icon">
              <i class="fa fa-comment"></i>
            </div>
            <a href="#" class="small-box-footer">Ver mi info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>