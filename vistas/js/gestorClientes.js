/*=============================================
CARGAR LA TABLA DINÁMICA DE Cliente
=============================================*/

// $.ajax({

// 	url:"ajax/tablaCliente.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

$(".tablaCliente").DataTable({
	 "ajax": "ajax/tablaClientes.ajax.php",
	 "deferRender": true,
	 "retrieve": true,
	 "processing": true,
	 "language": {

	 	"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "Ningún dato disponible en esta tabla",
		"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate": {
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
		},
		"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}

	 }


});


/*=============================================
ACTIVAR Cliente
=============================================*/

$(".tablaCliente tbody").on("click", ".btnActivar", function(){

	var idPersona = $(this).attr("idCliente");
	var estadoPersona = $(this).attr("estadoCliente");

	var datos = new FormData();
 	datos.append("activarId", idPersona);
  	datos.append("activarPersona", estadoPersona);

  	$.ajax({

  		 url:"ajax/persona.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 

      		console.log(respuesta);
      	    

      	} 	 

  	});

  	if(estadoPersona == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoCliente',1);

  		iziToast.show({
              title: '<h4><label class="label-danger">Cliente DESACTIVADO</label></h4>',
              message: '<br>Se ha desactivado, no se mostrará',
              theme: 'light',
              layout: 2,
              displayMode: 2,
              progressBar: false,
              imageWidth: 325,
              timeout: 3000,
              transitionIn: 'bounceInLeft',
              onClosed: function () {
                //location.reload();
              }
     	});
  	
  	}else{

  		$(this).addClass('btn-success');
  		$(this).removeClass('btn-danger');
  		$(this).html('Activado');
  		$(this).attr('estadoCliente',0);

  		iziToast.show({
              title: '<h4><label class="label-success">Cliente ACTIVADO</label></h4>',
              message: '<br>Se ha activado, se mostrará',
              theme: 'light',
              layout: 2,
              displayMode: 2,
              progressBar: false,
              imageWidth: 325,
              timeout: 3000,
              transitionIn: 'bounceInLeft',
              onClosed: function () {
                //location.reload();
              }
     	});

  	}

})


 /*=============================================
REVISAR CLIENTE EXISTENTE
=============================================*/
$(document).on("keyup", ".validarClienteJ ", function(){

	$(".AlertaCliente").remove();
	$(".guardarCliente").removeAttr("disabled");

	var NombreCliente =$(this).val()
	//console.log(NombreCliente);



	if (NombreCliente != "") {
	
		var datos = new FormData();
		datos.append("NombreCliente", NombreCliente);

		$.ajax({
		    url:"ajax/persona.ajax.php",
		    method:"POST",
		    data: datos,
		    cache: false,
		    contentType: false,
		    processData: false,
		    dataType: "json",
		    success:function(respuesta){
		    	
		    	console.log("respuesta", respuesta);

		    	if(respuesta){

		    		$(".personaJuridica").append('<p class="AlertaCliente warning" style="font-size: 13px; color: red">El cliente '+respuesta["nombre"]+' ya existe</p>')
		    		$(".guardarCliente").attr("disabled", "");
		    	}else{


					/*=============================================
					GUARDAR Cliente
					=============================================*/
					$(".guardarCliente").click(function(){


						/*=============================================
						PREGUNTAMOS SI LOS CAMPOS OBLIGATORIOS ESTÁN LLENOS
						=============================================*/

						if($(".numDocumento").val() != ""){

							/*=============================================
							ALMACENAMOS TODOS LOS CAMPOS DE ClienteR
							=============================================*/
							var tipoCliente = $(".seleccionarTipoPersona").val();
							var nombreClienteJ = $(".nombreClienteJ").val();
							var nombreClienteN= $(".nombreClienteN").val();
							var apellidoCliente = $(".apellidoCliente").val();
							var tipoDocumento = $(".tipoDocumento").val();
							var numDocumento = $(".numDocumento").val();
							var direccionCliente = $(".direccionCliente").val();
							var telefonoCliente = $(".telefonoCliente").val();

							var emailCliente = $(".emailCliente").val();


							var datosCliente = new FormData();


							if (tipoCliente == "juridica") {

								datosCliente.append("tipo", "Cliente");
								datosCliente.append("nombrePersona", nombreClienteJ);
								console.log(nombreClienteJ);
								datosCliente.append("apellidoPersona", null);
								datosCliente.append("guardarPersona", 1);
								datosCliente.append("tipoDocumento", tipoDocumento);
								datosCliente.append("numDocumento", numDocumento);
								datosCliente.append("direccionPersona", direccionCliente);
								datosCliente.append("telefonoPersona", telefonoCliente);
								datosCliente.append("emailPersona", emailCliente);


							}else{

								datosCliente.append("tipo", "Cliente");
								datosCliente.append("nombrePersona", nombreClienteN);
								console.log(nombreClienteN);
								console.log(apellidoCliente);
								datosCliente.append("apellidoPersona", apellidoCliente);
								datosCliente.append("guardarPersona", 1);
								datosCliente.append("tipoDocumento", tipoDocumento);
								datosCliente.append("numDocumento", numDocumento);
								datosCliente.append("direccionPersona", direccionCliente);
								datosCliente.append("telefonoPersona", telefonoCliente);
								datosCliente.append("emailPersona", emailCliente);
							}


							$.ajax({
								url:"ajax/persona.ajax.php",
								method: "POST",
								data: datosCliente,
								cache: false,
								contentType: false,
								processData: false,
								success: function(respuesta){
									
									console.log("respuesta", respuesta);

									if(respuesta == 1){

										swal({
										  type: "success",
										  title: "El Cliente ha sido guardado correctamente",
										  showConfirmButton: true,
										  confirmButtonText: "Cerrar"
										  }).then(function(result){
											if (result.value) {

											window.location = "clientes";

											}
										})
									}

								}

							})


						}else{

							 swal({
						      title: "Llenar todos los campos obligatorios",
						      type: "error",
						      confirmButtonText: "¡Cerrar!"
						    });

							return;
						}


					})


		    	}   

		    }

		  })
	

	}


});
/*=============================================
EDITAR Cliente
=============================================*/

$(".tablaCliente tbody").on("click", ".btnEditarCliente", function(){

	var idCliente = $(this).attr("idcliente");
	//console.log(idCliente);

	var datos = new FormData();
	datos.append("idPersona", idCliente);

	$.ajax({

		url:"ajax/persona.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			//console.log(respuesta);


			$("#modalEditarCliente .editarIdCliente").val(respuesta["id"]);

			if (respuesta["tipo_documento"] == "DNI") {

				$("#modalEditarCliente .seleccionarTipo").val("natural");
				$("#modalEditarCliente .numDocumento").attr("maxlength", "8");

				$(".personaNatural").show();
				$(".personaJuridica").hide();

				$("#modalEditarCliente .nombreClienteN").val(respuesta["nombre"]);
				$("#modalEditarCliente .apellidoCliente").val(respuesta["apellido"]);
				



			}else{
				$("#modalEditarCliente .seleccionarTipo").val("juridica");
				$("#modalEditarCliente .numDocumento").attr("maxlength", "12");
				$(".personaJuridica").show();
				$(".personaNatural").hide();

				$("#modalEditarCliente .nombreClienteJ").val(respuesta["nombre"]);
			}
			
			$("#modalEditarCliente .tipoDocumento").val(respuesta["tipo_documento"]);
			$("#modalEditarCliente .numDocumento").val(respuesta["num_documento"]);
			$("#modalEditarCliente .direccionCliente").val(respuesta["direccion"]);

			

			/*=============================================
			CARGAMOS LOS TELEFONOS
			=============================================*/	
			
			if(respuesta["telefono"] != null){

				$("#modalEditarCliente .editarTelefonoCliente").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-phone"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg telefonoCliente" value="'+respuesta["telefono"]+'" placeholder="TELEFONO (coma)" name="telefonoCliente">'+

				'</div>');

				$("#modalEditarCliente .tagsInputTelefono").tagsinput('items');

			}else{

				$("#modalEditarCliente .editarTelefonoCliente").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-phone"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg telefonoCliente" placeholder="TELEFONO (coma)" name="telefonoCliente">'+

				'</div>');

				$("#modalEditarCliente .tagsInputTelefono").tagsinput('items');

			}

			/*=============================================
			CARGAMOS LOS EMAIL'S
			=============================================*/	
			if(respuesta["email"] != null){

				$("#modalEditarCliente .editarEmailCliente").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInput input-lg emailCliente" value="'+respuesta["email"]+'" placeholder="EMAIL (comas)" name="emailCliente">'+

				'</div>');

				$("#modalEditarCliente .tagsInput").tagsinput('items');

			}else{

				$("#modalEditarCliente .editarEmailCliente").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInput input-lg emailCliente" placeholder="EMAIL (comas)" name="emailCliente">'+

				'</div>');

				$("#modalEditarCliente .tagsInput").tagsinput('items');

			}


			$(".bootstrap-tagsinput").css({"padding":"12px",
										   "width":"110%"})
			





		}

	})
})

$(".editarCliente").click(function(){

		/*=============================================
		ALMACENAMOS TODOS LOS CAMPOS DE ClienteR
		=============================================*/
		var idCliente = $(".modalEditarCliente .editarIdCliente").val();
		var tipoCliente = $(".modalEditarCliente .seleccionarTipoPersona").val();
		var nombreClienteJ = $(".modalEditarCliente .nombreClienteJ").val();
		var nombreClienteN= $(".modalEditarCliente .nombreClienteN").val();
		var apellidoCliente = $(".modalEditarCliente .apellidoCliente").val();
		var tipoDocumento = $(".modalEditarCliente .tipoDocumento").val();
		var numDocumento = $(".modalEditarCliente .numDocumento").val();
		var direccionCliente = $(".modalEditarCliente .direccionCliente").val();
		var telefonoCliente = $(".modalEditarCliente .telefonoCliente").val();

		var emailCliente = $(".modalEditarCliente .emailCliente").val();




		var datosCliente = new FormData();

		//console.log(tipoCliente);


		if (tipoCliente == "juridica") {

			datosCliente.append("tipo", "Cliente");
			datosCliente.append("editarPersona", "1");
			datosCliente.append("idEditarPersona", idCliente);
			datosCliente.append("nombrePersona", nombreClienteJ);
			//console.log(nombreClienteJ);
			datosCliente.append("apellidoPersona", null);
			datosCliente.append("tipoDocumento", tipoDocumento);
			datosCliente.append("numDocumento", numDocumento);
			datosCliente.append("direccionPersona", direccionCliente);
			datosCliente.append("telefonoPersona", telefonoCliente);
			datosCliente.append("emailPersona", emailCliente);


		}else{

			datosCliente.append("tipo", "Cliente");
			datosCliente.append("editarPersona", "1");
			datosCliente.append("idEditarPersona", idCliente);
			datosCliente.append("nombrePersona", nombreClienteN);
			//console.log(nombreClienteN);
			datosCliente.append("apellidoPersona", apellidoCliente);
			datosCliente.append("tipoDocumento", tipoDocumento);
			datosCliente.append("numDocumento", numDocumento);
			datosCliente.append("direccionPersona", direccionCliente);
			datosCliente.append("telefonoPersona", telefonoCliente);
			datosCliente.append("emailPersona", emailCliente);
		}

		$.ajax({
			url:"ajax/persona.ajax.php",
			method: "POST",
			data: datosCliente,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){
				
				console.log(respuesta);

				if(respuesta == 1){

					swal({
					  type: "success",
					  title: "El Cliente ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "clientes";

						}
					})
				}else{

					
				}

			}

		})
})