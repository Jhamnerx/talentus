/*=============================================
CARGAR LA TABLA DINÁMICA DE TAREAS
=============================================*/

// $.ajax({

// 	url:"ajax/tablaHistorialTareas.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

var taskComplete = $(".tablaVerTareaCompletadas").DataTable({
	 "ajax": "ajax/tablaTareas.ajax.php",
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



var taskProgress = $(".tablaVerTareaProgreso").DataTable({
	 "ajax": "ajax/tablaTareasProgreso.ajax.php",
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


var taskCancel = $(".tablaVerTareaCancelada").DataTable({
	 "ajax": "ajax/tablaTareasCancelada.ajax.php",
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



var tasks = $(".tablaVerTareas").DataTable({
	 "ajax": "ajax/tablaHistorialTareas.ajax.php",
	 "deferRender": true,
	 "retrieve": true,
	 "iDisplayLength": 3,
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

var tipTareas = $(".tablaVerTipoTareas").DataTable({
	 "ajax": "ajax/TablaTipoTareas.ajax.php",
	 "deferRender": true,
	 "retrieve": true,
	 "iDisplayLength": 5,
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

function cargarVehiculosTarea(){
$('#modalCrearTarea .idVehiculo').html('');
 	var datos = new FormData();
 	//
 	datos.append("idvehiculoc", "null");
 	datos.append("item", "");
	$.ajax({
		url:"ajax/vehiculos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){

			//console.log(respuesta);

			var datosFlota = JSON.parse(respuesta);

			 datosFlota.forEach(forEachFlota);

			 function forEachFlota(vehiculo, index){
				//$(".editaridvehiculo").val(null).trigger("change");
				var newOption = new Option(vehiculo.placa, vehiculo.id, false, false);
				//$(".idvehiculo").append('<option value="'+vehiculo.id+'">'+vehiculo.nombre+'</option>');
				$('#modalCrearTarea .idVehiculo').append(newOption).trigger('change');
				//var selectVehiculos = $("#modalCrearTarea .idVehiculo").select2();


				//$('.editaractavehiculo').append(newOption).trigger('change');

				

			 }


		}

	})

}

$(".modalCrearTarea").on("click", function(){

cargarVehiculosTarea();

})
//CANCELAR TAREA NO LEIDA A CANCELADAS
$(".tablaVerTareaNoLeida").on("click", ".btnCancelarTarea", function(){

	idTarea = $(this).attr("idtarea");
	//console.log("cancelar tarea "+idTarea);

	var actualizarItemTarea = "estado";
	var actualizarId = idTarea;
	var valorTarea = 0


	var datos = new FormData();
	datos.append("actualizarItemTarea", actualizarItemTarea);
	datos.append("actualizarId", actualizarId);
	datos.append("valorTarea", valorTarea);

	swal({
		title: "¿Está usted seguro(a)?",
		text: "¡La tarea se marcara como cancelada!",
		type: "warning",
		showConfirmButton: true,
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "¡Si, Cancelarla!",
		}).then(function(result){
				if (result.value) {

					$.ajax({

				  		url:"ajax/tarea.ajax.php",
				  		method: "POST",
					  	data: datos,
					  	cache: false,
				      	contentType: false,
				      	processData: false,
				      	success: function(respuesta){ 

				      		console.log(respuesta);
				      		iziToast.show({
				            	title: '<h4>TAREA CANCELADA</h4>',
				             	message: '<br>Se ha cancelado la tarea, disponible en Tareas canceladas',
				             	theme: 'light',
				             	layout: 2,
				              	displayMode: 2,
				              	progressBar: false,
				              	imageWidth: 325,
				             	 timeout: 3000,
				              	transitionIn: 'bounceInLeft',
				             	onClosed: function () {
				                	location.reload();
				              	}
				     		});

				     		taskProgress.ajax.reload();
				     		taskCancel.ajax.reload();
				      	    

				      	} 	 

				  	});

				}
			})


})


//TAREA EN PROGRESO A CANCELADA

$(".tablaVerTareaProgreso").on("click", ".btnCancelarTarea", function(){

	idTarea = $(this).attr("idtarea");
	console.log("cancelar tarea "+idTarea);

	var actualizarItemTarea = "estado";
	var actualizarId = idTarea;
	var valorTarea = 0


	var datos = new FormData();
	datos.append("actualizarItemTarea", actualizarItemTarea);
	datos.append("actualizarId", actualizarId);
	datos.append("valorTarea", valorTarea);

	swal({
		title: "¿Está usted seguro(a)?",
		text: "¡La tarea se marcara como cancelada!",
		type: "warning",
		showConfirmButton: true,
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "¡Si, Cancelarla!",
		}).then(function(result){
				if (result.value) {

					$.ajax({

				  		url:"ajax/tarea.ajax.php",
				  		method: "POST",
					  	data: datos,
					  	cache: false,
				      	contentType: false,
				      	processData: false,
				      	success: function(respuesta){ 

				      		console.log(respuesta);
				      		iziToast.show({
				            	title: '<h4>TAREA CANCELADA</h4>',
				             	message: '<br>Se ha cancelado la tarea, disponible en Tareas canceladas',
				             	theme: 'light',
				             	layout: 2,
				              	displayMode: 2,
				              	progressBar: false,
				              	imageWidth: 325,
				             	 timeout: 3000,
				              	transitionIn: 'bounceInLeft',
				             	onClosed: function () {
				                	location.reload();
				              	}
				     		});

				     		taskProgress.ajax.reload();
				     		taskCancel.ajax.reload();
				      	    

				      	} 	 

				  	});

				}
			})


})
//PROGRESO A TERMINADA
$(".tablaVerTareaProgreso").on("click", ".btnTerminarTarea", function(){

	idTarea = $(this).attr("idtarea");
	//console.log("cancelar tarea "+idTarea);

	var actualizarItemTarea = "estado";
	var actualizarId = idTarea;
	var valorTarea = 2


	var datos = new FormData();
	datos.append("actualizarItemTarea", actualizarItemTarea);
	datos.append("actualizarId", actualizarId);
	datos.append("valorTarea", valorTarea);
	swal({
		  title: "¿Está usted seguro(a)?",
		  text: "¡La tarea se marcara como terminada!",
		  type: "success",
		  showCancelButton: true,
		  confirmButtonColor: "#3da165",
		  confirmButtonText: "¡Si, Terminarla!",
		  closeOnConfirm: true
		},
		function(isConfirm){
				if (isConfirm) {
					$.ajax({

				  		url:"ajax/tarea.ajax.php",
				  		method: "POST",
					  	data: datos,
					  	cache: false,
				      	contentType: false,
				      	processData: false,
				      	success: function(respuesta){ 

				      		//console.log(respuesta);
				      		iziToast.show({
				            	title: '<h4>TAREA CANCELADA</h4>',
				             	message: '<br>Se ha cancelado la tarea, disponible en Tareas canceladas',
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

				     		taskProgress.ajax.reload();
				     		taskCancel.ajax.reload();
				      	    

				      	} 	 

				  	});

				} 
		});



})

$('#modalCrearTarea .idVehiculo').on('select2:select', function (e) {
    var data = e.params.data;

 	var datos = new FormData();
 	//
 	datos.append("placaVehiculo", data.text);
 	datos.append("item", "placa");


	$.ajax({
		url:"ajax/vehiculos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			//console.log(respuesta["sim"]);

			$("#modalCrearTarea .simTarea").val(respuesta["sim"]);

			var idLinea = respuesta["sim"];

			var datos = new FormData();
		 	datos.append("editarIdLinea", idLinea);

			
			$.ajax({

				url:"ajax/lineas.ajax.php",
				method: "POST",
				data: datos,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(lineas){

					//console.log(lineas);
					$("#modalCrearTarea .simCardTarea").val(lineas["sim_card"]);

				}

			})

		}

	})



});



//Cambiar tipo de Tarea


$("#modalCrearTarea .tipoTarea").change(function(){

	tipoTarea = $(this).val();

	if (tipoTarea == "2") {

		//console.log("cambiar")


		$("#modalCrearTarea .divNuevo").css("display","block")
		$("#modalCrearTarea .nuevoSimTarea").css("border-color","green")
		$("#modalCrearTarea .nuevoSimCardTarea").css("border-color","green")

	}else{

		$("#modalCrearTarea .divNuevo").css("display","none")

	}



})


function cargarDispositivo(){
	$('#modalCrearTarea .dispositivo').html('');
 	var datos = new FormData();
 	datos.append("mostrar", "null");
	$.ajax({
		url:"ajax/dispositivos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){
			//console.log(respuesta);

			var datosDispositivo = JSON.parse(respuesta);

			 datosDispositivo.forEach(forEachDispositivo);

			 function forEachDispositivo(dispositivo, index){


				//$(".dispositivo").append('<option value="'+dispositivo.id+'">'+dispositivo.modelo+'</option>');
				var newOption = new Option(dispositivo.modelo, dispositivo.id, false, false);
				//console.log(newOption);
				$('.dispositivo').append(newOption).trigger('change');

			 }


		}

	})

}

$(".modalCrearTarea").on("click", function(){

cargarDispositivo();

})


$(".tablaVerTareaProgreso tbody").on("click", ".btnEnviarMensaje", function(){

  var elemento = document.getElementById("whatsapp");
  while (elemento.firstChild) {
    elemento.removeChild(elemento.firstChild);
  }

  var numeroTelefono = $(this).attr("numeroCliente");
  var fechaCreacion = $(this).attr("fechaCobro");
  var fechaVencimiento = $(this).attr("fechaVencimiento");
  var monto = $(this).attr("monto");
  var cliente = $(this).attr("cliente");

    $(function () {
        $('#whatsapp').floatingWhatsApp({
            number: '+51 987654321',
            popupMessage: 'Estimado escribe tu mensaje y numero',
            message: "Estimado Cliente responde con un 'OK' a este mensaje Si el servicio prestado esta conforme, *Luego de responder no se aceptan quejas*",
            showPopup: true,
            showOnIE: false,
            headerTitle: 'Bienvenido!',
            headerColor: '#075e54',
            backgroundColor: '#128C7E',
            buttonImage: '<img src="'+rutaOculta+'vistas/img/whatsapp.svg"/>'
        });
    });

})