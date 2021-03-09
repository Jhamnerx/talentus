<?php 

$tareasTotal = ModeloTarea::mdlMostrarTareas("tareas",null, null);
$tareasSL = ModeloTarea::mdlMostrarTareas("tareas","leido", "0");
$tareasT = ModeloTarea::mdlMostrarTareas("tareas","estado", "2");
$tareasP = ModeloTarea::mdlMostrarTareas("tareas","estado", "1");
$tareasC = ModeloTarea::mdlMostrarTareas("tareas","estado", "0");
  


 ?>

<div class="col-md-3 col-sm-6 col-xs-12">
  <a class="tareasNoLeidasclick" style="text-decoration: none; color: black;" data-toggle="modal" data-target="#modalVerTareaNoLeida">
    <div class="info-box">
      <span class="info-box-icon bg-aqua"><i class="fa fa-bell-o"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">VER TAREAS</span>
        <span class="info-box-number"><?php if (count($tareasSL) >= 0 ) {echo count($tareasSL);}else{echo "0";} ?><small> Sin leer</small></span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </a>
  <!-- /.info-box -->
</div>


<div class="col-md-3 col-sm-6 col-xs-12">
  <a style="text-decoration: none; color: black;" data-toggle="modal" data-target="#modalVerTareaCompletadas">
    <div class="info-box">
      <span class="info-box-icon bg-green"><i class="fa fa-bell-o"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">TAREAS TERMINADAS</span>
        <span class="info-box-number"><?php if (count($tareasT) >= 0 ) {echo count($tareasT);}else{echo "0";} ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </a>
  <!-- /.info-box -->
</div>


<!-- fix for small devices only -->
<div class="clearfix visible-sm-block"></div>

<!-- /.col -->
<div class="col-md-3 col-sm-6 col-xs-12">
    <a style="text-decoration: none; color: black;" data-toggle="modal" data-target="#modalVerTareaProgreso">
    <div class="info-box">
      <span class="info-box-icon bg-yellow"><i class="fa fa-bell-o"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">TAREAS EN PROGRESO</span>
        <span class="info-box-number"><?php if (count($tareasP) >= 0 ) {echo count($tareasP);}else{echo "0";} ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </a>
  <!-- /.info-box -->
</div>

<div class="col-md-3 col-sm-6 col-xs-12">
  <a style="text-decoration: none; color: black;" data-toggle="modal" data-target="#modalVerTareaCancelada">

    <div class="info-box">
      <span class="info-box-icon bg-red"><i class="fa fa-bell-o"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">TAREAS CANCELADAS</span>
        <span class="info-box-number"><?php if (count($tareasC) >= 0 ) {echo count($tareasC);}else{echo "0";} ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </a>
  <!-- /.info-box -->
</div>






<!--=====================================
VER TAREAS NO LEIDAS
======================================-->

<div id="modalVerTareaNoLeida" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">
      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->
      
      <div class="modal-header" style="background:#3c8dbc; color:white">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        <h4 class="modal-title">Tareas no leidas</h4>

      </div>
      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->
      <div class="modal-body">
          
        <div class="box-body table-responsive">
          <table class="table no-margin table-bordered table-striped dt-responsive table-hover tablaVerTareaNoLeida">
      
            <thead>
           
              <tr>

               <th style="width:10px">#</th>
               <th>Tarea</th>
               <th>Asignada por</th>
               <th>Descripcion</th>
               <th>Acciones</th>

              </tr> 

            </thead>

            <tbody id="bodytable">
              
            </tbody>   
       
          </table>

        </div>

      </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <!--  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button> -->

        </div>

    </div>

  </div>

</div>

<!--=====================================
VER TAREAS TERMINADAS
======================================-->

<div id="modalVerTareaCompletadas" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">
      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->
      
      <div class="modal-header" style="background:#3c8dbc; color:white">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        <h4 class="modal-title">Tareas Completadas</h4>

      </div>
      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->
      <div class="modal-body">
          
        <div class="box-body table-responsive">
          <table class="table no-margin table-bordered table-striped dt-responsive table-hover tablaVerTareaCompletadas">
      
            <thead>
           
              <tr>

               <th style="width:10px">#</th>
               <th>Tarea</th>
               <th>Asignada por</th>
               <th>Descripcion</th>
               <th>Estado</th>
               <th>Acciones</th>

              </tr> 

            </thead>
  
       
          </table>

        </div>
      </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

      <div class="modal-footer">
      

      </div>

    </div>

  </div>

</div>


<!--=====================================
VER TAREAS EN PROGRESO
======================================-->

<div id="modalVerTareaProgreso" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">
      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->
      
      <div class="modal-header" style="background:#3c8dbc; color:white">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        <h4 class="modal-title">Tareas En Progreso</h4>

      </div>
      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->
      <div class="modal-body">
          
        <div class="box-body table-responsive">
          <table class="table no-margin table-bordered table-striped dt-responsive table-hover tablaVerTareaProgreso">
      
            <thead>
           
              <tr>

               <th style="width:10px">#</th>
               <th>Tarea</th>
               <th>Asignada por</th>
               <th>Descripcion</th>
               <th>Estado</th>
               <th>Acciones</th>

              </tr> 

            </thead>
  
       
          </table>

        </div>

      </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <!--<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button> -->

        </div>

    </div>

  </div>

</div>


<!--=====================================
VER TAREAS CANCELADAS
======================================-->

<div id="modalVerTareaCancelada" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">
    
    <div class="modal-content">
      <!--=====================================
      CABEZA DEL MODAL
      ======================================-->
      
      <div class="modal-header" style="background:#3c8dbc; color:white">
        
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        
        <h4 class="modal-title">Tareas Canceladas</h4>

      </div>
      <!--=====================================
      CUERPO DEL MODAL
      ======================================-->
      <div class="modal-body">
          
        <div class="box-body table-responsive">
          <table class="table no-margin table-bordered table-striped dt-responsive table-hover tablaVerTareaCancelada">
      
            <thead>
           
              <tr>

               <th style="width:10px">#</th>
               <th>Tarea</th>
               <th>Asignada por</th>
               <th>Descripcion</th>
               <th>Informacion</th>
               <th>Estado</th>

              </tr> 

            </thead>
  
       
          </table>

        </div>

      </div>
        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <!--<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button> -->

        </div>

    </div>

  </div>

</div>