<!--=====================================
USUARIOS
======================================-->	

<!-- user-menu -->
<li class="dropdown user user-menu">

	<!-- dropdown-toggle -->
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	

		<img src="<?php echo $url.$_SESSION["foto"]; ?>" class="user-image" alt="User Image">


		
		<span class="hidden-xs"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"];?></span>
	
	</a>
	<!-- dropdown-toggle -->

	<!-- dropdown-menu -->
	<ul class="dropdown-menu">

		<li class="user-header">
		
			<img src="<?php echo $url.$_SESSION["foto"]; ?>" class="user-image" alt="User Image">

			<p>
			<?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"]; ?>
			<h4 style="color:white"><?php echo $_SESSION["cargo"] ?></h4>
			</p>
		
		</li>

		<li class="user-footer">

                <div class="pull-left">
                  <a href="perfil" class="btn btn-default btn-flat">Perfil</a>
                </div>
			
			<div class="pull-right">
			
				<a href="salir" class="btn btn-default btn-flat btnSalir">Salir</a>
			
			</div>
		</li>

	</ul>
	<!-- dropdown-menu -->

</li>
<!-- user-menu -->