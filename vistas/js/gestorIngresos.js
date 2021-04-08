/*=============================================
CARGAR LA TABLA DINÁMICA DE CATEGORÍAS
=============================================*/

// $.ajax({
//
// 	url:"ajax/tablaIngresos.ajax.php",
// 	success:function(respuesta){
//
// 		console.log(respuesta);
//
// 	}
//
// })

$(".tablaIngresos").DataTable({
	 "ajax": "ajax/tablaIngresos.ajax.php",
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

$(".tablaAddIngresos").DataTable({
	 "ajax": "ajax/tablaAddArticulos.ajax.php?tipo=Ingresos",
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


// CARGAR PROVEEDOR
//
function CargarProveedor(){
 	var datos = new FormData();
 	datos.append("tipoPersona", "Proveedor");
	$.ajax({
		url:"ajax/persona.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){

			var datosProveedor = JSON.parse(respuesta);

			datosProveedor.forEach(forEachProveedor);

			function forEachProveedor(proveedor, index){

				if (proveedor.apellido == null) {

					$(".idproveedor").append('<option value="'+proveedor.id+'">'+proveedor.nombre+'</option>');
				}else{

					$(".idproveedor").append('<option value="'+proveedor.id+'">'+proveedor.nombre+" "+proveedor.apellido+'</option>');
				}




			}


		}

	})

}

/**
 * GUARDAR PROVEEDOR DESDE INGRESOS

 */

$(".guardarProveedorIn").click(function(){

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
		}


		$.ajax({
			url:"ajax/persona.ajax.php",
			method: "POST",
			data: datosProveedor,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){


				$(".idproveedor").html('');
				CargarProveedor();
				$('#modalAgregarProveedorIn').modal('hide');
				limpiarModalProveedor();


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
 * INGRESOS
 */



// $(".modalAgregarProveedorIn .seleccionarTipoPersona").change(function(){

// 	tipo = $(this).val();

// 	if(tipo == "natural"){

// 		$(".modalAgregarProveedorIn .personaNatural").show();
// 		$(".modalAgregarProveedorIn .personaJuridica").hide();

// 	}else{

// 		$(".modalAgregarProveedorIn .personaJuridica").show();
// 		$(".modalAgregarProveedorIn .personaNatural").hide();

// 	}
// })

// $(".modalAgregarProveedorIn .tipoDocumento").change(function(){

// 	tipoDocumento = $(this).val();
// 	if (tipoDocumento == "DNI") {

// 		$(".modalAgregarProveedorIn .numDocumento").attr("maxlength", "8")


// 	}

// 	if (tipoDocumento == "RUC") {
// 		$(".modalAgregarProveedorIn .numDocumento").attr("maxlength", "12")
// 	}


// })
/**
 * MOSTRAR O CANCELAR FORMULARIO
 */

$(".btnAgregarIngreso").on("click", function(){

	$(".agregarIngresos").show();
	$(".listaIngresos").hide();
		limpiarForm();
		$(".guardarIngreso").hide();
		$(".btnCancelarIngreso").show();
		detalles=0;
		$("#btnAgregarArt").show();
		CargarProveedor();
		localStorage.removeItem("listaProductosCompra");

})

$(".btnCancelarIngreso").on("click", function(){

	$(".agregarIngresos").hide();
	$(".listaIngresos").show();


})
//Declaración de variables necesarias para trabajar con las compras y
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


function agregarDetalleIngresos(idarticulo, stock){
  	var cantidad=1;
    var precio_compra=1;
    var precio_venta=1;
    var listaProductosCompra = JSON.parse(localStorage.getItem("listaProductosCompra"));


    //var articulo = $(".agregarArticulo").attr("articulo");
    var articulo = document.getElementsByName(idarticulo);

	for (var i = 0; i < articulo.length; i++) {

		var nameArt = articulo[i];

		var nProducto = nameArt.value;


	}

	if  (nProducto){

		if(localStorage.getItem("listaProductosCompra") == null){

			listado = [];

		}else{

			var listaProductosCompra = JSON.parse(localStorage.getItem("listaProductosCompra"));

			for(var i = 0; i < listaProductosCompra.length; i++){

				if(listaProductosCompra[i]["idProducto"] == idarticulo){

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

			//listado.concat(localStorage.getItem("listaProductosCompra"));
		}



		if (stock >= 1) {
			listado.push({"idProducto":idarticulo});
			localStorage.setItem("listaProductosCompra", JSON.stringify(listado));
		}


		/**
		 * AGREGAR PRODUCTO
		 */
	 	if (idarticulo != "") {


			var subtotal=cantidad*precio_compra;
			var fila='<tr class="filas" id="fila'+cont+'" idarticulo"'+idarticulo+'">'+
			'<td><button type="button" class="btn btn-danger" onclick="eliminarDetalleCompra('+cont+')">X</button></td>'+
			'<td><input type="hidden" class="idarticulo" name="idarticulo[]" value="'+idarticulo+'">'+nProducto+'</td>'+
			'<td><input type="number" class="cantidad" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
			'<td><input type="number" step="any" class="precio_compra" name="precio_compra[]" id="precio_compra[]" value="'+precio_compra+'"></td>'+
			'<td><input type="number" step="any" class="precio_venta" name="precio_venta[]" value="'+precio_venta+'"></td>'+
			'<td><span name="subtotal" class="subtotal" id="subtotal'+cont+'">'+subtotal+'</span></td>'+
			'</tr>';
			cont++;
			detalles= detalles + 1;
			$('#detalles').append(fila);
			modificarSubototalesIngreso();
			evaluarIngreso();


    	}

	}

}


/**
 * MODIFICAR SUBTOTAL AL CAMBIAR CANTIDAD
 */

$(document).on("change", ".tblListadoArcticulosIngresos .cantidad", function(){

	modificarSubototalesIngreso();

})

/**
 * MODIFICAR SUBTOTAL AL CAMBIAR DIVISA
 */

$(document).on("change", ".formularioIngreso .divisa", function(){

	modificarSubototalesIngreso();


})
/**
 * MODIFICAR SUBTOTAL AL CAMBIAR precio
 */
$(document).on("change", ".tblListadoArcticulosIngresos .precio_compra", function(){

	modificarSubototalesIngreso();

})
/**
 * LIMPIAR AL CANCELAR
 */
$(document).on("click", ".btnCancelarIngreso", function(){

limpiarForm();

})


function modificarSubototalesIngreso()
{
	var cant = document.getElementsByName("cantidad[]");
	var prec = document.getElementsByName("precio_compra[]");
	var sub = document.getElementsByName("subtotal");


	for (var i = 0; i <cant.length; i++) {
		var inpC=cant[i];
		var inpP=prec[i];
		var inpS=sub[i];

		inpS.value=inpC.value * inpP.value;
		document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
	}
	calcularTotales();

}

function calcularTotales(){

	console.log("calcular totales");

	var sub = document.getElementsByName("subtotal");

	/**
	 * MOSTRAS SIMBOLO SEGUN DIVISA
	 */

	var divisa = $(".divisa option:selected").text();

	if (divisa == "PEN") {

		var simbolo = "S/.";

	}else if(divisa == "USD"){

		var simbolo = "$"

	}else if(divisa == "EUR"){

		var simbolo = "€";

	}else{

		var simbolo = "MXN"
	}

	var total = 0.0;

	for (var i = 0; i <sub.length; i++) {

		total += document.getElementsByName("subtotal")[i].value;
	}

	// $("#total").html(simbolo + " "+ total);
	// $("#total_compra").val(total);

	$("#total").html(simbolo + " "+ total.toFixed(2));
	$("#total_compra").val(total.toFixed(2));
	console.log(simbolo);
	evaluarIngreso();
}

function evaluarIngreso(){

	//console.log(detalles);
	if (detalles>0)
	{
	  $(".guardarIngreso").show();
	  $(".guardarIngreso").attr("display","block");
	}
	else
	{
	  $(".guardarIngreso").hide();
	  cont=0;
	}
}

function eliminarDetalleCompra(indice){

	$("#fila" + indice).remove();
	calcularTotales();
	detalles=detalles-1;
	evaluarIngreso();



	var idProducto = $(".filas");


	listaCarritoCompra = [];

	if(idProducto.length != 0){

		for(var i = 0; i < idProducto.length; i++){

			var idProductoArray = $(idProducto[i]).attr("idarticulo");
			//console.log(idProductoArray);

			listaCarritoCompra.push({"idProducto":idProductoArray});
		}

		localStorage.setItem("listaProductosCompra",JSON.stringify(listaCarritoCompra));


	}
}


//Función limpiar
function limpiarForm()
{
	$(".serie_comprobante").val("");
	$(".num_comprobante").val("");
	$(".impuesto").val("0");

	$(".total_compra").val("");
	$(".filas").remove();
	$(".total").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_hora').val(today);

    //console.log(today);

    //Marcamos el primer tipo_documento
    $(".tipo_comprobante").val("Boleta");
}



/*=============================================
GUARDAR INGRESO
=============================================*/
$(".guardarIngreso").click(function(){

/**
 * DATOS GENERALES
 */

 var proveedor = $(".idproveedor").val();
 var fecha = $(".fecha").val();
 var tipo_comprobante = $(".tipo_comprobante").val();
 var divisa_ingreso = $(".divisa").val();
 var serie_comprobante = $(".serie_comprobante").val();
 var numero_comprobante = $(".num_comprobante").val();
 var impuesto_ingreso = $(".impuesto").val();


 var formData = new FormData($("#formularioIngreso")[0]);

/**
 * ENVIAR POR AJAX
 *
 */

	if (proveedor != "" && tipo_comprobante != "" && divisa_ingreso != "" && serie_comprobante != "" && numero_comprobante != "") {

		$.ajax({
			url:"ajax/ingresos.ajax.php",
			method: "POST",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(respuesta){

				if(respuesta != null){

					swal({
					  type: "success",
					  title: "El Ingreso ha sido guardado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "ingresos";

						}
					})
				}else{

					swal({
						  title: "¡ERROR!",
						  text: "¡Ha ocurrido un problema al guadar!",
						  type:"error",
						  preConfirm: function() {

						    //window.location = "ingresos";
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

			  //   window.location = "ingresos";
			  // }
			})
	}

})

/*=============================================
MOSTRAR INGRESO
=============================================*/

 function mostrarIngreso(idingreso){

 	var datos = new FormData();
 	datos.append("idingreso", idingreso);

	$.ajax({
		url:"ajax/ingresos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){

			var ingreso = JSON.parse(respuesta);



			if(respuesta != null){
				$(".idproveedor").val(ingreso.idproveedor);
				$(".tipo_comprobante").val(ingreso.tipo_comprobante);
				$(".serie_comprobante").val(ingreso.serie_comprobante);
				$(".num_comprobante").val(ingreso.num_comprobante);
				$("#fecha_hora").val(ingreso.fecha_hora.substr(0, 10));
				$(".impuesto").val(ingreso.impuesto);
				$(".idingreso").val(ingreso.idingreso);

				//Ocultar y mostrar los botones
				$(".guardarIngreso").hide();
				$(".btnCancelarIngreso").show();
				$("#btnAgregarArt").hide();
				$(".agregarIngresos").show();
				$(".listaIngresos").hide();

				var datosIngreso = new FormData();
					datosIngreso.append("idingreso_detalle", idingreso);
				$.ajax({
					url:"ajax/ingresos.ajax.php",
					method: "POST",
					data: datosIngreso,
					cache: false,
					contentType: false,
					processData: false,
					success: function(detalle){

						$(".tblListadoArcticulosIngresos").html(detalle);


					}
				})

			}else{

				swal({
					  title: "¡ERROR!",
					  text: "¡Ha ocurrido un problema al cargar!",
					  type:"error",
					  preConfirm: function() {

					    //window.location = "ingresos";
					  }
					})
			}

		}

	})

}
/**
 * ANULAR INGRESO
 */
$(".tablaIngresos tbody").on("click", ".btnEliminarIngreso", function(){

	var idanular = $(this).attr("idingreso");


	var datos = new FormData();
 	datos.append("idanular", idanular);

  	$.ajax({

  		url:"ajax/ingresos.ajax.php",
  		method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){

      		//console.log(respuesta);


      		if (respuesta != 0) {
				$(this).hide();
				$(".labelActivar"+idanular).removeClass('label-success');
				$(".labelActivar"+idanular).addClass('label-danger');
				$(".labelActivar"+idanular).html('Desactivado');
	      		iziToast.show({
	              title: '<h4>INGRESO ANULADO</h4>',
	              message: '<br>Se ha anulado el ingreso',
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
