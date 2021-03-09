/*=============================================
CARGAR LA TABLA DINÁMICA DE CATEGORÍAS
=============================================*/

// $.ajax({

// 	url:"ajax/tablaDispositivos.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

$(".tablaDispositivos").DataTable({
	 "ajax": "ajax/tablaDispositivos.ajax.php",
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

/*=============================================
EDITAR DISPOSITIVOS
=============================================*/

$(".tablaDispositivos tbody").on("click", ".btnEditarDispositivo", function(){

	var idDispositivo = $(this).attr("idDispositivo");

	var datos = new FormData();
	datos.append("idDispositivo", idDispositivo);

	$.ajax({

		url:"ajax/dispositivos.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){


			$("#modalEditarDispositivo .modelo").val(respuesta["modelo"]);
			$("#modalEditarDispositivo .idDispositivoEditar").val(respuesta["id"]);

			$("#modalEditarDispositivo .Marca").val(respuesta["marca"]);

			$("#modalEditarDispositivo .Codigo").val(respuesta["certificado"]);


		}

	})



})