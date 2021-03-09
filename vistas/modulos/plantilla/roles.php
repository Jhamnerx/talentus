<?php

$roles = ControladorRoles::ctrMostrarRoles(null, null);


?>

<div class="box box-success">
	
	<div class="box-header with-border">
		
		<h3 class="box-title">ROLES SISTEMA</h3>

	    <div class="box-tools pull-right">

     		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">

	        	<i class="fa fa-minus"></i>

	       	</button>

	    </div>

	</div>


 	<div class="box-body">
	 	
		<div class="form-group">

			<?php 
			 // foreach ($redSocial as $key => $value){

			 // 	if ($value["estilo"]=="facebookNegro") {

			 // 		echo '

			 // 		<label class="checkbox-inline"><input type="radio" value="color" name="colorRedSocial" > Color</label>

		  //     		<label class="checkbox-inline"><input type="radio" value="blanco" name="colorRedSocial"> Blanco</label>

		  //     		<label class="checkbox-inline"><input type="radio" value="negro" name="colorRedSocial" checked> Negro</label>

			 // 		';
			 		
			 // 	}else if ($value["estilo"]=="facebookColor") {
			 // 		echo '

			 // 		<label class="checkbox-inline"><input type="radio" value="color" name="colorRedSocial" checked > Color</label>

		  //     		<label class="checkbox-inline"><input type="radio" value="blanco" name="colorRedSocial"> Blanco</label>

		  //     		<label class="checkbox-inline"><input type="radio" value="negro" name="colorRedSocial"> Negro</label>

			 // 		';
			 // 	}else if ($value["estilo"]=="facebookBlanco"){
			 // 		echo '

			 // 		<label class="checkbox-inline"><input type="radio" value="color" name="colorRedSocial"  > Color</label>

		  //     		<label class="checkbox-inline"><input type="radio" value="blanco" name="colorRedSocial" checked> Blanco</label>

		  //     		<label class="checkbox-inline"><input type="radio" value="negro" name="colorRedSocial"> Negro</label>

			 // 		';
			 // 	}


			 // }
			 ?>

			
		
		</div>

		<?php

		foreach ($roles as $key => $value){

      if ($value["rol"] != "cliente") {
        # code...


  			echo '<div class="form-group row">

  					<div class="col-xs-8">
  				
  						<div class="input-group">

  							<span class="input-group-addon"><i class="fa fa-user"></i></span>

  							<input type="text" class="form-control input-lg namerol" readonly value="'.strtoupper($value["rol"]).'">

  						</div>

  					</div>

  					<div class="col-xs-2">';

  				if ($value["id"] == 1) {
  					echo '<button disabled class="btn btn-primary editarRol" idRol="'.$value["id"].'" data-toggle="modal"data-target="#modalEditarRol">
  		          
  		          <i class="fa fa-pencil"></i>

  		        </button>';
  				}else{
  					echo '<button class="btn btn-primary editarRol" idRol="'.$value["id"].'" data-toggle="modal"data-target="#modalEditarRol">
  		          
  		          <i class="fa fa-pencil"></i>

  		        </button>';
  				}




  					echo '</div>

  				</div>';
      }
		}

		?>

		<input type="hidden" id="valorRedesSociales" value="">	

 	</div>

 	<div class="box-footer">
      
<!--     	<button type="button" id="crearRolNuevo" class="btn btn-primary pull-right">Nuevo</button> -->
    
	</div>

</div>

<!--=====================================
MODAL EDITAR ROL
======================================-->

<div id="modalEditarRol" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-md">
    
    <div class="modal-content">

      <form method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
        
        <div class="modal-header" style="background:#3c8dbc; color:white">
          
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
          <h4 class="modal-title">Editar rol/permisos</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">
          
          <div class="box-body">



            <div class="form-group">
              
              <div class="input-group">
                
                <span class="input-group-addon"><i class="fa fa-th"></i></span>

                <input type="hidden" class="idRolGuardar" name="idRol"> 
                <input type="text" class="form-control input-lg nombreRol" name="nombreRol" readonly=""> 

              </div> 

            </div>

            <!--=====================================
            PERMISOS
            ======================================-->

            <div class="form-group col-xs-12">

              <h3>Permisos</h3>
              <hr>
              <label>
                <input type="checkbox" class="flat-red permiso almacen" name="almacen">
                Almacen  
              </label>
              <br>
              <label>
                <input type="checkbox" class="flat-red permiso compras" name="compras">
                 Compras
              </label>
              <br>
              <label>
                <input type="checkbox" class="flat-red permiso ventas" name="ventas">
                 Ventas
              </label>
              <br>
              <label>
                <input type="checkbox" class="flat-red permiso vehiculos" name="vehiculo">
                 Vehiculos
              </label>
              <br>
              <label>
                <input type="checkbox" class="flat-red permiso administracion" name="admnistracion">
                 Administracion
              </label>
              <br>
              <label>
                <input type="checkbox" class="flat-red permiso tecnico" name="tecnico">
                 Servicio Tecnico
              </label>
            </div>

          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>

          <button type="button" class="btn btn-primary btnGuardRol">Guardar</button>

        </div>

      </form>

      <?php

        
          // $crearRol = new ControladorRols();
          // $crearRol -> ctrCrearRol();

      ?>

    </div>

  </div>

</div>