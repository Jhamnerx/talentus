/*=============================================
CARGAR LA TABLA DINÁMICA DE ACTAS
=============================================*/

// $.ajax({

// 	url:"ajax/tablaActas.ajax.php",
// 	success:function(respuesta){
		
// 		console.log(respuesta);

// 	}

// })

$(".tablaActas").DataTable({
	 "ajax": "ajax/tablaActas.ajax.php",
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



/**

ACTIVAR//DESACTIVAR
**/

$(".tablaActas tbody").on("click", ".btnActivar", function(){

	var idActa = $(this).attr("idActa");
	var estadoActa = $(this).attr("estadoActa");

	var datos = new FormData();
 	datos.append("activarId", idActa);
  	datos.append("activarActa", estadoActa);

  	$.ajax({

  		 url:"ajax/actas.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 

      		console.log(respuesta);
      	    

      	} 	 

  	});

  	if(estadoActa == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoVehiculo',1);
  		iziToast.show({
              title: '<h4><label class="label-danger">ACTA DESACTIVADA</label></h4>',
              message: '<br>Se ha desactivado, El Acta no se mostrará',
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
  		$(this).attr('estadoActa',0);
  		iziToast.show({
              title: '<h4><label class="label-success">ACTA ACTIVADO</label></h4>',
              message: '<br>Se ha activado, el Acta se mostrará',
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




$(".modalAgregarActa").on("click", function(){

cargarVehiculos();
console.log("clic")

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
 * ACTUALIZAR CARACTERISTICAS
 */
$(".tablaActas tbody").on("ifClicked", "#sello", function(sello){

  	var estado = sello.target.checked;

  	var idActa = sello.target.attributes.idActa.nodeValue;

  	ActualizarCaracteristicasActa("sello", estado, idActa);



});

$(".tablaActas tbody").on("ifClicked", "#fondo", function(fondo){

  	var estado = fondo.target.checked;
  	var idActa = fondo.target.attributes.idActa.nodeValue;

  	ActualizarCaracteristicasActa("fondo", estado, idActa);
});


$(".tablaActas tbody").on("click", "#sello", function(sello){

  	var estado = !sello.target.checked;

  	var idActa = sello.target.attributes.idActa.nodeValue;

  	ActualizarCaracteristicasActa("sello", estado, idActa);



});

$(".tablaActas tbody").on("click", "#fondo", function(fondo){

  	var estado = !fondo.target.checked;
  	var idActa = fondo.target.attributes.idActa.nodeValue;

  	ActualizarCaracteristicasActa("fondo", estado, idActa);
});

function ActualizarCaracteristicasActa(caract, estado, idActa){

	//console.log(caract +" "+ estado);

	if (estado == true) {

		var estadoCaract = 0;

	}else{

		var estadoCaract = 1;
	}

	var datos = new FormData();
	datos.append("caracteristica", caract);
  	datos.append("estado", estadoCaract);
  	datos.append("idActaCaract", idActa);

  	$.ajax({

  		 url:"ajax/actas.ajax.php",
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

// CARGAR FLOTA
// 
function cargarVehiculosActa(){



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
        //$(".idvehiculo").val(null).trigger("change");
        var newOption = new Option(vehiculo.placa, vehiculo.id);
        //$(".idvehiculo").append('<option value="'+vehiculo.id+'">'+vehiculo.placa+'</option>');
        $('#modalEditarActa .editaractavehiculo').append(newOption).trigger('change');   

       }


    }

  })

}
$(document).ready(function() {
  cargarVehiculosActa();
 // console.log("pagina lista")
});


//EDITARR
 var cantClicks = 0;
$(".tablaActas tbody").on("click", ".btnEditarActa", function(){

  var idvehiculoEditar = $(this).attr("idvehiculo");

  var idActa = $(this).attr("idacta");
  // console.log(idActa);
  
  var datos = new FormData();
  datos.append("idActa", idActa);
  datos.append("item", "id");



    $.ajax({

      url:"ajax/actas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta){

       // console.log(respuesta["idvehiculo"]);


        $("#modalEditarActa .editarNumActa").val(respuesta["num_acta"]);
        $("#modalEditarActa .editaridActa").val(respuesta["id"]);
        $("#modalEditarActa .editaractavehiculo").val(respuesta["idvehiculo"]);
        $("#modalEditarActa .editarinicio").val(respuesta["inicio_cobertura"]);
        $("#modalEditarActa .editarfin").val(respuesta["fin_cobertura"]);
        $("#modalEditarActa .editarfecha").val(respuesta["fecha"]);
        $("#modalEditarActa .editarciudad").val(respuesta["ciudad"]);
        
      
        if ($("#modalEditarActa .editarciudad").find("option[value='" + respuesta["ciudad"] + "']").length) {

          $('#modalEditarActa .editarciudad').val(respuesta["ciudad"]).trigger('change');

        }

        $('#modalEditarActa .editaractavehiculo').val(respuesta["idvehiculo"]).trigger('change');

        if (respuesta["sello"] == 1) {

          $('#modalEditarActa .editarsello').iCheck('check');
          

        }else{

          $('#modalEditarActa .editarsello').iCheck('uncheck');

        }
        
        if (respuesta["fondo"] == 1) {

          $('#modalEditarActa .editarfondo').iCheck('check');


        }else{

          $('#modalEditarActa .editarfondo').iCheck('uncheck');
        }
      

      
      }

  })


})




$(".tablaActas tbody").on("click", ".btnDescargarActa", function(){

  var idActa = $(this).attr("idActa");
  var idCiudadActa = $(this).attr("ciudad");

  var datos = new FormData();
  datos.append("idActaActualizar", idActa);
  datos.append("idCiudadActa", idCiudadActa);

  
    $.ajax({

      url:"ajax/actas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta){ 

          console.log(respuesta);
            

        }    

    });


})


var table = $('.tablaActas').DataTable();
 
$('.tablaActas').on( 'page.dt', function () {

   //  $('input[type="checkbox"].caracteristicas, input[type="radio"].flat-red').iCheck({
	  // checkboxClass: 'icheckbox_flat-green',
	  // radioClass   : 'iradio_flat-green'
   //  });


} );

$(document).click(function(){

    $('input[type="checkbox"].caracteristicas, input[type="radio"].flat-red').iCheck({
	  checkboxClass: 'icheckbox_flat-green',
	  radioClass   : 'iradio_flat-green'
    });

    //console.log("clic")

});

