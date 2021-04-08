/*=============================================
CARGAR LA TABLA DINÁMICA DE CONTRATOS
=============================================*/

// $.ajax({
//
// 	url:"ajax/tablaVehiculosCont.ajax.php",
// 	success:function(respuesta){
//
// 		console.log("respuesta", respuesta);
//
// 	}
//
// })


$(".tablaContratos").DataTable({
	 "ajax": "ajax/tablaContratos.ajax.php",
	 "deferRender": true,
	 "retrieve": true,
	 "processing": true,

	 "initComplete": function(settings, json) {
    $('input[type="checkbox"].caracteristicas, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    });
	  },
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



$(".tablaAddVehiculoContratos").DataTable({
	 "ajax": "ajax/tablaVehiculosCont.ajax.php",
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


// CARGAR Cliente
//
function cargarClienteContrato(){
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

				if(cliente.tipo_documento == "RUC"){

					$(".idcliente").append('<option value="'+cliente.id+'">'+cliente.nombre+'</option>');


				}else{

					$(".idcliente").append('<option value="'+cliente.id+'">'+cliente.nombre+" "+cliente.apellido+'</option>');
				}




			}


		}

	})

}
/**

GUADAR CONTRATO

**/
$(".guardarContrato").click(function(){


	var cliente = $(".idcliente ").val();
	var fecha = $(".fechaContrato ").val();
	var plan = $(".planContrato ").val();
	var ciudad = $(".ciudad ").val();
	var sello = $(".sello").val();
	var fondo = $(".fondo").val();

	// console.log(sello);
	// console.log(fondo);

	if (cliente != "" && fecha != "" && ciudad != "") {

	var datosContrato = new FormData($(".formularioContrato")[0]);

	//console.log(datosContrato);
		$.ajax({
			url:"ajax/contratos.ajax.php",
			method: "POST",
			data: datosContrato,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){


				//console.log(respuesta);

				if(respuesta != null){
					swal({
							  type: "success",
							  title: "El contrato ha sido guardado correctamente",
							  showConfirmButton: true,
							  confirmButtonText: "Cerrar"
							  }).then(function(result){
							  	console.log(result.value);
								if (result.value) {

								window.location = "contratos";

								}
							})
				}else{

					swal({
						  title: "¡ERROR!",
						  text: "¡Ha ocurrido un problema al guadar!",
						  type:"error",
						  preConfirm: function() {

						    window.location = "contratos";
						  }
						})
				}

			}

		})

	}else{

		swal({
			  title: "¡ERROR!",
			  text: "¡Deber rellenar los campos obligatios!",
			  type:"error",
			  // preConfirm: function() {

			  //   window.location = "Ventas";
			  // }
			})
	}


})
































/**
 * GUARDAR CLIENTE DESDE VENTAS

 */
 $(".guardarClienteContrato").click(function(){

	/*=============================================
	PREGUNTAMOS SI LOS CAMPOS OBLIGATORIOS ESTÁN LLENOS
	=============================================*/

	if($(".numDocumento").val() != ""){

		/*=============================================
		ALMACENAMOS TODOS LOS CAMPOS DE ClienteR
		=============================================*/
		var tipoCliente = $(".modalAgregarCliente .seleccionarTipoPersona").val();
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
			datosCliente.append("apellidoPersona", "");
			datosCliente.append("guardarPersona", 1);
			datosCliente.append("tipoDocumento", tipoDocumento);
			datosCliente.append("numDocumento", numDocumento);
			datosCliente.append("direccionPersona", direccionCliente);
			datosCliente.append("telefonoPersona", telefonoCliente);
			datosCliente.append("emailPersona", emailCliente);


		}else{

			datosCliente.append("tipo", "Cliente");
			datosCliente.append("nombrePersona", nombreClienteN);
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
				$(".idcliente").html('');
				cargarClienteContrato();
				$('#modalAgregarCliente').modal('hide');
				limpiarModalCliente();

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

  /**
 * CLIENTE
 */



$(".modalAgregarCliente .seleccionarTipoPersona").change(function(){

	tipo = $(this).val();

	if(tipo == "natural"){

		$(".modalAgregarCliente .personaNatural").show();
		$(".modalAgregarCliente .personaJuridica").hide();

	}else{

		$(".modalAgregarCliente .personaJuridica").show();
		$(".modalAgregarCliente .personaNatural").hide();

	}
})

$(".modalAgregarCliente .tipoDocumento").change(function(){

	tipoDocumento = $(this).val();
	if (tipoDocumento == "DNI") {

		$(".modalAgregarCliente .numDocumento").attr("maxlength", "8")


	}

	if (tipoDocumento == "RUC") {
		$(".modalAgregarCliente .numDocumento").attr("maxlength", "12")
	}


})

/**
 * ICHECK
 */


$(document).ready(function(){
    $('input[type="checkbox"].caracteristicas, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
});
/**
 * MOSTRAR O CANCELAR FORMULARIO
 */

$(".btnAgregarContrato").on("click", function(){

	$(".agregarContratos").show();
	$(".listaContratos").hide();
	$(".btnAgregarCliente").show();
	$(".tipo_comprobante").val("Trujillo");
	 $('.select2').select2()
		limpiar();
		$(".guardarContrato").hide();
		$(".btnCancelar").show();
		detalles=0;
		$("#btnAgregarVehiculo").show();
		cargarClienteContrato();
		localStorage.removeItem("listaVehiculosContrato");
})

$(".btnCancelar").on("click", function(){

	$(".agregarContratos").hide();
	$(".listaContratos").show();
	limpiar();


})

/**
 * ACTUALIZAR CARACTERISTICAS
 */
$(".tablaContratos tbody").on("ifClicked", "#sello", function(sello){

  	var estado = sello.target.checked;

  	var idContrato = sello.target.attributes.idcontrato.nodeValue;

  	ActualizarCaracteristicas("sello", estado, idContrato);



});

$(".tablaContratos tbody").on("ifClicked", "#fondo", function(fondo){

  	var estado = fondo.target.checked;
  	var idContrato = fondo.target.attributes.idcontrato.nodeValue;

  	ActualizarCaracteristicas("fondo", estado, idContrato);
});


$(".tablaContratos tbody").on("click", "#sello", function(sello){

  	var estado = !sello.target.checked;

  	var idContrato = sello.target.attributes.idcontrato.nodeValue;

  	ActualizarCaracteristicas("sello", estado, idContrato);



});

$(".tablaContratos tbody").on("click", "#fondo", function(fondo){

  	var estado = !fondo.target.checked;
  	var idContrato = fondo.target.attributes.idcontrato.nodeValue;

  	ActualizarCaracteristicas("fondo", estado, idContrato);
});

function ActualizarCaracteristicas(caract, estado, idContrato){

	//console.log(caract +" "+ estado);

	if (estado == true) {

		var estadoCaract = 0;

	}else{

		var estadoCaract = 1;
	}

	var datos = new FormData();
	datos.append("caracteristica", caract);
  	datos.append("estado", estadoCaract);
  	datos.append("idContratoCaract", idContrato);

  	$.ajax({

  		 url:"ajax/contratos.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){

      		//console.log(respuesta);


      	}

  	});
}

/**
 * ACTIVAR / DESACTIVAR CONTRATO
 */

$(".tablaContratos tbody").on("click", ".btnActivar", function(){

	var idContrato = $(this).attr("idContrato");
	var estadoContrato = $(this).attr("estadoContrato");

	var datos = new FormData();
 	datos.append("activarId", idContrato);
  	datos.append("activarContrato", estadoContrato);

  	$.ajax({

  		 url:"ajax/contratos.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){

      		console.log(respuesta);


      	}

  	});

  	if(estadoContrato == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoContrato',1);

  		$(".idContrato"+idContrato).removeAttr("disabled");
  		iziToast.show({
              title: '<h4><label class="label-danger">CONTRATO DESACTIVADO</label></h4>',
              message: '<br>Se ha desactivado, la categoria no se mostrará',
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
  		$(this).attr('estadoContrato',0);
  		$(".idContrato"+idContrato).attr("disabled", "disabled");
  		iziToast.show({
              title: '<h4><label class="label-success">CONTRATO ACTIVADO</label></h4>',
              message: '<br>Se ha activado, la categoria se mostrará',
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




/**
 * AÑADIR VEHICULO A LA LISTA
 */


function agregarVehiculo(idvehiculo){
	var plan=30;
	var flota = "Anita";
 	var datos = new FormData();
 	datos.append("idVehiculo", idvehiculo);

  	$.ajax({

	    url:"ajax/vehiculos.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success: function(respuesta){
			if(localStorage.getItem("listaVehiculosContrato") == null){

				listado = [];

			}else{

				var listaVehiculosContrato = JSON.parse(localStorage.getItem("listaVehiculosContrato"));

				for(var i = 0; i < listaVehiculosContrato.length; i++){

					if(listaVehiculosContrato[i]["idvehiculo"] == idvehiculo){

						swal({
						  title: "El Vehichulo ya esta agregado",
						  text: "",
						  type: "warning",
						  showCancelButton: false,
						  confirmButtonColor: "#DD6B55",
						  confirmButtonText: "¡Volver!",
						})

						return;

					}

				}

				//listado.concat(localStorage.getItem("listaVehiculosContrato"));
			}

			listado.push({"idvehiculo":idvehiculo});
			localStorage.setItem("listaVehiculosContrato", JSON.stringify(listado));


			/**
			 * AGREGAR VEHICULO
			 */
		 	if (idvehiculo != "") {

			    	var fila='<tr class="filas" id="fila'+cont+'" idvehiculo="'+idvehiculo+'">'+
			    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleVehiculos('+cont+')">X</button></td>'+
			    	'<td><input type="hidden" class="idvehiculo" idvehiculo="'+idvehiculo+'" name="idvehiculo[]" value="'+idvehiculo+'">'+respuesta["placa"]+'</td>'+
			    	//'<td><input style="width: 120px;" type="text" class="flota" name="flota[]" id="flota[]" value="'+flota+'"></td>'+
			    	'<td><input style="width: 120px;" type="number" step="any" class="plan" name="plan[]" value="'+plan+'"></td>'+
			    	'</tr>';
			    	cont++;
			    	detalles=detalles+1;
			    	$('#detallesvehiculos').append(fila);
			    	evaluar();

	    	}

	    }

	})








}

function evaluar(){
	if (detalles>0)
	{
	  $(".guardarContrato").show();
	}
	else
	{
	  $(".guardarContrato").hide();
	  cont=0;
	}
}


function eliminarDetalleVehiculos(indice){
	$("#fila" + indice).remove();
	detalles=detalles-1;
	evaluar();



	var idVehiculo = $(".filas");


	listaVehiculo = [];

	if(idVehiculo.length != 0){

		for(var i = 0; i < idVehiculo.length; i++){

			var idVehiculoArray = $(idVehiculo[i]).attr("idvehiculo");
			//console.log(idVehiculoArray);

			listaVehiculo.push({"idVehiculo":idVehiculoArray});
		}

		localStorage.setItem("listaVehiculosContrato",JSON.stringify(listaVehiculo));


	}
}

//Función limpiar
function limpiar()
{
	$(".filas").remove();

	//Obtenemos la fecha actual
	var nowc = new Date();
	var dayc = ("0" + nowc.getDate()).slice(-2);
	var monthc = ("0" + (nowc.getMonth() + 1)).slice(-2);
	var todayc = (monthc)+"/"+(dayc)+"/"+nowc.getFullYear();
    $('.fechaContrato').val(todayc);

    //Marcamos el primer tipo_documento
    $(".tipo_comprobante").val("Boleta");
}



/*=============================================
EDITAR CONTRATO
=============================================*/

$(".tablaContratos tbody").on("click", ".btnEditarContrato", function(){

	var idContrato = $(this).attr("idContrato");

	//console.log(idContrato);

	var datos = new FormData();
	datos.append("idContrato", idContrato);

	$.ajax({

		url:"ajax/contratos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){


			$("#modalEditarContrato .editarIdContrato").val(respuesta["id"]);

			//$("#modalEditarContrato .editarIdContrato").val(respuesta["idcliente"]);

			$("#modalEditarContrato .editarFechaContrato").val(respuesta["fecha"]);
			$("#modalEditarContrato .contratoEditarciudad").val(respuesta["ciudad"]);

			var datos1 = new FormData();
			datos1.append("idPersona", respuesta["idcliente"]);

			$.ajax({

				url:"ajax/persona.ajax.php",
				method: "POST",
				data: datos1,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(cliente){

					$("#modalEditarContrato .editarClienteContrato").val(cliente["nombre"]);


				}

			})




		}

	})



})


/*=============================================
ELIMINAR CONTRATO
=============================================*/
$(".tablaContratos tbody").on("click", ".btnEliminarContrato", function(){

	var idContrato = $(this).attr("idContrato");

	console.log(idContrato);

  	swal({
    	title: '¿Está seguro de borrar el contrato?',
    	text: "¡Si no lo está puede cancelar la accíón!",
    	type: 'warning',
    	showCancelButton: true,
    	confirmButtonColor: '#3085d6',
      	cancelButtonColor: '#d33',
      	cancelButtonText: 'Cancelar',
      	confirmButtonText: 'Si, borrar contrato!'
	 }).then(function(result){

    	if(result.value){

      	window.location = "index.php?ruta=contratos&idContrato="+idContrato;

    	}

  	})

})
