/*=============================================
CARGAR LA TABLA DINÁMICA DE CATEGORÍAS
=============================================*/

// $.ajax({

// 	url:"ajax/tablaVentas.ajax.php",
// 	success:function(respuesta){
		
// 		console.log(respuesta);

// 	}

// })

$(".tablaVentas").DataTable({
	 "ajax": "ajax/tablaVentas.ajax.php",
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

$(".tablaAddArticulosVentas").DataTable({
	 "ajax": "ajax/tablaAddArticulos.ajax.php?tipo=Ventas",
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
function cargarCliente(){
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

		//console.log(respuesta);

			var datosCliente = JSON.parse(respuesta);

			datosCliente.forEach(forEachProveedor);

			function forEachProveedor(cliente, index){
				
				if (cliente.tipo_documento == "RUC") {

					$(".idclienteVenta").append('<option value="'+cliente.id+'">'+cliente.nombre+'</option>');

				}else{


					if (cliente.apellido == null) {

						$(".idclienteVenta").append('<option value="'+cliente.id+'">'+cliente.nombre+'</option>');

					}else{

						$(".idclienteVenta").append('<option value="'+cliente.id+'">'+cliente.nombre+' '+cliente.apellido+'</option>');

					}


				}


				
			}


		}

	})

}


/**
 * GUARDAR CLIENTE DESDE VENTAS

 */
 $(".guardarClienteVenta").click(function(){

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
			datosCliente.append("nombrePersona", null);
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
				$(".idclienteVenta").html('');
				cargarCliente();
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
 * VENTAS
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
 * MOSTRAR O CANCELAR FORMULARIO
 */

$(".btnAgregarVenta").on("click", function(){
	//console.log("agregar");
   	cargarCliente();
	$(".agregarVentas").show();
	$(".listaVentas").hide();
	$(".btnAgregarCliente").show();
	 $('.select2').select2()
		limpiarFormVenta();
		$(".guardarVenta").hide();
		$(".btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").show();
		
		localStorage.removeItem("listaProductosVenta");
})

$(".btnCancelar").on("click", function(){

	$(".agregarVentas").hide();
	$(".listaVentas").show();


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


function agregarDetalleVentas(idarticulo, stock, precio){

  	var cantidad=1;
    var precio_venta = precio;
    var descuento=0;
	//var listaProductosVenta = JSON.parse(localStorage.getItem("listaProductosVenta"));

    //var articulo = $(".agregarArticulo").attr("articulo");
    var articulo = document.getElementsByName(idarticulo);

	for (var i = 0; i < articulo.length; i++) {

		var nameArt = articulo[i];

		var nProducto = nameArt.value;
		// var idp = $(articulo[i]).attr("value");

		 //console.log(nProducto);


	}
	if  (nProducto){

		if(localStorage.getItem("listaProductosVenta") == null){

			listado = [];

		}else{

			var listaProductosVenta = JSON.parse(localStorage.getItem("listaProductosVenta"));

			for(var i = 0; i < listaProductosVenta.length; i++){

				if(listaProductosVenta[i]["idProducto"] == idarticulo){

					swal({
					  title: "El producto ya está agregado",
					  text: "",
					  type: "warning",
					  showCancelButton: false,
					  confirmButtonColor: "#DD6B55",
					  confirmButtonText: "¡Volver!",
					})

					return;

				}

			}

			//listado.concat(localStorage.getItem("listaProductosVenta"));
		}

		

		if (stock >= 1) {
			listado.push({"idProducto":idarticulo});
			localStorage.setItem("listaProductosVenta", JSON.stringify(listado));
		}
		

		/**
		 * AGREGAR PRODUCTO
		 */
	 	if (idarticulo != "") {

	    	if (stock >= 1) {

				var subtotal=(cantidad.toFixed(2)*precio_venta.toFixed(2))-descuento;
		    	var fila='<tr class="filas" id="fila'+cont+'" idarticulo="'+idarticulo+'">'+
		    	'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleVenta('+cont+')">X</button></td>'+
		    	'<td><input type="hidden" class="idarticulo" idarticulo="'+idarticulo+'" name="idarticulo[]" value="'+idarticulo+'">'+nProducto+'</td>'+
		    	'<td><input style="width: 50px;" type="number" class="cantidad" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
		    	'<td><input style="width: 120px;" type="number" step="any" class="precio_venta" name="precio_venta[]" value="'+precio_venta+'"></td>'+
		    	'<td><input style="width: 120px;" type="number" step="any" class="descuento" name="descuento[]" value="'+descuento+'"></td>'+
		    	'<td><span name="subtotal" class="subtotal" id="subtotal'+cont+'">'+subtotal.toFixed(2)+'</span></td>'+
		    	'</tr>';
		    	cont++;
		    	detalles=detalles+1;

		    	$('#detalles').append(fila);
		    	modificarSubototalesVenta();
		    	evaluarGuardarVenta();

	    	}else{

	    		//console.log('no hay stock')
    		}
    	}

	}

}


/**
 * MODIFICAR SUBTOTAL AL CAMBIAR CANTIDAD
 */

$(document).on("change", ".tblListadoArcticulosVenta .cantidad", function(){

	modificarSubototalesVenta();

})
/**
 * MODIFICAR SUBTOTAL AL CAMBIAR DESCUENTO
 */

$(document).on("change", ".tblListadoArcticulosVenta .descuento", function(){

	modificarSubototalesVenta();

})

/**
 * MODIFICAR SUBTOTAL AL CAMBIAR DIVISA
 */

$(document).on("change", ".style_form formularioVenta .divisa", function(){

	modificarSubototalesVenta();

})
/**
 * MODIFICAR SUBTOTAL AL CAMBIAR precio
 */
$(document).on("change", ".tblListadoArcticulosVenta .precio_venta", function(){

	modificarSubototalesVenta();

})
/**
 * LIMPIAR AL CANCELAR
 */
$(document).on("click", ".btnCancelar", function(){

limpiarFormVenta();

})


function modificarSubototalesVenta()
{
	var cant = document.getElementsByName("cantidad[]");
	var prec = document.getElementsByName("precio_venta[]");
	var desc = document.getElementsByName("descuento[]");
	var sub = document.getElementsByName("subtotal");



for (var i = 0; i <cant.length; i++) {
	var inpC=cant[i];
	var inpP=prec[i];
	var inpD=desc[i];
	var inpS=sub[i];

	inpS.value=(inpC.value * inpP.value)-inpD.value;
	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
}
calcularTotalesVenta();

}

function calcularTotalesVenta(){
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
$("#total_venta").val(total.toFixed(2));
evaluarGuardarVenta();
}

function evaluarGuardarVenta(){

	//console.log(detalles);
	if (detalles>0)
	{
	  $(".guardarVenta").show();
	}
	else
	{
	  $(".guardarVenta").hide(); 
	  cont=0;
	}
}

function eliminarDetalleVenta(indice){
	$("#fila" + indice).remove();
	calcularTotalesVenta();
	detalles=detalles-1;
	evaluarGuardarVenta();

	

	var idProducto = $(".filas");


	listaCarrito = [];

	if(idProducto.length != 0){

		for(var i = 0; i < idProducto.length; i++){

			var idProductoArray = $(idProducto[i]).attr("idarticulo");
			//console.log(idProductoArray);

			listaCarrito.push({"idProducto":idProductoArray});
		}

		localStorage.setItem("listaProductosVenta",JSON.stringify(listaCarrito));


	}
}


//Función limpiar
function limpiarFormVenta()
{
	$(".serie_comprobante").val("");
	$(".num_comprobante").val("");
	$(".impuesto").val("0");

	$(".total_venta").val("");
	$(".filas").remove();
	$(".total").html("0");
	
	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('.fecha').val(today);

    //Marcamos el primer tipo_documento
    $(".tipo_comprobante").val("Boleta");
}



/*=============================================
GUARDAR Venta
=============================================*/
$(".guardarVenta").click(function(){

/**
 * DATOS GENERALES
 */

 var cliente = $(".idclienteVenta").val();
 var fecha = $(".fecha").val();
 var tipo_comprobante = $(".tipo_comprobante").val();
 var divisa_Venta = $(".divisa").val();
 var serie_comprobante = $(".serie_comprobante").val();
 var numero_comprobante = $(".num_comprobante").val();
 var impuesto_Venta = $(".impuesto").val();


 var datosVenta = new FormData($(".formularioVenta")[0]);

/**
 * ENVIAR POR AJAX
 *
 */

	if (cliente != "" && tipo_comprobante != "" && divisa_Venta != "" && serie_comprobante != "" && numero_comprobante != "") {

		$.ajax({
			url:"ajax/ventas.ajax.php",
			method: "POST",
			data: datosVenta,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){


				console.log(respuesta);
				
				if(respuesta != null){

					swal({
					  type: "success",
					  title: "La Venta ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "ventas";

						}
					})
				}else{

					swal({
						  title: "¡ERROR!",
						  text: "¡Ha ocurrido un problema al guadar!",
						  type:"error",
						  preConfirm: function() {

						    window.location = "ventas";
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
MOSTRAR Venta
=============================================*/

 function mostrarVenta(idVenta){

 	var datos = new FormData();
 	datos.append("idVenta", idVenta);

	$.ajax({
		url:"ajax/ventas.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){

			var Venta = JSON.parse(respuesta);
			
			if(respuesta != null){

				if (Venta.idcliente != null) {

					datos.append("idPersona", Venta.idcliente);

					$.ajax({
						url:"ajax/persona.ajax.php",
						method: "POST",
						data: datos,
						cache: false,
						contentType: false,
						processData: false,
						dataType: "json",
						success: function(respuesta){

							$(".idclienteVenta").html('<option value="'+Venta.idcliente+'">'+respuesta["nombre"]+'</option>');

						}
					})
				}

				


				$(".btnAgregarCliente").hide();
				$(".tipo_comprobante").val(Venta.tipo_comprobante);
				$(".serie_comprobante").val(Venta.serie_comprobante);
				$(".divisa").val(Venta.divisa);
				$(".num_comprobante").val(Venta.num_comprobante);
				$("#fecha_hora").val(Venta.fecha_hora.substr(0, 10));
				$(".impuesto").val(Venta.impuesto);
				$(".idVenta").val(Venta.idVenta);

				//Ocultar y mostrar los botones
				$(".guardarVenta").hide();
				$(".btnCancelar").show();
				$("#btnAgregarArt").hide();
				$(".agregarVentas").show();
				$(".listaVentas").hide();

				var datosVenta = new FormData();
					datosVenta.append("idVenta_detalle", idVenta);
				$.ajax({
					url:"ajax/ventas.ajax.php",
					method: "POST",
					data: datosVenta,
					cache: false,
					contentType: false,
					processData: false,
					success: function(detalle){

						$(".tblListadoArcticulosVenta").html(detalle);


					}
				})

			}else{

				swal({
					  title: "¡ERROR!",
					  text: "¡Ha ocurrido un problema al cargar!",
					  type:"error",
					  preConfirm: function() {

					    //window.location = "Ventas";
					  }
					})
			}

		}

	})

}
/**
 * ANULAR Venta
 */
$(".tablaVentas tbody").on("click", ".btnEliminarVenta", function(){

	var idanular = $(this).attr("idVenta");
	

	var datos = new FormData();
 	datos.append("idanular", idanular);

  	$.ajax({

  		url:"ajax/ventas.ajax.php",
  		method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 

      		if (respuesta != 0) {
				$(this).hide();
				$(".labelActivar"+idanular).removeClass('label-success');
				$(".labelActivar"+idanular).addClass('label-danger');
				$(".labelActivar"+idanular).html('Desactivado');
	      		iziToast.show({
	              title: '<h4>Venta ANULADO</h4>',
	              message: '<br>Se ha anulado la Venta',
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

      	} 	 

  	});
})

