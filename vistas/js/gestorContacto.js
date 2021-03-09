/*=============================================
CARGAR LA TABLA DINÁMICA DE CATEGORÍAS
=============================================*/

// $.ajax({

// 	url:"ajax/tablaContacto.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

$(".tablaContacto").DataTable({
	 "ajax": "ajax/tablaContacto.ajax.php",
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



$(".modalAgregarContacto").on("click", function(){

//cargarFlota();
//cargarDispositivo();

})


/*=============================================
EDITAR CATEGORIA
=============================================*/

$(".tablaContacto tbody").on("click", ".btnEditarContacto", function(){
		cargarFlota();
	var idContacto = $(this).attr("idContacto");

	var datos = new FormData();
	datos.append("idContacto", idContacto);

	$.ajax({

		url:"ajax/contacto.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			//console.log(respuesta);

			$("#modalEditarContacto .editarIdContacto").val(respuesta["id"]);

			$("#modalEditarContacto .editarNombreContacto").val(respuesta["nombre"]);
			$("#modalEditarContacto .editarFlota").val(respuesta["flota"]);

			$("#modalEditarContacto .editarTelefono").val(respuesta["telefono"]);
			$("#modalEditarContacto .editarEmail").val(respuesta["email"]);


			if ($("#modalEditarContacto .editarFlota").find("option[value='" + respuesta["flota"] + "']").length) {

				$('#modalEditarContacto .editarFlota').val(respuesta["flota"]).trigger('change');

			}

			/*=============================================
			CARGAMOS LOS TELEFONOS
			=============================================*/	
			
			if(respuesta["telefono"] != null){

				$("#modalEditarContacto .editarTelefonoContacto").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-phone"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg editarTelefono" name="telefonoContacto" value="'+respuesta["telefono"]+'" placeholder="TELEFONO (coma)" name="telefonoCliente">'+

				'</div>');

				$("#modalEditarContacto .tagsInputTelefono").tagsinput('items');

			}else{

				$("#modalEditarContacto .editarTelefonoContacto").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-phone"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInputTelefono input-lg editarTelefono" placeholder="TELEFONO (coma)" name="telefonoContacto">'+

				'</div>');

				$("#modalEditarContacto .tagsInputTelefono").tagsinput('items');

			}

			/*=============================================
			CARGAMOS LOS EMAIL'S
			=============================================*/	
			if(respuesta["email"] != null){

				$("#modalEditarContacto .editarEmailContacto").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInputEmail input-lg emailContacto" name="emailContacto" value="'+respuesta["email"]+'" placeholder="EMAIL (comas)" name="emailCliente">'+

				'</div>');

				$("#modalEditarContacto .tagsInputEmail").tagsinput('items');

			}else{

				$("#modalEditarContacto .editarEmailContacto").html('<div class="input-group">'+
      
        		'<span class="input-group-addon"><i class="fa fa-envelope"></i></span>'+ 

				'<input data-role="tagsinput" type="text" class="form-control tagsInputEmail input-lg emailContacto" placeholder="EMAIL (comas)" name="emailContacto">'+

				'</div>');

				$("#modalEditarContacto .tagsInputEmail").tagsinput('items');

			}


			$(".bootstrap-tagsinput").css({"padding":"12px",
										   "width":"110%"})
		}

	})



})