var tipo = null;

$(".seleccionarTipoPersona").change(function(){

	tipo = $(this).val();

	if(tipo == "natural"){

		$(".personaNatural").show();
		$(".personaJuridica").hide();
	
	}else{

		$(".personaJuridica").show();
		$(".personaNatural").hide();

	}
})

$(".tipoDocumento").change(function(){

	tipoDocumento = $(this).val();
	if (tipoDocumento == "DNI") {

		$(".numDocumento").attr("maxlength", "8")


	}

	if (tipoDocumento == "RUC") {
		$(".numDocumento").attr("maxlength", "12")
	}


})

function limpiarModalProveedor(){

	$(".modalAgregarProveedorIn .nombreProveedorJ").val("");
	$(".modalAgregarProveedorIn .nombreProveedorN").val("");
	$(".modalAgregarProveedorIn .apellidoProveedor").val("");
	$(".modalAgregarProveedorIn .numDocumento").val("");
	$(".modalAgregarProveedorIn .direccionProveedor").val("");
	$('emailProveedor').tagsinput('removeAll');
	$('telefonoProveedor').tagsinput('removeAll');
}
function limpiarModalCliente(){

	$(".modalAgregarCliente .nombreClienteJ").val("");
	$(".modalAgregarCliente .nombreClienteN").val("");
	$(".modalAgregarCliente .apellidoCliente").val("");
	$(".modalAgregarCliente .numDocumento").val("");
	$(".modalAgregarCliente .direccionCliente").val("");
	$('emailCliente').tagsinput('removeAll');
	$('telefonoCliente').tagsinput('removeAll');
}

