/*=============================================
CARGAR LA TABLA DINÁMICA DE REPORTES
=============================================*/

// $.ajax({

// 	url:"ajax/tablaReportes.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

var tablaReporte = $(".tablaReportes").DataTable({
	 "ajax": "ajax/tablaReportes.ajax.php",
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

function cargarVehiculosReporte(){
$('#modalAgregarReporte .idvehiculoreporte').html('');
$('#modalEditarAReporte .idvehiculoreporte').html('');
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
				$('.idvehiculoreporte').append(newOption).trigger('change');
				//$('.editaractavehiculo').append(newOption).trigger('change');

				

			 }


		}

	})

}

$(".modalAgregarReporte").on("click", function(){

cargarVehiculosReporte();

})


$(".tablaReportes tbody").on("click", ".btnVerReporte", function(){
	$(".ListaDetalleReporte").html('');
	var idReporte = $(this).attr("idReporte");
	var flota= $(this).attr("flota");
	var placa= $(this).attr("placa");

	var datos = new FormData();
	datos.append("idReporte", idReporte);

	$.ajax({

		url:"ajax/reportes.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){


			$("#modalVerReporte .idReporteEditar").val(respuesta["id"]);

			$("#modalVerReporte .idVehiculoEditar").val(placa);

			$("#modalVerReporte .flotaEditar").val(flota);
			$("#modalVerReporte .fechaReporteEditar").val(respuesta["fecha_t"]);
			$("#modalVerReporte .horaReporteEditar").val(respuesta["hora_t"]);

		  	var detalle = new FormData();
		  	detalle.append("idDetalleReporte", respuesta["id"])
		  	$.ajax({

		  		url:"ajax/reportes.ajax.php",
		  		method: "POST",
			  	data: detalle,
			  	cache: false,
		      	contentType: false,
		      	processData: false,
      			dataType: "json",
		      	success: function(resdetalle){ 
		      		console.log(resdetalle);
		      		console.log(resdetalle.length);
					if (resdetalle.length > 0) {
			      		$(".ListaDetalleReporte").append('<ul>');
			      		resdetalle.forEach(ArrayDetalleReporte);

			      		function ArrayDetalleReporte(element, index, array) {

			            	$(".ListaDetalleReporte").append('<li>'+element.detalle+'</li>');



			            }
			            $(".ListaDetalleReporte").append('</ul>');

	            		
		      	 	}   

		      	} 	 

		  	});
		}

	})

})

$("#modalVerReporte").on("click", ".CambiarEstado", function(e){
	e.preventDefault();
	var estado = $(this).attr("estado");
	var idReporte = $(".idReporteEditar").val();

	var datos = new FormData();
	datos.append("activarReporte", estado)

 	datos.append("activarId", idReporte);
  	datos.append("activarReporte", estado);

  	$.ajax({

  		 url:"ajax/reportes.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 
      		tablaReporte.ajax.reload();
      	    

      	} 	 

  	});


  	if(estado == 0){
  		iziToast.show({
              title: '<h4><label class="label-danger">REPORTE MARCADO</label></h4>',
              message: '<br>Como "Por Accionar"',
              theme: 'light',
              layout: 2,
              displayMode: 2,
              progressBar: false,
              imageWidth: 325,
              timeout: 2000,
              transitionIn: 'bounceInLeft',
              onClosed: function () {
                //location.reload();
              }
     	});
  	
  	}if(estado == 1){
  		iziToast.show({
              title: '<h4><label class="label-warning">REPORTE MARCADO</label></h4>',
              message: '<br>Como "En Espera"',
              theme: 'light',
              layout: 2,
              displayMode: 2,
              progressBar: false,
              imageWidth: 325,
              timeout: 2000,
              transitionIn: 'bounceInLeft',
              onClosed: function () {
                //location.reload();
              }
     	});

  	}if(estado == 2){
  		iziToast.show({
              title: '<h4><label class="label-success">REPORTE MARCADO</label></h4>',
              message: '<br>Como "Solucionado"',
              theme: 'light',
              layout: 2,
              displayMode: 2,
              progressBar: false,
              imageWidth: 325,
              timeout: 2000,
              transitionIn: 'bounceInLeft',
              onClosed: function () {
                //location.reload();
              }
     	});

  	}

})