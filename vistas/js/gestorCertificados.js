/*=============================================
CARGAR LA TABLA DINÁMICA DE CERTIFICADOS
// =============================================*/

// $.ajax({

// 	url:"ajax/tablaCertificado.ajax.php",
// 	success:function(respuesta){
		
// 		console.log(respuesta);

// 	}

// })

$(".tablaCertificado").DataTable({
	 "ajax": "ajax/tablaCertificado.ajax.php",
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


function autocompleteVehiculo(){

    var availableTags = $(".autocompleteVehiculos").val();
    var names = availableTags.split(",");

    console.log(names);
    var obj = JSON.parse(availableTags);
    //console.log(names);

    var anames = $.map(obj, function (value, key) { return { value: value, data: key }; });


    $('#autocomplete-ajax').devbridgeAutocomplete({
        // serviceUrl: '/autosuggest/service/url',
        lookup: anames,
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
        onSelect: function(suggestion) {
            $('#selction-ajax').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
            $(".idvehiculo").val(suggestion.data);

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
            $(".idvehiculo").val(suggestion.data);

        },
        onHint: function (hint) {
            $('#autocomplete-ajax-x').val(hint);
        },
        onInvalidateSelection: function() {
            $('#selction-ajax').html('You selected: none');
        }
    });
}


function autocompleteVehiculoEditar(){

    var availableTags = $(".autocompleteVehiculosEditar").val();
    var names = availableTags.split(",");

    //console.log(names);
    var obj = JSON.parse(availableTags);
    //console.log(names);

    var anames = $.map(obj, function (value, key) { return { value: value, data: key }; });


    $('#autocomplete-ajax-editar').devbridgeAutocomplete({
        // serviceUrl: '/autosuggest/service/url',
        lookup: anames,
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
        onSelect: function(suggestion) {
            //$('#selction-ajax').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
            $(".idEditarVehiculo").val(suggestion.data);

        },
        onHint: function (hint) {
           // $('#autocomplete-ajax-x').val(hint);
        },
        onInvalidateSelection: function() {
            //$('#selction-ajax').html('You selected: none');
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
            //$('#selction-ajax').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
            $(".idEditarVehiculo").val(suggestion.data);

        },
        onHint: function (hint) {
            //$('#autocomplete-ajax-x').val(hint);
        },
        onInvalidateSelection: function() {
            //$('#selction-ajax').html('You selected: none');
        }
    });
}
/**

ACTIVAR//DESACTIVAR
**/

$(".tablaCertificado tbody").on("click", ".btnActivar", function(){

	var idCertificado = $(this).attr("idCertificado");
	var estadoCertificado = $(this).attr("estadoCertificado");

	var datos = new FormData();
 	datos.append("activarId", idCertificado);
  	datos.append("activarCertificado", estadoCertificado);

  	$.ajax({

  		 url:"ajax/certificado.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 

      		console.log(respuesta);
      	    

      	} 	 

  	});

  	if(estadoCertificado == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoVehiculo',1);
  		iziToast.show({
              title: '<h4><label class="label-danger">CERTIFICADO DESACTIVADA</label></h4>',
              message: '<br>Se ha desactivado, El Certificado no se mostrará',
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
  		$(this).attr('estadoCertificado',0);
  		iziToast.show({
              title: '<h4><label class="label-success">CERTIFICADO ACTIVADO</label></h4>',
              message: '<br>Se ha activado, el Certificado se mostrará',
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


$(".modalAgregarCertificado").on("click", function(){

cargarDispositivo();
cargarClienteCertificado();

})




/**
 * ACTUALIZAR CARACTERISTICAS
 */
$(".tablaCertificado tbody").on("ifClicked", "#sello", function(sello){

  	var estado = sello.target.checked;

  	var idCertificado = sello.target.attributes.idCertificado.nodeValue;

  	ActualizarCaracteristicasCertificado("sello", estado, idCertificado);



});

$(".tablaCertificado tbody").on("ifClicked", "#fondo", function(fondo){

  	var estado = fondo.target.checked;
  	var idCertificado = fondo.target.attributes.idCertificado.nodeValue;

  	ActualizarCaracteristicasCertificado("fondo", estado, idCertificado);
});


$(".tablaCertificado tbody").on("click", "#sello", function(sello){

  	var estado = !sello.target.checked;

  	var idCertificado = sello.target.attributes.idCertificado.nodeValue;

  	ActualizarCaracteristicasCertificado("sello", estado, idCertificado);



});

$(".tablaCertificado tbody").on("click", "#fondo", function(fondo){

  	var estado = !fondo.target.checked;
  	var idCertificado = fondo.target.attributes.idCertificado.nodeValue;

  	ActualizarCaracteristicasCertificado("fondo", estado, idCertificado);
});

function ActualizarCaracteristicasCertificado(caract, estado, idCertificado){

	//console.log(caract +" "+ estado);

	if (estado == true) {

		var estadoCaract = 0;

	}else{

		var estadoCaract = 1;
	}

	var datos = new FormData();
	datos.append("caracteristica", caract);
  	datos.append("estado", estadoCaract);
  	datos.append("idCertificadoCaract", idCertificado);

  	$.ajax({

  		 url:"ajax/certificado.ajax.php",
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

function cargarClienteCertificado(){
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

          $(".idcliente").append('<option value="'+cliente.id+'">'+cliente.nombre+'</option>');

        }else{


          if (cliente.apellido == null) {

            $(".idcliente").append('<option value="'+cliente.id+'">'+cliente.nombre+'</option>');

          }else{

            $(".idcliente").append('<option value="'+cliente.id+'">'+cliente.nombre+' '+cliente.apellido+'</option>');

          }


        }


        
      }


    }

  })

}

//EDITARR

$(".tablaCertificado tbody").on("click", ".btnEditarCertificado", function(){

  var idCertificado = $(this).attr("idcertificado");
  // console.log(idCertificado);
	cargarDispositivo();
	cargarClienteCertificado();

  var datos = new FormData();
  datos.append("idCertificado", idCertificado);
  datos.append("item", "id");



    $.ajax({

      url:"ajax/certificado.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta){

        //console.log(respuesta);


        $("#modalEditarCertificado .editarnumCertificado").val(respuesta["num_certificado"]);
        $("#modalEditarCertificado .editaridCertificado").val(respuesta["id"]);
        $("#modalEditarCertificado .editardispositivo").val(respuesta["modelo_gps"]);
        //$("#modalEditarCertificado .certificadoidcliente").val(respuesta["idcliente"]);

        var idVehiculo = respuesta["idvehiculo"];
        var datosV = new FormData();
        datosV.append("idVehiculo", idVehiculo);
        $.ajax({

          url:"ajax/vehiculos.ajax.php",
          method: "POST",
          data: datosV,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(vehiculo){


            $("#modalEditarCertificado .editarVehiculo").val(vehiculo["placa"]);

          //
          

          
          }

      })

        $("#modalEditarCertificado .editarfin").val(respuesta["fin_cobertura"]);
        $("#modalEditarCertificado .editarfecha").val(respuesta["fecha"]);
        $("#modalEditarCertificado .editarciudad").val(respuesta["ciudad"]);
        
      
        if ($("#modalEditarCertificado .editarciudad").find("option[value='" + respuesta["ciudad"] + "']").length) {

          $('#modalEditarCertificado .editarciudad').val(respuesta["ciudad"]).trigger('change');

        }
      
        if ($("#modalEditarCertificado .certificadoidcliente").find("option[value='" + respuesta["idcliente"] + "']").length) {

          $('#modalEditarCertificado .certificadoidcliente').val(respuesta["idcliente"]).trigger('change');

          //console.log("existe");

        }

        if ($("#modalEditarCertificado .editardispositivo").find("option[value='" + respuesta["modelo_gps"] + "']").length) {

          $('#modalEditarCertificado .editardispositivo').val(respuesta["modelo_gps"]).trigger('change');

          //console.log("existe");

        }


        if (respuesta["sello"] == 1) {

          $('#modalEditarCertificado .editarsello').iCheck('check');
          

        }else{

          $('#modalEditarCertificado .editarsello').iCheck('uncheck');

        }
        
        if (respuesta["fondo"] == 1) {

          $('#modalEditarCertificado .editarfondo').iCheck('check');


        }else{

          $('#modalEditarCertificado .editarfondo').iCheck('uncheck');
        }
      

      
      }

  })


})





$(".modalAgregarCertificado").on("click", function(){

 autocompleteVehiculo();
});

$(".tablaCertificado tbody").on("click", ".btnEditarCertificado", function(){

 autocompleteVehiculoEditar();

});
