<?php

$plantilla = ControladorPlantilla::ctrSeleccionarPlantilla();
$empresa = json_decode($plantilla["empresa"], true);

?>

<div class="box box-info">
	
	<div class="box-header with-border">
		
		 <h3 class="box-title">DATOS EMPRESAA</h3>

		 <div class="box-tools pull-right">

      		<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">

        		<i class="fa fa-minus"></i>

        	</button>

        </div>

	</div>

	<div class="box-body formularioEmpresa">

		<!-- NAME -->

		<div class="form-group">
	      
	      <label for="usr">Nombre Empresa:</label>
	      
	      <div class="input-group">
	        
	        <span class="input-group-addon"><i class="fa fa-line-chart"></i></span>
	        <input type="text" class="form-control cambioEmpresa" id="nombre" value="<?php echo $empresa[0]["nombre"]; ?>">

	      </div>
	    
	    </div>
		<!-- RUCH -->

		<div class="form-group">
	      
	      <label for="usr">RUC Empresa:</label>
	      
	      <div class="input-group">
	        
	        <span class="input-group-addon"><i class="fa fa-archive"></i></span>
	        <input type="text" class="form-control cambioEmpresa" id="ruc" value="<?php echo $empresa[0]["ruc"]; ?>">

	      </div>
	    
	    </div>
		<!-- TELEFONO -->

		<div class="form-group">
	      
	      <label for="usr">Telefono:</label>
	      
	      <div class="input-group">
	        
	        <span class="input-group-addon"><i class="fa fa-phone"></i></span>
	        <input type="text" class="form-control cambioEmpresa" id="telefono" value="<?php echo $empresa[0]["telefono"]; ?>">

	      </div>
	    
	    </div>

	    <!-- DIRECCION -->

	    <div class="form-group">
      
	      <label for="usr">Direccion:</label>
	      
	      <div class="input-group">
	        
	        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
	        <input type="text" class="form-control cambioEmpresa" id="direccion" value="<?php echo $empresa[0]["direccion"]; ?>">

	      </div>
	    
	    </div>

	    <!-- PROVINCIA -->

     	<div class="form-group">
      
	      <label for="usr">Provincia:</label>
	      
	      <div class="input-group">
	        
	        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
	        <input type="text" class="form-control cambioEmpresa" id="provincia" value="<?php echo $empresa[0]["provincia"]; ?>">

	      </div>
	    
	    </div>

	    <!-- SELECCIONAR PAÍS -->

     	<div class="form-group">
      
	      <label for="usr">Pais:</label>
	      
	      <div class="input-group">
	        
	        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
	        <input type="text" class="form-control cambioEmpresa" id="pais" value="<?php echo $empresa[0]["pais"]; ?>">

	      </div>
	    
	    </div>

	    <!-- CORREO -->

     	<div class="form-group">
      
	      <label for="usr">Correo Electronico:</label>
	      
	      <div class="input-group">
	        
	        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
	        <input type="text" class="form-control cambioEmpresa" id="correo" value="<?php echo $empresa[0]["correo"]; ?>">

	      </div>
	    
	    </div>
	    <!-- lema -->

     	<div class="form-group">
      
	      <label for="usr">Lema:</label>
	      
	      <div class="input-group">
	        
	        <span class="input-group-addon"><i class="fa fa-align-justify"></i></span>
	        <input type="text" class="form-control cambioEmpresa" id="lema" value="<?php echo $empresa[0]["lema"]; ?>">

	      </div>
	    
	    </div>
	    <!-- cuenta -->

     	<div class="form-group">
      
	      <label for="usr">Cuenta:</label>
	      
	      <div class="input-group">
	        
	        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
	        <input type="text" class="form-control cambioEmpresa" id="cuenta" value="<?php echo $empresa[0]["cuenta"]; ?>">

	      </div>
	    
	    </div>
	</div>

  	<div class="box-footer">
      
    	<button type="button" id="guardarEmpresa" class="btn btn-primary pull-right">Guardar</button>
    
 	</div>

</div>