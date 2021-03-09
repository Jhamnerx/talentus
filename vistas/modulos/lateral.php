<!-- main-sidebar -->
<aside class="main-sidebar">

	<!-- sidebar -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
    	<div class="user-panel">
	        <div class="pull-left image">
	          <img src="<?php echo $url.$_SESSION["foto"]; ?>" class="img-circle" alt="User Image">
	        </div>
	        <div class="pull-left info">
	          <p><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido"];?></p>
	          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
	        </div>
      	</div>
    	<?php

    	include "lateral/menu.php";

    	?>

    </section>
    <!-- /.sidebar -->

</aside>
<!-- main-sidebar -->