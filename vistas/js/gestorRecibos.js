
// $.ajax({

// 	url:"ajax/tablaRecibos.ajax.php",
// 	success:function(respuesta){
		
// 		console.log(respuesta);

// 	}

// })

var tablaRecibos = $(".tablaRecibos").DataTable({
	 "ajax": "ajax/tablaRecibos.ajax.php",
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


///FUNCIONES PARA RECIBOS
/**
 * MOSTRAR O CANCELAR FORMULARIO
 */

$(".btnAgregarRecibo").on("click", function(){
	//console.log("agregar");
   	cargarCliente();
	$(".agregarRecibos").show();
	$(".listaRecibos").hide();
	$(".btnAgregarCliente").show();
	 $('.select2').select2()
		limpiarFormRecibo();
		$(".guardarRecibo").hide();
		$(".btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").show();
		
		localStorage.removeItem("listaProductosRecibo");
})

$(".btnCancelar").on("click", function(){

	$(".agregarRecibos").hide();
	$(".listaRecibos").show();


})
//Declaración de variables necesarias para trabajar con las ventas y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;

$(".tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto()
  {
  	var tipo_comprobante=$(".tipo_comprobante option:selected").text();
  	if (tipo_comprobante=='Factura + IGV' || tipo_comprobante=='Factura IGV INC')
    {
        $(".impuesto").val(impuesto); 
    }
    else
    {
        $(".impuesto").val("0"); 
    }
  }

/**
 * AÑADIR PRODUCTO A LA LISTA
 */


function agregarDetalleRecibos(){

  	var cantidad=1;
    var precio = 0;

	var subtotal=(cantidad.toFixed(2)*precio.toFixed(2));

	var fila='<tr class="filas" id="fila'+cont+'">'+
	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleRecibo('+cont+')">X</button></td>'+
	'<td><input required style="width: 90px;" type="number" min="1" class="form-control cantidad" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
	'<td><input type="text" class="form-control item" item="" name="item[]" ></td>'+
	'<td><input style="width: 120px;" type="number" min="1" step="any" class="form-control precio" name="precio[]" value="'+precio+'"></td>'+
	'<td><span name="subtotal" class="subtotal" id="subtotal'+cont+'">'+subtotal.toFixed(2)+'</span></td>'+
	'</tr>';
	cont++;
	detalles=detalles+1;

	$('#detalles').append(fila);
	modificarSubototalesRecibo();
	evaluarGuardarRecibo();

}


/**
 * MODIFICAR SUBTOTAL AL CAMBIAR CANTIDAD
 */

$(document).on("change", ".tblListadoArcticulosRecibo .cantidad", function(){

	modificarSubototalesRecibo();

})
//editar
$(document).on("change", ".tblDetalleRecibo .cantidadEditar", function(){

	modificarSubototalesEditarRecibo();

})
/**
 * MODIFICAR SUBTOTAL AL CAMBIAR DIVISA
 */

$(document).on("change", ".formularioRecibo .divisa", function(){

	modificarSubototalesRecibo();

})

//editar
$(document).on("change", "#modalEditarRecibo .divisaEditar", function(){

	modificarSubototalesEditarRecibo();
	calcularTotalesEditarRecibo();

})
/**
 * MODIFICAR SUBTOTAL AL CAMBIAR precio
 */
$(document).on("change", ".tblListadoArcticulosRecibo .precio", function(){

	modificarSubototalesRecibo();

})
//editar

$(document).on("change", ".tblDetalleRecibo .precioEditar", function(){

	modificarSubototalesEditarRecibo();

})

/**
 * LIMPIAR AL CANCELAR
 */
$(document).on("click", ".btnCancelar", function(){

limpiarFormRecibo();

})


function modificarSubototalesRecibo()
{
	var cant = document.getElementsByName("cantidad[]");
	var prec = document.getElementsByName("precio[]");
	var sub = document.getElementsByName("subtotal");



for (var i = 0; i <cant.length; i++) {
	var inpC=cant[i];
	var inpP=prec[i];
	var inpS=sub[i];

	inpS.value=(inpC.value * inpP.value);
	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
}
calcularTotalesRecibo();

}

//AL EDITAR
function modificarSubototalesEditarRecibo()
{
	var cant = document.getElementsByName("cantidadEditar[]");
	var prec = document.getElementsByName("precioEditar[]");
	var sub = document.getElementsByName("subtotalEditar");



	for (var i = 0; i <cant.length; i++) {
		var inpC=cant[i];
		var inpP=prec[i];
		var inpS=sub[i];

		inpS.value=(inpC.value * inpP.value);
		document.getElementsByName("subtotalEditar")[i].innerHTML = inpS.value;
	}


	calcularTotalesEditarRecibo();

}

function calcularTotalesRecibo(){
	var sub = document.getElementsByName("subtotal");

	/**
	 * MOSTRAS SIMBOLO SEGUN DIVISA
	 */

	var divisa = $(".divisa option:selected").text();

	if (divisa == "PEN") {

		var simbolo = "S/.";

	}else if(divisa == "USD"){

		var simbolo = "$";

	}else if(divisa == "EUR"){

		var simbolo = "€";

	}else{

		var simbolo = "MXN";
	}

	var total = 0.0;

	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
	}
	$("#total").html(simbolo + " "+ total.toFixed(2));
	$("#total_recibo").val(total.toFixed(2));
	evaluarGuardarRecibo();

}

function calcularTotalesEditarRecibo(){

	var sub = document.getElementsByName("subtotalEditar");


	/**
	 * MOSTRAS SIMBOLO SEGUN DIVISA
	 */

	var divisa = $(".divisaEditar option:selected").text();

	//console.log(divisa);

	if (divisa == "PEN") {

		var simbolo = "S/.";

	}else if(divisa == "USD"){

		var simbolo = "$";

	}else if(divisa == "EUR"){

		var simbolo = "€";

	}else{

		var simbolo = "MXN";
	}

	var total = 0.0;

	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotalEditar")[i].value;
	}

	$("#totalEditar").html(simbolo + " "+ total.toFixed(2));
	$("#total_reciboEditar").val(total.toFixed(2));


}

function evaluarGuardarRecibo(){

	//console.log(detalles);
	if (detalles>0)
	{
	  $(".guardarRecibo").show();
	}
	else
	{
	  $(".guardarRecibo").hide(); 
	  cont=0;
	}
}

function eliminarDetalleRecibo(indice){
	$("#fila" + indice).remove();
	calcularTotalesRecibo();
	detalles=detalles-1;
	evaluarGuardarRecibo();

}


//Función limpiar
function limpiarFormRecibo()
{
	$(".num_comprobante").val("");
	$(".impuesto").val("0");

	$(".total").val("");
	$(".filas").remove();
	$(".total").html("0");
	
	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('.fecha').val(today);

}



function autocompleteEmpresa(){

    var availableTags = $(".autocomplete").val();
    var names = availableTags.split(",");
    var obj = JSON.parse(availableTags);
    //console.log(names);

    var anames = $.map(obj, function (value, key) { return { value: value, data: key }; });


    // Initialize ajax autocomplete:
    $('#autocomplete-ajax').devbridgeAutocomplete({
        // serviceUrl: '/autosuggest/service/url',
        lookup: anames,
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
        onSelect: function(suggestion) {
            $('#selction-ajax').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
            $(".nameEmpresa").val(suggestion.data);

        },
        onHint: function (hint) {
            $('#autocomplete-ajax-x').val(hint);
        },
        onInvalidateSelection: function() {
            $('#selction-ajax').html('You selected: none');
        }
    });
    // Initialize ajax autocomplete:
    $('#autocomplete-ajax-linea').devbridgeAutocomplete({
        // serviceUrl: '/autosuggest/service/url',
        lookup: anames,
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
        onSelect: function(suggestion) {
            $('#selction-ajax').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
            $(".nameEmpresa").val(suggestion.data);

        },
        onHint: function (hint) {
            $('#autocomplete-ajax-x').val(hint);
        },
        onInvalidateSelection: function() {
            $('#selction-ajax').html('You selected: none');
        }
    });
}

$(".btnAgregarRecibo").on("click", function(){

 autocompleteEmpresa();
});



/*=============================================
GUARDAR RECIBO
=============================================*/
$(".guardarRecibo").click(function(){

/**
 * DATOS GENERALES
 */

 var cliente = $(".empresa").val();
 var fecha = $(".fecha").val();
 var divisa_Venta = $(".divisa").val();
 var numero_comprobante = $(".num_comprobante").val();


 var datosRecibo = new FormData($(".formularioRecibo")[0]);

/**
 * ENVIAR POR AJAX
 *
 */

	if (cliente != ""  && divisa_Venta != "" && numero_comprobante != "") {

		$.ajax({
			url:"ajax/recibo.ajax.php",
			method: "POST",
			data: datosRecibo,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){


				console.log(respuesta);
				
				if(respuesta != null){

					swal({
					  type: "success",
					  title: "El recibo ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "recibo";

						}
					})
				}else{

					swal({
						  title: "¡ERROR!",
						  text: "¡Ha ocurrido un problema al guadar!",
						  type:"error",
						  preConfirm: function() {

						    window.location = "recibo";
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



/*=============================================
ELIMINAR RECIBO
=============================================*/
$(".tablaRecibos tbody").on("click", ".btnEliminarRecibo ", function(){

	var idRecibo = $(this).attr("idRecibo");

  	swal({
    	title: '¿Está seguro de borrar el recibo?',
    	text: "¡Si no lo está puede cancelar la accíón!",
    	type: 'warning',
    	showCancelButton: true,
    	confirmButtonColor: '#3085d6',
      	cancelButtonColor: '#d33',
      	cancelButtonText: 'Cancelar',
      	confirmButtonText: 'Si, borrar recibo!'
	 }).then(function(result){

    	if(result.value){

      	window.location = "index.php?ruta=recibo&idRecibo="+idRecibo;

    	}

  	})

})

/*=============================================
EDITAR RECIBO
=============================================*/

$(".tablaRecibos tbody").on("click", ".btnEditarRecibo", function(){

	var idRecibo = $(this).attr("idRecibo");

	var datos = new FormData();

	datos.append("idReciboverEditar", idRecibo);

	$.ajax({
		url:"ajax/recibo.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){


			var Recibo = JSON.parse(respuesta);


			$("#modalEditarRecibo .idReciboEditar").val(Recibo.id);
			$("#modalEditarRecibo .nEmpresa").val(Recibo.empresa);
			$("#modalEditarRecibo .fechaEditar").val(Recibo.fecha);
			$("#modalEditarRecibo .divisaEditar").val(Recibo.divisa);
			$("#modalEditarRecibo .num_reciboEditar").val(Recibo.num_recibo);
			$("#modalEditarRecibo .tipoPagoEditar").val(Recibo.tipoPago);
			$("#modalEditarRecibo .totalEditar").html(Recibo.total_recibo);
			$("#modalEditarRecibo .total_reciboEditar").val(Recibo.total_recibo);
			$("#modalEditarRecibo .clienteIdEditar").val(Recibo.idcliente);
			
			
			
			if(respuesta != null){

				if (Recibo.idcliente != null) {

					datos.append("idPersona", Recibo.idcliente);

					$.ajax({
						url:"ajax/persona.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){

							//$(".idclienteVenta").html('<option value="'+Recibo.idcliente+'">'+respuesta["nombre"]+'</option>');

							if (respuesta.apellido == null) {

								$("#modalEditarRecibo .clienteEditar").val(respuesta.nombre)

							}else{

								$("#modalEditarRecibo .clienteEditar").val(respuesta.nombre +" "+respuesta.apellido)
							}
							

						}
					})
				}

				

				var datosRecibo = new FormData();
				datosRecibo.append("idRecibo_detalle", idRecibo);

				$.ajax({
					url:"ajax/recibo.ajax.php",
					method: "POST",
					data: datosRecibo,
					cache: false,
					contentType: false,
					processData: false,
					success: function(detalle){

						$(".tblDetalleRecibo").html(detalle);


					}
				})

			}else{

				swal({
					  title: "¡ERROR!",
					  text: "¡Ha ocurrido un problema al cargar!",
					  type:"error",
					  preConfirm: function() {

					    window.location = "recibo";
					  }
					})
			}

		}

	})



})




/*=============================================
EDITAR RECIBO MEDIANTE MODAL
=============================================*/
$(".btnGuardarEditar").click(function(){

/**
 * DATOS GENERALES
 */

 var empresa = $(".nEmpresa").val();
 var cliente = $(".clienteEditar").val();
 var fecha = $(".fechaEditar").val();
 var divisa = $(".divisaEditar").val();
 var num_recibo = $(".num_reciboEditar").val();


 var datosEditarRecibo = new FormData($(".formularioEditarRecibo")[0]);

 //console.log(datosEditarRecibo);

/**
 * ENVIAR POR AJAX
 *
 */

	if (cliente != ""  && divisa != "" && num_recibo != "") {

		$.ajax({
			url:"ajax/recibo.ajax.php",
			method: "POST",
			data: datosEditarRecibo,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){


				console.log(respuesta);
				
				if(respuesta != null){

					swal({
					  type: "success",
					  title: "El recibo ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "recibo";

						}
					})
				}else{

					swal({
						  title: "¡ERROR!",
						  text: "¡Ha ocurrido un problema al guadar!",
						  type:"error",
						  preConfirm: function() {

						    window.location = "recibo";
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


$("#modalObtenerReporte").on("change", ".fechaReciboChange", function(){

	var fechaReciboInicio = $(".fechaReciboInicio").val();
	var fechaReciboFin = $(".fechaReciboFin").val();

	CargarReporte(fechaReciboInicio, fechaReciboFin);


})


$(".btnObtenerReporte").click(function(){

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day);
    $('.fechaReciboInicio').val(today);
    $('.fechaReciboFin').val(today);
    CargarReporte(today, today);

})

function CargarReporte(fechaReciboInicio, fechaReciboFin){




	var tablaReporteRecibo = $("#modalObtenerReporte .tablaReporteRecibo").DataTable({
		dom: 'Bfrtip', //Definimos Los elementos del control de tabla
		buttons: [
	        'copyHtml5',
	        'excelHtml5',
	        'csvHtml5',
	        'pdfHtml5'
		],
		 "ajax": "ajax/tablaReporteRecibo.ajax.php?fechaReciboInicio="+fechaReciboInicio+"&fechaReciboFin="+fechaReciboFin,
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

	tablaReporteRecibo.ajax.url("ajax/tablaReporteRecibo.ajax.php?fechaReciboInicio="+fechaReciboInicio+"&fechaReciboFin="+fechaReciboFin,).load();

}



$("#modalEditarRecibo").on("click", ".CambiarEstado", function(e){
	e.preventDefault();
	var estado = $(this).attr("estado");
	var idReciboEstado = $(".idReciboEditar").val();

	var datos = new FormData();

 	datos.append("idReciboEstado", idReciboEstado);
  	datos.append("activarRecibo", estado);
  	datos.append("item", "estado");




  	$.ajax({

  		 url:"ajax/recibo.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 
      		console.log(respuesta);

      		tablaRecibos.ajax.reload();
      	    

      	} 	 

  	});


  	if(estado == 0){
  		iziToast.show({
              title: '<h4><label class="label-danger">RECIBO MARCADO</label></h4>',
              message: '<br>Como "Cancelado"',
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
              title: '<h4><label class="label-warning">RECIBO MARCADO</label></h4>',
              message: '<br>Como "Por cobrar"',
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


$(".tablaRecibos tbody").on("click", ".btnActivar", function(){

	var idRecibo = $(this).attr("idRecibo");
	var estadoRecibo = $(this).attr("estadoRecibo");

	var datos = new FormData();
 	datos.append("idReciboEstado", idRecibo);
  	datos.append("activarRecibo", estadoRecibo);
  	datos.append("item", "anulado");

  	$.ajax({

  		 url:"ajax/recibo.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 

      		//console.log(respuesta);
      	    

      	} 	 

  	});

  	if(estadoRecibo == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Anulado');
  		$(this).attr('estadoRecibo',1);

  		iziToast.show({
              title: '<h4><label class="label-danger">RECIBO ANULADO</label></h4>',
              message: '<br>',
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
  		$(this).html('Aceptado');
  		$(this).attr('estadoRecibo',0);
  		iziToast.show({
              title: '<h4><label class="label-success">RECIBO ACEPTADO</label></h4>',
              message: '<br>',
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