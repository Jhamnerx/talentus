<?php 


$notificaciones = ControladorNotificaciones::ctrMostrarNotificaciones(null, null);


if ($_SESSION["cargo"] != "cliente") {
	# code...

 ?>

<!--=====================================
MENSAJES
======================================-->
<!-- <li class="dropdown messages-menu">

	<a href="#" class="dropdown-toggle" data-toggle="dropdown">

	  	<i class="fa fa-envelope-o"></i>
	  	<span class="label label-success">4</span>

	</a>

	<ul class="dropdown-menu">

		<li class="header">Tienes 4 Mensajes</li>

	  	<li>

		    <ul class="menu">

		      	<li>

			        <a href="#">
			          <div class="pull-left">
			            <img src="/talentus/vistas/img/usuarios/user2-160x160.jpg" class="img-circle" alt="User Image">
			          </div>
			          <h4>
			            Support Team
			            <small><i class="fa fa-clock-o"></i> 5 mins</small>
			          </h4>
			          <p>Why not buy a new awesome theme?</p>
			        </a>
		     	</li>

		     	<li>
			        <a href="#">
			          <div class="pull-left">
			            <img src="/talentus/vistas/img/usuarios/user3-128x128.jpg" class="img-circle" alt="User Image">
			          </div>
			          <h4>
			            AdminLTE Design Team
			            <small><i class="fa fa-clock-o"></i> 2 hours</small>
			          </h4>
			          <p>Why not buy a new awesome theme?</p>
			        </a>
		        </li>


		        <li>
			        <a href="#">
			          <div class="pull-left">
			            <img src="/talentus/vistas/img/usuarios/user4-128x128.jpg" class="img-circle" alt="User Image">
			          </div>
			          <h4>
			            Developers
			            <small><i class="fa fa-clock-o"></i> Today</small>
			          </h4>
			          <p>Why not buy a new awesome theme?</p>
			        </a>
		        </li>

		      	<li>
			        <a href="#">
			          <div class="pull-left">
			            <img src="/talentus/vistas/img/usuarios/user3-128x128.jpg" class="img-circle" alt="User Image">
			          </div>
			          <h4>
			            Sales Department
			            <small><i class="fa fa-clock-o"></i> Yesterday</small>
			          </h4>
			          <p>Why not buy a new awesome theme?</p>
			        </a>
		     	</li>

		     	<li>
			        <a href="#">
			          <div class="pull-left">
			            <img src="/talentus/vistas/img/usuarios/user4-128x128.jpg" class="img-circle" alt="User Image">
			          </div>
			          <h4>
			            Reviewers
			            <small><i class="fa fa-clock-o"></i> 2 days</small>
			          </h4>
			          <p>Why not buy a new awesome theme?</p>
			        </a>
		        </li>

		    </ul>

	 	</li>

	  	<li class="footer"><a href="#">See All Messages</a></li>

	</ul>

</li> -->


<!--=====================================
NOTIFICACIONES
======================================-->

<!-- notifications-menu -->
<li class="dropdown notifications-menu">
	
	<!-- dropdown-toggle -->
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		
		<i class="fa fa-bell-o"></i>
		
		<span class="label label-warning"><?php echo count($notificaciones); ?></span>
	
	</a>
	<!-- dropdown-toggle -->

	<!--dropdown-menu -->
	<ul class="dropdown-menu">

		<!-- NOTIIFCACIONES -->

		<li class="header">Tu tienes <?php echo count($notificaciones); ?> notificaciones</li>

		<li>
			<!-- menu -->
			<ul class="menu">
				<?php


					

					//$totalNotificaciones = $notificaciones["nuevosUsuarios"] + $notificaciones["nuevasVentas"] + $notificaciones["nuevasVisitas"];

					//var_dump($notificaciones);

					foreach ($notificaciones as $key => $value) {

						$cobros = ModeloCobros::mdlMostrarCobros("cobros", "id", $value["idCobro"]);
						$fechaInicial = $cobros["fechaVen"];
				        $fechaFinal = date("Y/m/d");

				        $dias = Utiles::diferenciaFechas($fechaInicial, $fechaFinal);
				        //var_dump($dias);

				        // if ($dias < 0) {
				        // 	$diasP =abs($dias);
				        // 	echo "pasaron ".$diasP;
				        // }
						if ($dias == 0) {
				          

				          $notifi = ModeloNotificaciones::mdlActualizarNotificacion("notificaciones", "descripcion", "vencido", "id", $value["id"]);

				        }



				        /**
				         * MOSTRAR NOTIFICACIONES EN CAMPANA
				         */

				        if ($value["descripcion"] == "vencido") {


					        echo '<li class="notificacion" notificacion="'.$value["id"].'">
									<a href="cobros" style="color: red;" class="actualizarNotificaciones" item="nuevosUsuarios">
									
										<i class="fa fa-car text-aqua"></i> Plan Vencido '.$cobros["empresa"].'
									
									</a>

								</li>';
				        }else{


					        echo '<li class="notificacion" notificacion="'.$value["id"].'">
									<a href="cobros" class="actualizarNotificaciones" item="nuevosUsuarios">
									
										<i class="fa fa-car text-aqua"></i> Plan por vencer '.$cobros["empresa"].' ('.$dias.' dias restantes)
									
									</a>

								</li>';
				        }


					}

				?>


				<!-- ventas -->
<!-- 				<li>
				
					<a href="ventas" class="actualizarNotificaciones" item="nuevasVentas">
					
						<i class="fa fa-shopping-cart text-aqua"></i> 1 nuevas ventas
					
					</a>

				</li> -->
				
				<!-- visitas -->
<!-- 				<li>
				
					<a href="visitas" class="actualizarNotificaciones" item="nuevasVisitas">
					
						<i class="fa fa-map-marker text-aqua"></i> 2 nuevas visitas
					
					</a>

				</li> -->

			</ul>
			<!-- menu -->

		</li>

	</ul>
	<!--dropdown-menu -->

</li>
<!-- notifications-menu -->	


<!--=====================================
TAREAS MENU
======================================-->
<?php 

$tareas = ControladorTareas::ctrMostrarTareas("leido", "0");

 ?>

<li class="dropdown tasks-menu">

	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	 	<i class="fa fa-flag-o"></i>
	    <span class="label label-danger"><?php echo count($tareas) ?></span>
	</a>

	<ul class="dropdown-menu">
		<?php 
		if (count($tareas) >2) {
			echo '<li class="header">Tienes 1 Tarea</li>';
		}else{

			echo '<li class="header">Tienes '.count($tareas).' Tareas</li>';
		}

		 ?>
	 	

	  	<li>

		    <ul class="menu">

		    	<?php 

		    	

		    	foreach ($tareas as $key => $value) {
		    		$vehiculo = ControladorVehiculos::ctrMostrarVehiculos("id", $value['vehiculo']);
		    		$fecha = iconv('ISO-8859-2', 'UTF-8', strftime("%d de %B de %Y", strtotime($value["fecha"])));

			        if (strtolower($value['tipo']) =="instalacion") {

			          $tipo = "<p>Instalacion de GPSS TK-318 en el vehiculo ".$vehiculo["placa"].",</p> <p>Fecha y Hora de instalacion ".$fecha." ".$value['hora']."</p>";


			        }
			        if (strtolower($value['tipo']) =="mantenimiento") {


			          $tipo = "<p>Mantenimiento del dispositivo GPS del vehiculo ".$vehiculo["placa"].",</p> <p>Fecha y Hora del Mantenimiento ".$fecha." ".$value['hora']."</p>";


			        }       
			         if (strtolower($value['tipo']) ==strtolower("cambio SIM")) {


			          $tipo = "<p>Mantenimiento del dispositivo GPS del vehiculo ".$vehiculo["placa"].",</p> <p>Fecha y Hora del Mantenimiento ".$fecha." ".$value['hora']."</p>";


        			}

        			echo '

				    <li>
				        <a href="#">
				          <p>'.$tipo.'</p>
				        </a>
			        </li>';


		    	}


		    	 ?>

		      <!-- end task item -->
		    </ul>


	    </li>

	  	<li class="footer">
	   		<a href="tareas">Ver todas las tareas</a>
	 	</li>

	</ul>
</li>


<?php 

}
 ?>