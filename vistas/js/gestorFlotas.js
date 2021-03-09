/*=============================================
CARGAR LA TABLA DINÁMICA DE FLOTAS
=============================================*/

// $.ajax({

// 	url:"ajax/tablaFlotas.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

$(".tablaFlotas").DataTable({
	 "ajax": "ajax/tablaFlotas.ajax.php",
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

$(".tablaFlotas tbody").on("click", ".btnActivar", function(){

	var idFlota = $(this).attr("idFlota");
	var estadoFlota = $(this).attr("estadoFlota");

	var datos = new FormData();
 	datos.append("activarId", idFlota);
  	datos.append("activarFlota", estadoFlota);

  	$.ajax({

  		 url:"ajax/flotas.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 

      		console.log(respuesta);
      	    

      	} 	 

  	});

  	if(estadoFlota == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoFlota',1);

  		$(".idFlota"+idFlota).removeAttr("disabled");
  		iziToast.show({
              title: '<h4><label class="label-danger">FLOTA DESACTIVADA</label></h4>',
              message: '<br>Se ha desactivado, la flota no se mostrará',
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
  		$(this).attr('estadoFlota',0);
  		$(".idFlota"+idFlota).attr("disabled", "disabled");
  		iziToast.show({
              title: '<h4><label class="label-success">FLOTA ACTIVADA</label></h4>',
              message: '<br>Se ha activado, la flota se mostrará',
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
// CARGAR Cliente
// 
function cargarClienteFlotas(){
 	var datos = new FormData();
 	datos.append("tipoPersona", "Cliente");
	$.ajax({
		url:"ajax/persona.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){

			var datosCliente = JSON.parse(respuesta);

			datosCliente.forEach(forEachProveedor);

			function forEachProveedor(cliente, index){

				if (cliente.apellid = "null") {

					$(".idcliente").append('<option value="'+cliente.id+'">'+cliente.nombre+'</option>');
					$(".editarClienteflota").append('<option value="'+cliente.id+'">'+cliente.nombre+'</option>');
				}else{

					$(".idcliente").append('<option value="'+cliente.id+'">'+cliente.nombre+" "+cliente.apellido+'</option>');
					$(".editarClienteflota").append('<option value="'+cliente.id+'">'+cliente.nombre+" "+cliente.apellido+'</option>');
				}


				

			}


		}

	})

}

$(".AgregarFlota").on("click", function(){
	cargarClienteFlotas();
})
$(".btnAgregarFlota").on("click", function(){
	cargarClienteFlotas();
})


$(".tablaFlotas tbody").on("click", ".btnEditarFlota", function(){

	var idFlota = $(this).attr("idFlota");
	cargarClienteFlotas();
	//console.log(idFlota);
	var datos = new FormData();
	datos.append("idFlota", idFlota);
	datos.append("item", "id");

	$.ajax({

		url:"ajax/flotas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			


			$("#modalEditarFlota .editarIdflota").val(respuesta["id"]);

			$("#modalEditarFlota .EditarNombreFlota").val(respuesta["nombre"]);
			$("#modalEditarFlota .editarClienteflota").val(respuesta["idcliente"]);

			var idCliente = respuesta["idcliente"];

			var cliente = new FormData();
			cliente.append("idPersona", idCliente);

			$.ajax({

				url:"ajax/persona.ajax.php",
				method: "POST",
				data: cliente,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(respuesta){
					
					console.log(respuesta);

					if (respuesta.apellido == "null") {

						$(".editarClienteflota").append('<option value="'+respuesta.id+'">'+respuesta.nombre+'</option>');
					}else{

						$(".editarClienteflota").append('<option value="'+respuesta.id+'">'+respuesta.nombre+" "+respuesta.apellido+'</option>');
					}
					


				}
			})	


		}

	})

})
