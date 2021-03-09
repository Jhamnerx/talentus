/*=============================================
CARGAR LA TABLA DINÁMICA DE CATEGORÍAS
=============================================*/

// $.ajax({

// 	url:"ajax/tablaCiudad.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

$(".tablaCiudades").DataTable({
	 "ajax": "ajax/tablaCiudad.ajax.php",
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

$(".tablaCiudades tbody").on("click", ".btnActivar", function(){

	console.log("click");

	var idCiudad = $(this).attr("idCiudad");
	var estadoCiudad = $(this).attr("estadoCiudad");

	var datos = new FormData();
 	datos.append("activarId", idCiudad);
  	datos.append("activarCiudad", estadoCiudad);

  	$.ajax({

  		 url:"ajax/ciudad.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 

      		console.log(respuesta);
      	    

      	} 	 

  	});

  	if(estadoCiudad == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoCiudad',1);

  		$(".idCiudad"+idCiudad).removeAttr("disabled");
  		iziToast.show({
              title: '<h4><label class="label-danger">CIUDAD DESACTIVADA</label></h4>',
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
  		$(this).attr('estadoCiudad',0);
  		$(".idCiudad"+idCiudad).attr("disabled", "disabled");
  		iziToast.show({
              title: '<h4><label class="label-success">CIUDAD ACTIVADA</label></h4>',
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

/*=============================================
REVISAR SI  YA EXISTE
=============================================*/

$(".validarCiudad").change(function(){

	$(".alert").remove();

	var ciudad = $(this).val();
	// console.log("ciudad", ciudad);

	var datos = new FormData();
	datos.append("validarCiudad", ciudad);

	$.ajax({
	    url:"ajax/ciudad.ajax.php",
	    method:"POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success:function(respuesta){
	    	
	    	// console.log("respuesta", respuesta);

	    	if(respuesta){

	    		$(".validarCiudad").parent().after('<div class="alert alert-warning">Esta ciudad ya existe en la base de datos</div>')
	    		$(".validarCiudad").val("");
	    	}   

	    }

	  })
});
/*=============================================
EDITAR CIUDAD
=============================================*/

$(".tablaCiudades tbody").on("click", ".btnEditarCiudad", function(){

	var idCiudad = $(this).attr("idCiudad");

	var datos = new FormData();
	datos.append("idCiudad", idCiudad);

	$.ajax({

		url:"ajax/ciudad.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){


			$("#modalEditarCiudad .editarIdCiudad").val(respuesta["id"]);

			$("#modalEditarCiudad .editarNombreCiudad").val(respuesta["nombre"]);

			$("#modalEditarCiudad .editarPrefijoCiudad").val(respuesta["prefijo"]);


		}

	})



})
