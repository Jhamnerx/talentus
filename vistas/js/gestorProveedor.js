/*=============================================
CARGAR LA TABLA DINÁMICA DE PROVEEDORES
=============================================*/

// $.ajax({

// 	url:"ajax/tablaProveedor.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

$(".tablaProveedor").DataTable({
	 "ajax": "ajax/tablaProveedor.ajax.php",
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
ACTIVAR PROVEEDOR
=============================================*/

$(".tablaProveedor tbody").on("click", ".btnActivar", function(){

	var idPersona = $(this).attr("idProveedor");
	var estadoPersona = $(this).attr("estadoProveedor");

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
  		$(this).attr('estadoProveedor',1);

  		iziToast.show({
              title: '<h4><label class="label-danger">PROVEEDOR DESACTIVADO</label></h4>',
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
  		$(this).attr('estadoProveedor',0);

  		iziToast.show({
              title: '<h4><label class="label-success">PROVEEDOR ACTIVADO</label></h4>',
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
GUARDAR PROVEEDOR
=============================================*/
$(".guardarProveedor").click(function(){

	/*=============================================
	PREGUNTAMOS SI LOS CAMPOS OBLIGATORIOS ESTÁN LLENOS
	=============================================*/

	if($(".numDocumento").val() != ""){

		/*=============================================
		ALMACENAMOS TODOS LOS CAMPOS DE PROVEEDORR
		=============================================*/
		var tipoProveedor = $(".seleccionarTipoPersona").val();
		var nombreProveedorJ = $(".nombreProveedorJ").val();
		var nombreProveedorN= $(".nombreProveedorN").val();
		var apellidoProveedor = $(".apellidoProveedor").val();
		var tipoDocumento = $(".tipoDocumento").val();
		var numDocumento = $(".numDocumento").val();
		var direccionProveedor = $(".direccionProveedor").val();
		var telefonoProveedor = $(".telefonoProveedor").val();

		var emailProveedor = $(".emailProveedor").val();


		var datosProveedor = new FormData();


		if (tipoProveedor == "juridica") {

			datosProveedor.append("tipo", "Proveedor");
			datosProveedor.append("nombrePersona", nombreProveedorJ);
			datosProveedor.append("guardarPersona", 1);
			datosProveedor.append("apellidoPersona", "");
			datosProveedor.append("tipoDocumento", tipoDocumento);
			datosProveedor.append("numDocumento", numDocumento);
			datosProveedor.append("direccionPersona", direccionProveedor);
			datosProveedor.append("telefonoPersona", telefonoProveedor);
			datosProveedor.append("emailPersona", emailProveedor);
			$(".personaJuridica").show();
			$(".personaNatural").hide();


		}else{

			datosProveedor.append("tipo", "Proveedor");
			datosProveedor.append("nombrePersona", nombreProveedorN);
			datosProveedor.append("guardarPersona", 1);
			datosProveedor.append("apellidoPersona", apellidoProveedor);
			datosProveedor.append("tipoDocumento", tipoDocumento);
			datosProveedor.append("numDocumento", numDocumento);
			datosProveedor.append("direccionPersona", direccionProveedor);
			datosProveedor.append("telefonoPersona", telefonoProveedor);
			datosProveedor.append("emailPersona", emailProveedor);
			$(".personaJuridica").hide();
			$(".personaNatural").show();
		}


		$.ajax({
			url:"ajax/persona.ajax.php",
			method: "POST",
			data: datosProveedor,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){
				
				//console.log("respuesta", respuesta);

				if(respuesta == 1){

					swal({
					  type: "success",
					  title: "El Proveedor ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "proveedor";

						}
					})
				}else{


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

$(".tablaProveedor tbody").on("click", ".btnEliminarProveedor", function(){

	var idProveedor = $(this).attr("idProveedor");

	var datos = new FormData();

	datos.append("idPersonaEliminar". idProveedor);


})
/*=============================================
EDITAR PROVEEDOR
=============================================*/

$(".tablaProveedor tbody").on("click", ".btnEditarProveedor", function(){

	var idProveedor = $(this).attr("idProveedor");

	var datos = new FormData();
	datos.append("idPersona", idProveedor);

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


			$("#modalEditarProveedor .editarIdProveedor").val(respuesta["id"]);

			if (respuesta["tipo_documento"] == "DNI") {

				$("#modalEditarProveedor .seleccionarTipoPersona").val("natural");

				$(".personaNatural").show();
				$("#modalEditarProveedor .numDocumento").attr("maxlength", "8");
				$(".personaJuridica").hide();

				$("#modalEditarProveedor .nombreProveedorN").val(respuesta["nombre"]);
				$("#modalEditarProveedor .apellidoProveedor").val(respuesta["apellido"]);
				



			}else{
				$("#modalEditarProveedor .seleccionarTipoPersona").val("juridica");


				$(".personaJuridica").show();
				$(".personaNatural").hide();
				$("#modalEditarProveedor .numDocumento").attr("maxlength", "12");

				$("#modalEditarProveedor .nombreProveedorJ").val(respuesta["nombre"]);
			}

			$("#modalEditarProveedor .tipoDocumento").val(respuesta["tipo_documento"]);
			$("#modalEditarProveedor .numDocumento").val(respuesta["num_documento"]);
			$("#modalEditarProveedor .direccionProveedor").val(respuesta["direccion"]);

			

			/*=============================================
			CARGAMOS LOS TELEFONOS
			=============================================*/	
			
			if(respuesta["telefono"] != null){

				$("#modalEditarProveedor .editarTelefonoProveedor").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-phone"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg telefonoProveedor" value="'+respuesta["telefono"]+'" placeholder="TELEFONO (coma)" name="telefonoProveedor">'+

				'</div>');

				$("#modalEditarProveedor .tagsInputTelefono").tagsinput('items');

			}else{

				$("#modalEditarProveedor .editarTelefonoProveedor").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-phone"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg telefonoProveedor" placeholder="TELEFONO (coma)" name="telefonoProveedor">'+

				'</div>');

				$("#modalEditarProveedor .tagsInputTelefono").tagsinput('items');

			}

			/*=============================================
			CARGAMOS LOS EMAIL'S
			=============================================*/	
			if(respuesta["email"] != null){

				$("#modalEditarProveedor .editarEmailProveedor").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInput input-lg emailProveedor" value="'+respuesta["email"]+'" placeholder="EMAIL (comas)" name="emailProveedor">'+

				'</div>');

				$("#modalEditarProveedor .tagsInput").tagsinput('items');

			}else{

				$("#modalEditarProveedor .editarEmailProveedor").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInput input-lg emailProveedor" placeholder="EMAIL (comas)" name="emailProveedor">'+

				'</div>');

				$("#modalEditarProveedor .tagsInput").tagsinput('items');

			}


			$(".bootstrap-tagsinput").css({"padding":"12px",
										   "width":"110%"})
			





		}

	})
})

$(".editarProveedor").click(function(){

		/*=============================================
		ALMACENAMOS TODOS LOS CAMPOS DE PROVEEDORR
		=============================================*/
		var idProveedor = $(".modalEditarProveedor .editarIdProveedor").val();
		var tipoProveedor = $(".modalEditarProveedor .seleccionarTipoPersona").val();
		var nombreProveedorJ = $(".modalEditarProveedor .nombreProveedorJ").val();
		var nombreProveedorN= $(".modalEditarProveedor .nombreProveedorN").val();
		var apellidoProveedor = $(".modalEditarProveedor .apellidoProveedor").val();
		var tipoDocumento = $(".modalEditarProveedor .tipoDocumento").val();
		var numDocumento = $(".modalEditarProveedor .numDocumento").val();
		var direccionProveedor = $(".modalEditarProveedor .direccionProveedor").val();
		var telefonoProveedor = $(".modalEditarProveedor .telefonoProveedor").val();

		var emailProveedor = $(".modalEditarProveedor .emailProveedor").val();




		var datosProveedor = new FormData();


		if (tipoProveedor == "juridica") {

			datosProveedor.append("tipo", "Proveedor");
			datosProveedor.append("idEditarPersona", idProveedor);
			datosProveedor.append("editarPersona", "1");
			datosProveedor.append("nombrePersona", nombreProveedorJ);
			datosProveedor.append("apellidoPersona", "");
			datosProveedor.append("tipoDocumento", tipoDocumento);
			datosProveedor.append("numDocumento", numDocumento);
			datosProveedor.append("direccionPersona", direccionProveedor);
			datosProveedor.append("telefonoPersona", telefonoProveedor);
			datosProveedor.append("emailPersona", emailProveedor);


		}else{

			datosProveedor.append("tipo", "Proveedor");
			datosProveedor.append("idEditarPersona", idProveedor);
			datosProveedor.append("editarPersona", "1");
			datosProveedor.append("nombrePersona", nombreProveedorN);
			datosProveedor.append("apellidoPersona", apellidoProveedor);
			datosProveedor.append("tipoDocumento", tipoDocumento);
			datosProveedor.append("numDocumento", numDocumento);
			datosProveedor.append("direccionPersona", direccionProveedor);
			datosProveedor.append("telefonoPersona", telefonoProveedor);
			datosProveedor.append("emailPersona", emailProveedor);
		}

		$.ajax({
			url:"ajax/persona.ajax.php",
			method: "POST",
			data: datosProveedor,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){
				
				//console.log("respuesta", respuesta);

				if(respuesta == 1){

					swal({
					  type: "success",
					  title: "El Proveedor ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "proveedor";

						}
					})
				}else{

					
				}

			}

		})

})

$(".tipoDocumento").on("change", function(){

	var tipoDoc = $(this).val();
	console.log(tipoDoc);
	if (tipoDoc == "DNI") {

		$(".numDocumento").attr("maxlength", 8);
		$(".numDocumento").val("");
	}else{
		$(".numDocumento").attr("maxlength", 12);
		$(".numDocumento").val("");
	}
})

