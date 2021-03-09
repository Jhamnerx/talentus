/*=============================================
CARGAR LA TABLA DINÁMICA DE SERVICIOS
=============================================*/

// $.ajax({

// 	url:"ajax/tablaServicios.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

$(".tablaServicios").DataTable({
	 "ajax": "ajax/tablaServicios.ajax.php",
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

$(".tablaServicios tbody").on("click", ".btnActivar", function(){

	var idServicio = $(this).attr("idServicio");
	var estadoServicio = $(this).attr("estadoServicio");

	var datos = new FormData();
 	datos.append("activarId", idServicio);
  	datos.append("activarServicio", estadoServicio);

  	$.ajax({

  		 url:"ajax/servicios.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 
      	    

      	} 	 

  	});

  	if(estadoServicio == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoServicio',1);
  		iziToast.show({
              title: '<h4><label class="label-danger">SERVICIOS/PRODUCTO DESACTIVADO</label></h4>',
              message: '<br>Se ha desactivado, El Servicio no se mostrará',
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
  		$(this).attr('estadoServicio',0);
  		iziToast.show({
              title: '<h4><label class="label-success">SERVICIOS/PRODUCTO ACTIVADO</label></h4>',
              message: '<br>Se ha activado, el Servicio se mostrará',
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
$(".fotoServicio").change(function(){
  
  var imagen = this.files[0];
  var datosImagen = new FileReader;
  datosImagen.readAsDataURL(imagen);

  $(datosImagen).on("load", function(event){

    var rutaImagen = event.target.result;

    $(".previsualizaServicio").attr("src", rutaImagen);

  })

})
/*=============================================
OCULTAR SEGUN EL TIPO
=============================================*/

$(".seleccionarTipo").change(function(){

  if ($(".seleccionarTipo").val() == "servicio") {

    $(".contenedorStock").hide();

  }else{
    $(".contenedorStock").show();
  }

})

$(".editar.seleccionarTipo").change(function(){

  console.log($(".editar.seleccionarTipo").val());

  if ($(".editar.seleccionarTipo").val() == "servicio") {

    $(".contenedorStockEditar").hide();

  }else{
    $(".contenedorStockEditar").show();
  }

})

/*=============================================
LIMPIAR NOMBRE DE CHAR ESPECIALES
=============================================*/
$(".validarServicio").change(function(){

  $(".validarServicio").val(ClearUrl($(".validarServicio").val()));

})

/*=============================================
EDITAR SERVICIO
=============================================*/

$(".tablaServicios tbody").on("click", ".btnEditarServicio", function(){

  var idServicio = $(this).attr("idServicio");

  var datos = new FormData();
  datos.append("idServicio", idServicio);


  $.ajax({

    url:"ajax/servicios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta){

      if (respuesta["tipo"] == "servicio") {

        $(".contenedorStockEditar").hide();

      }else{
        $(".contenedorStockEditar").show();
      }


      $("#modalEditarServicio .editarIdServicio").val(respuesta["id"]);

      $("#modalEditarServicio .nombreServicio").val(respuesta["nombre"]);

      $("#modalEditarServicio .seleccionarCategoria").val(respuesta["idcategoria"]);

      $("#modalEditarServicio .seleccionarTipo").val(respuesta["tipo"]);

      $("#modalEditarServicio .precio").val(respuesta["precio"]);

      $("#modalEditarServicio .stock").val(respuesta["stock"]);

      $("#modalEditarServicio .descripcionServicio").val(respuesta["descripcion"]);

      $("#modalEditarServicio .descripcionServicio").val(respuesta["descripcion"]);

      $("#modalEditarServicio .previsualizaServicio").attr("src", respuesta["imagen"]);

      $("#modalEditarServicio .antiguaFotoServicio").val(respuesta["imagen"]);

      $("#modalEditarServicio .codigoServicio").val(respuesta["codigo"]);


    }

  })

})