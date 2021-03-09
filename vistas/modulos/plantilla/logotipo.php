<?php

$plantilla = ControladorPlantilla::ctrSeleccionarPlantilla();

?>

<div class="box box-primary">

	<!--=====================================
  	LOGOTIPO
  	======================================-->

	<div class="box-header with-border">

		<h3 class="box-title">LOGOTIPO</h3>

		<div class="box-tools pull-right">
			
			<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">

				<i class="fa fa-minus"></i>

			</button>

		</div>
	
	</div>

	<div class="box-body">
	
		<div class="form-group">
			
			<label>Cambiar logotipo</label>

			<p class="pull-right">
				
				<img src="<?php  echo $plantilla["logo"]; ?>" class="img-thumbnail previsualizarLogo" width="200px">

			</p>

			<input type="file" id="subirLogo">

			<p class="help-block">Tamaño recomendado 1200px * 350px</p>	

		</div>	

	</div>

	<div class="box-footer">
		
		<button type="button" id="guardarLogo" class="btn btn-primary pull-right">Guardar Logotipo</button>

	</div>

	<!--=====================================
  	ICONO
  	======================================-->

  	<div class="box-header with-border">

		<h3 class="box-title">ICONO</h3>
	
	</div>

	<div class="box-body">
	
		<div class="form-group">
			
			<label>Cambiar icono</label>

			<p class="pull-right">
				
				<img src="<?php  echo $plantilla["icono"]; ?>" class="img-thumbnail previsualizarIcono" width="50px">

			</p>

			<input type="file" id="subirIcono">

			<p class="help-block">Tamaño recomendado 300px * 300px</p>	

		</div>	

	</div>

	<div class="box-footer">
		
		<button type="button" id="guardarIcono" class="btn btn-primary pull-right">Guardar Icono</button>

	</div>


	<!--=====================================
  	FONDO
  	======================================-->

  	<div class="box-header with-border">

		<h3 class="box-title">FONDO INICIO</h3>
	
	</div>

	<div class="box-body">
	
		<div class="form-group">
			
			<label>Cambiar Background</label>

			<p class="pull-right">
				
				<img src="<?php  echo $plantilla["fondoLogin"]; ?>" class="img-thumbnail previsualizarBackground" width="90px" >

			</p>

			<input type="file" id="subirBackground">

			<p class="help-block">Tamaño recomendado 850px * 1080</p>	

		</div>	

	</div>

	<div class="box-footer">
		
		<button type="button" id="guardarBackground" class="btn btn-primary pull-right">Guardar Icono</button>

	</div>


	<!--=====================================
  	CONTRATO
  	======================================-->

  	<div class="box-header with-border">

		<h3 class="box-title">FONDO CONTRATO</h3>
	
	</div>

	<div class="box-body">
	
		<div class="form-group">
			
			<label>Cambiar Fondo Contrato</label>

			<p class="pull-right">
				
				<img src="<?php  echo $plantilla["fondoContrato"]; ?>" class="img-thumbnail previsualizarContrato" width="90px" >

			</p>

			<input type="file" id="subirContrato">

			<p class="help-block">Tamaño recomendado 2480 x 3508</p>	

		</div>	

	</div>

	<div class="box-footer">
		
		<button type="button" id="guardarContrato" class="btn btn-primary pull-right">Guardar Contrato</button>

	</div>



	<!--=====================================
  	ACTA
  	======================================-->

  	<div class="box-header with-border">

		<h3 class="box-title">FONDO ACTA</h3>
	
	</div>

	<div class="box-body">
	
		<div class="form-group">
			
			<label>Cambiar Fondo Acta</label>

			<p class="pull-right">
				
				<img src="<?php  echo $plantilla["fondoActa"]; ?>" class="img-thumbnail previsualizarActa" width="90px" >

			</p>

			<input type="file" id="subirActa">

			<p class="help-block">Tamaño recomendado 2480 x 3508</p>	

		</div>	

	</div>

	<div class="box-footer">
		
		<button type="button" id="guardarActa" class="btn btn-primary pull-right">Guardar Acta</button>

	</div>



	<!--=====================================
  	CERTIFICADO
  	======================================-->

  	<div class="box-header with-border">

		<h3 class="box-title">FONDO CERTIFICADO</h3>
	
	</div>

	<div class="box-body">
	
		<div class="form-group">
			
			<label>Cambiar Fondo Certificado</label>

			<p class="pull-right">
				
				<img src="<?php  echo $plantilla["fondoCertificado"]; ?>" class="img-thumbnail previsualizarCertificado" width="90px" >

			</p>

			<input type="file" id="subirCertificado">

			<p class="help-block">Tamaño recomendado 2480 x 3508</p>	

		</div>	

	</div>

	<div class="box-footer">
		
		<button type="button" id="guardarCertificado" class="btn btn-primary pull-right">Guardar Certificado</button>

	</div>



	<!--=====================================
  	FIRMA
  	======================================-->

  	<div class="box-header with-border">

		<h3 class="box-title">FIRMA</h3>
	
	</div>

	<div class="box-body">
	
		<div class="form-group">
			
			<label>Cambiar Firma</label>

			<p class="pull-right">
				
				<img src="<?php  echo $plantilla["fondoFirma"]; ?>" class="img-thumbnail previsualizarFirma" width="90px" >

			</p>

			<input type="file" id="subirFirma">

			<p class="help-block">Tamaño recomendado 500 x 230</p>	

		</div>	

	</div>

	<div class="box-footer">
		
		<button type="button" id="guardarFirma" class="btn btn-primary pull-right">Guardar Firma</button>

	</div>

</div>
