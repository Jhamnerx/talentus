/*=============================================
CARGAR LA TABLA DINÁMICA DE VEHICULOS
=============================================*/
// 
// $.ajax({
//
// 	url:"ajax/tablaVehiculos.ajax.php",
// 	success:function(respuesta){
//
// 		console.log("respuesta", respuesta);
//
// 	}
//
// })

$(".tablaVehiculos").DataTable({
	 "ajax": "ajax/tablaVehiculos.ajax.php",
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

/**

ACTIVAR//DESACTIVAR
**/

$(".tablaVehiculos tbody").on("click", ".btnActivar", function(){

	var idVehiculo = $(this).attr("idVehiculo");
	var estadoVehiculo = $(this).attr("estadoVehiculo");

	var datos = new FormData();
 	datos.append("activarId", idVehiculo);
  	datos.append("activarVehiculo", estadoVehiculo);

  	$.ajax({

  		 url:"ajax/vehiculos.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){


      	}

  	});

  	if(estadoVehiculo == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoVehiculo',1);
  		iziToast.show({
              title: '<h4><label class="label-danger">VEHICULO DESACTIVADO</label></h4>',
              message: '<br>Se ha desactivado, El Vehiculo no se mostrará',
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
  		$(this).attr('estadoVehiculo',0);
  		iziToast.show({
              title: '<h4><label class="label-success">VEHICULO ACTIVADO</label></h4>',
              message: '<br>Se ha activado, el Vehiculo se mostrará',
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
// CARGAR FLOTA
//
function cargarVehiculos(){
$('#modalAgregarActa .idvehiculo').html('');
$('#modalEditarActa .idvehiculo').html('');
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
				$('.idvehiculo').append(newOption).trigger('change');
				//$('.editaractavehiculo').append(newOption).trigger('change');



			 }


		}

	})

}



// CARGAR FLOTA
//
function cargarFlota(){

// $('#modalEditarVehiculo .idflota').html('');
// $('#modalEditarContacto .idflota').html('');
 	var datos = new FormData();
 	//
 	datos.append("idFlota", "null");
 	datos.append("item", "");
	$.ajax({
		url:"ajax/flotas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){

			//console.log(respuesta);

			var datosFlota = JSON.parse(respuesta);

			 datosFlota.forEach(forEachFlota);

			 function forEachFlota(flota, index){
				//$(".editaridflota").val(null).trigger("change");
				var newOption = new Option(flota.nombre, flota.id, false, false);
				//$(".idflota").append('<option value="'+flota.id+'">'+flota.nombre+'</option>');
				$('.idflota').append(newOption).trigger('change');



			 }


		}

	})
	return "completado";


}

function cargarDispositivo(){
	$('#modalEditarVehiculo .dispositivo').html('');
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

$(document).ready(function(){

  	cargarFlota();
	cargarDispositivo();


});

//EDITARR

$(".tablaVehiculos tbody").on("click", ".btnEditarVehiculo", function(){
  var idVehiculo = $(this).attr("idvehiculo");



  // console.log(idVehiculo);

  var datos = new FormData();
  datos.append("idVehiculo", idVehiculo);



  	$.ajax({

	    url:"ajax/vehiculos.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success: function(respuesta){



	    	$("#modalEditarVehiculo .editarIdVehiculo").val(respuesta["id"]);
	    	$("#modalEditarVehiculo .editarPlaca").val(respuesta["placa"]);
	    	$("#modalEditarVehiculo .editarMarca").val(respuesta["marca"]);
	    	$("#modalEditarVehiculo .editarModelo").val(respuesta["modelo"]);
	    	$("#modalEditarVehiculo .editarTipo").val(respuesta["tipo"]);
	    	$("#modalEditarVehiculo .editarYear").val(respuesta["year"]);
	    	$("#modalEditarVehiculo .editarColor").val(respuesta["color"]);
	    	$("#modalEditarVehiculo .editarMotor").val(respuesta["motor"]);
	    	$("#modalEditarVehiculo .editarSerie").val(respuesta["serie"]);

	    	$("#modalEditarVehiculo .editarSim").val(respuesta["sim"]);
	    	$("#modalEditarVehiculo .editarOperador").val(respuesta["operador"]);
	    	$("#modalEditarVehiculo .editarDescripcioVehiculo").val(respuesta["descripcion"]);
	    	$("#modalEditarVehiculo .editarDispositivo").val(respuesta["dispositivo"]);
	    	$("#modalEditarVehiculo .editaridgps").val(respuesta["idgps"]);
	    	//$("#modalEditarVehiculo .editaridflota").val(respuesta["flota"]).trigger("change");


			if ($("#modalEditarVehiculo .editaridflota").find("option[value='" + respuesta["flota"] + "']").length) {

				$('#modalEditarVehiculo .editaridflota').val(respuesta["flota"]).trigger('change');

			}
			if ($("#modalEditarVehiculo .dispositivo").find("option[value='" + respuesta["dispositivo"] + "']").length) {

				$('#modalEditarVehiculo .dispositivo').val(respuesta["dispositivo"]).trigger('change');
			}

			//






	    }

	})


})

// $(".modalAgregarVehiculo").on("click", function(){

// cargarFlota();
// cargarDispositivo();

// })

/**
 * GUARDAR FLOTA DESDE VEHICULOS

 */
 $(".guardarFlotaVehiculo").click(function(){

	if($(".nombreFlota").val() != ""){

		/*=============================================
		ALMACENAMOS TODOS LOS CAMPOS DE LA FLOTA
		=============================================*/
		var nombreFlota = $(".nombreFlota").val();
		var idcliente = $(".idcliente").val();
		var datosFlota = new FormData();
		datosFlota.append("nombreFlota", nombreFlota);
		datosFlota.append("idcliente", idcliente);

		$.ajax({
			url:"ajax/flotas.ajax.php",
			method: "POST",
			data: datosFlota,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){
				$(".idflota").html('');
				//cargarFlota();
				$('#modalAgregarFlota').modal('hide');
				$('#modalAgregarVehiculo').modal('hide');
				//limpiarModalCliente();

			}

		})

	}



 })



 /*=============================================
REVISAR SIM EXISTENTE
=============================================*/
$(document).on("keyup", ".comprobarSim", function(){

	$(".AlertaSim").remove();

	var numeroSim = $(this).val();
	if (numeroSim != "") {

		var datos = new FormData();
		datos.append("numeroSim", numeroSim);

		$.ajax({
		    url:"ajax/vehiculos.ajax.php",
		    method:"POST",
		    data: datos,
		    cache: false,
		    contentType: false,
		    processData: false,
		    dataType: "json",
		    success:function(respuesta){

		    	console.log("respuesta", respuesta);

		    	if(respuesta){

		    		$(".addAlert").append('<p class="AlertaSim warning" style="font-size: 13px; color: red">Numero '+respuesta["sim"]+' registrado en la placa '+respuesta["placa"]+'</p>')
		    		$(".comprobarSim").val("");
		    	}

		    }

		  })


	}


});
