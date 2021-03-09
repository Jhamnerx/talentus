/*=============================================
CARGAR LA TABLA DINÁMICA DE lineas
=============================================*/

// $.ajax({

// 	url:"ajax/tablaLineas.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

$(".tablaLineas").DataTable({
	 "ajax": "ajax/tablaLineas.ajax.php",
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
function autocompleteEmpresaLinea(){

    var availableTags = $(".autocomplete").val();
    var names = availableTags.split(",");
    var obj = JSON.parse(availableTags);
    //console.log(names);

    var anames = $.map(obj, function (value, key) { return { value: value, data: key }; });

    //console.log(anames);
    // Setup jQuery ajax mock:
    // $.mockjax({
    //     url: '*',
    //     responseTime: 2000,
    //     response: function (settings) {
    //         var query = settings.data.query,
    //             queryLowerCase = query.toLowerCase(),
    //             re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi'),
    //             suggestions = $.grep(anames, function (country) {
    //                  // return country.value.toLowerCase().indexOf(queryLowerCase) === 0;
    //                 return re.test(country.value);
    //             }),
    //             response = {
    //                 query: query,
    //                 suggestions: suggestions
    //             };

    //         this.responseText = JSON.stringify(response);
    //     }
    // });

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
            $(".nameEmpresa").val(suggestion.value);

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
            $(".nameEmpresa").val(suggestion.value);

        },
        onHint: function (hint) {
            $('#autocomplete-ajax-x').val(hint);
        },
        onInvalidateSelection: function() {
            $('#selction-ajax').html('You selected: none');
        }
    });
}
$(".btnAgregarLinea").on("click", function(){
 	autocompleteEmpresaLinea();
});

$(".tablaLineas tbody").on("click", ".btnEditarLinea", function(){

	autocompleteEmpresaLinea();


	 var idLinea = $(this).attr("idLinea");

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
		success: function(respuesta){

			console.log(respuesta);
			$("#modalEditarLinea .idLinea").val(respuesta["id"]);
			$("#modalEditarLinea .numero").val(respuesta["numero"]);
			$("#modalEditarLinea .editarPlaca").val(respuesta["placa"]);
			$("#modalEditarLinea .simCard").val(respuesta["sim_card"]);
			$("#modalEditarLinea .empresa").val(respuesta["empresa"]);
			$("#modalEditarLinea .nameEmpresa").val(respuesta["empresa"]);



		}

	})
});


$(".tablaLineas tbody").on("click", ".btnActivar", function(){

	var idLinea = $(this).attr("idLinea");
	var estadoLinea = $(this).attr("estadoLinea");

	var datos = new FormData();
 	datos.append("activarId", idLinea);
  	datos.append("activarLinea", estadoLinea);

  	$.ajax({

  		 url:"ajax/lineas.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 

      		console.log(respuesta);
      	    

      	} 	 

  	});

  	if(estadoLinea == 0){

  		$(this).removeClass('btn-warning');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoLinea',1);

  		//$(".idLinea"+idLinea).removeAttr("disabled");
  		iziToast.show({
              title: '<h4><label class="label-danger">LINEA DESACTIVADA</label></h4>',
              message: '<br>Se ha desactivado',
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
  	
  	}if(estadoLinea == 1){

  		$(this).addClass('btn-success');
  		$(this).removeClass('btn-danger');
  		$(this).html('Activado');
  		$(this).attr('estadoLinea',2);
  		//$(".idLinea"+idLinea).attr("disabled", "disabled");
  		iziToast.show({
              title: '<h4><label class="label-success">LINEA ACTIVADA</label></h4>',
              message: '<br>Se ha activado',
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
if(estadoLinea == 2){

  		$(this).addClass('btn-warning');
  		$(this).removeClass('btn-success');
  		$(this).html('Suspendido');
  		$(this).attr('estadoLinea',0);
  		//$(".idLinea"+idLinea).attr("disabled", "disabled");
  		iziToast.show({
              title: '<h4><label class="label-warning">LINEA SUSPENDIDA</label></h4>',
              message: '<br>Se ha suspendido',
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