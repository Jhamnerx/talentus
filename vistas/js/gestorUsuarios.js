/*=============================================
CARGAR LA TABLA DINÁMICA DE CATEGORÍAS
=============================================*/

// $.ajax({

// 	url:"ajax/tablaUsuarios.ajax.php",
// 	success:function(respuesta){
		
// 		console.log("respuesta", respuesta);

// 	}

// })

$(".tablaUsuarios").DataTable({
	 "ajax": "ajax/tablaUsuarios.ajax.php",
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
VALIDAR EMAIL REPETIDO
=============================================*/


var validarEmailRepetido = false;

$("#regEmail").change(function(){

	var email = $("#regEmail").val();

	var datos = new FormData();
	datos.append("validarEmail", email);

	$.ajax({

		url:rutaOculta+"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success:function(respuesta){

			//console.log(respuesta);
			
			if(respuesta == 0){

				$(".alert").remove();
				validarEmailRepetido = false;

			}else{


				$("#regEmail").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> El correo electrónico ya existe en la base de datos, por favor ingrese otro diferente</div>')

				validarEmailRepetido = true;

			}

		}

	})

})


/*=============================================
VALIDAR EL REGISTRO DE USUARIO
=============================================*/
function registroUsuario(){

	/*=============================================
	VALIDAR EL NOMBRE
	=============================================*/

	var nombre = $("#regUsuario").val();

	if(nombre != ""){

		var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;

		if(!expresion.test(nombre)){

			$("#regUsuario").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten números ni caracteres especiales</div>')

			return false;

		}

	}else{

		$("#regUsuario").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	/*=============================================
	VALIDAR EL EMAIL
	=============================================*/

	var email = $("#regEmail").val();

	if(email != ""){

		var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

		if(!expresion.test(email)){

			$("#regEmail").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Escriba correctamente el correo electrónico</div>')

			return false;

		}

		if(validarEmailRepetido){

			$("#regEmail").parent().before('<div class="alert alert-danger"><strong>ERROR:</strong> El correo electrónico ya existe en la base de datos, por favor ingrese otro diferente</div>')

			return false;

		}

	}else{

		$("#regEmail").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}


	/*=============================================
	VALIDAR CONTRASEÑA
	=============================================*/

	var password = $("#regPassword").val();

	if(password != ""){

		var expresion = /^[a-zA-Z0-9]*$/;

		if(!expresion.test(password)){

			$("#regPassword").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten caracteres especiales</div>')

			return false;

		}

	}else{

		$("#regPassword").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

		return false;
	}

	/*=============================================
	VALIDAR POLÍTICAS DE PRIVACIDAD
	=============================================*/

	var politicas = $("#regPoliticas:checked").val();
	
	if(politicas != "on"){

		$("#regPoliticas").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Debe aceptar nuestras condiciones de uso y políticas de privacidad</div>')

		return false;

	}

	return true;
}




$(".formularioIngreso").on('submit', function(e){
  e.preventDefault();
  var login =$(".username").val();

  //console.log(login);
  var clave =$(".password").val();
  var datos = new FormData();
  datos.append("login", login);
  datos.append("clave", clave);
  
	$.ajax({
		url:"ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		success: function(respuesta){

			console.log(respuesta);

			if (respuesta == 1) {

				window.location = "inicio";
			}
			if (respuesta == 2) {
				
				swal({
				  title: "¡USUARIO DESACTIVADO!",
				  text: "¡Por favor asegurese que el administrador haya activado su usuario",
				  type: "error",
				  confirmButtonText: "Cerrar",
				  preConfirm: function() {
		    		location.reload();
		  		  }
				});
			}

			if (respuesta == 3) {

				swal({
					title: "¡ERROR AL INGRESAR!",
					text: "¡Por favor revise que el usuario exista o la contraseña coincida con la registrada!",
					type: "error",
					confirmButtonText: "Cerrar",
					preConfirm: function() {
		    		location.reload();
		  		  	}
				
				});

			}

			if (respuesta == 10) {

				swal({
					title: "¡ERROR AL INGRESAR!",
					text: "¡Por favor revise que el usuario exista o la contraseña coincida con la registrada!",
					type: "error",
					confirmButtonText: "Cerrar",
					preConfirm: function() {
		    		location.reload();
		  		  	}
				
				});

			}

		}
	})
})

$(".btSalir").on('click', function(){

	window.location = "salir";

})


/*=============================================
SUBIR PERFIL
=============================================*/
var $uploadCrop;

function readFile(input) {

	if (input.files && input.files[0]) {

    	var reader = new FileReader();

	    reader.onload = function (e) {

	        $('.upload-perfil').addClass('ready');

	        $uploadCrop.croppie('bind', {

	            url: e.target.result

	         }).then(function(){

	            $('.upload-result-perfil').removeAttr("disabled");


	         });
	            
	    } 

    	reader.readAsDataURL(input.files[0]);

    }else {

        swal("Sorry - you're browser doesn't support the FileReader API");

    }
}

$uploadCrop = $('#upload-perfil').croppie({
	viewport: {
	    width: 300,
	    height: 300,
	    type: 'square'
	 },
  	enableExif: true
});

$('#uploadPerfil').on('change', function () {readFile(this); });


/**
 * VERIFICAR QUE NO EXISTA USUARIO
 * 
 */
$('.formularioUsuario .login').on('change', function () {

	$(".alert").remove();

	var usuario = $(this).val();

	var datos = new FormData();
	datos.append("usuario", usuario);

	$.ajax({

	    url:"ajax/usuarios.ajax.php",
	    method: "POST",
      	data: datos,
     	cache: false,
     	contentType: false,
        processData: false,
        success: function(respuesta){

        	//console.log(respuesta);

	        if(respuesta !== "false"){

	        	$('.formularioUsuario .login').after('<br><div class="alert alert-warning"><strong>ERROR:</strong> El usuario ya se encuentra registrado</div>');
	      
	        }
	        
	    }

	})

});


/**
* ACTIVAR USUARIO
**/
$(".tablaUsuarios tbody").on("click", ".btnActivar", function(){

	var idUsuario = $(this).attr("idUsuario");
	var estadoUsuario = $(this).attr("estadoUsuario");

	var datos = new FormData();
 	datos.append("activarId", idUsuario);
  	datos.append("activarUsuario", estadoUsuario);

  	$.ajax({

  		 url:"ajax/usuarios.ajax.php",
  		 method: "POST",
	  	data: datos,
	  	cache: false,
      	contentType: false,
      	processData: false,
      	success: function(respuesta){ 

      		//console.log(respuesta);
      	    

      	} 	 

  	});

  	if(estadoUsuario == 0){

  		$(this).removeClass('btn-success');
  		$(this).addClass('btn-danger');
  		$(this).html('Desactivado');
  		$(this).attr('estadoUsuario',1);

  		$(".idUsuario"+idUsuario).removeAttr("disabled");
  		iziToast.show({
              title: '<h4><label class="label-danger">USUARIO DESACTIVADO</label></h4>',
              message: '<br>El usuario fue Desactivado',
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
  		$(this).attr('estadoUsuario',0);
  		$(".idUsuario"+idUsuario).attr("disabled", "disabled");
  		iziToast.show({
              title: '<h4><label class="label-success">USUARIO ACTIVADO</label></h4>',
              message: '<br>El usuario fue Activado',
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


/**
 * GUARDAR USUARIO
 * 
 */

$(".btnGuardarUsuario").on("click",function () {

	var nombre = $(".formularioUsuario .nombreUsuario").val();
	var apellido = $(".formularioUsuario .apellidoUsuario").val();
	var tipoDocumento = $(".formularioUsuario .tipoDocumento").val();
	var numDocumento = $(".formularioUsuario .numDocumento").val();
	var direccion = $(".formularioUsuario .direccion").val();
	var cargo = $(".formularioUsuario .cargo").val();
	var ciudad = $(".formularioUsuario .ciudad").val();
	var telefono = $(".formularioUsuario .telefono").val();
	var email = $(".formularioUsuario .email").val();
	var login = $(".formularioUsuario .login").val();
	var passUsuario = $(".formularioUsuario .passUsuario").val();

	//console.log(apellido);

	if (nombre != "" && apellido != "" && numDocumento != "" && login != "" && passUsuario != "") {

		$uploadCrop.croppie('result', {

			type: 'canvas',
			size: 'viewport'

		}).then(function (resp) {


		    var datos = new FormData();
		    datos.append("nombre", nombre);
		    datos.append("apellido", apellido);
		    datos.append("tipoDocumento", tipoDocumento);
		    datos.append("numDocumento", numDocumento);
		    datos.append("direccion", direccion);
		    datos.append("cargo", cargo);
		    datos.append("ciudad", ciudad);
		    datos.append("telefono", telefono);
		    datos.append("email", telefono);
		    datos.append("loginUsuario", login);
		    datos.append("passUsuario", passUsuario);
		    datos.append("fotoUsuario", resp);

		    $.ajax({

		      url:"ajax/usuarios.ajax.php",
		      method: "POST",
		      data: datos,
		      cache: false,
		      contentType: false,
		      processData: false,
		      success: function(respuesta){
		        console.log(respuesta);
		        if(respuesta == 1){
				swal({
					  type: "success",
					  title: "El usuario ha sido creado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar"
					  }).then(function(result){
						if (result.value) {

						window.location = "usuarios";

						}
					})

		   //        swal({
		   //            title: "Perfil Creado",
		   //            text: "¡El Usuario ha sido creado correctamente!",
		   //            type: "success",
		   //            confirmButtonText: "¡Cerrar!",
		   //          },
		   //          function(isConfirm){

					// 	if(isConfirm){

					// 		window.location = "usuarios";
					// 	}

					// });
		      
		        }

		        
		      }

		    })


	  	});



	}else{

		swal({
			title: "¡ERROR AL GUARDAR!",
			text: "¡Los datos obligatorios deben llenarse!",
			type: "error",
			confirmButtonText: "Cerrar",
			// preConfirm: function() {
			// location.reload();
			//   	}
			});
	}



})



/**
	EDITAR USUARIOS

**/


$(".tablaUsuarios tbody").on("click", ".btnEditarUsuario", function(){
 
 	var idEditarUsuario =$(this).attr("idUsuario");

 	//console.log(idEditarUsuario);

	var datos = new FormData();
	datos.append("idEditarUsuario", idEditarUsuario);


	$.ajax({

		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			//console.log(respuesta);
			$("#modalEditarUsuario .editarIdUsuario").val(respuesta["id"]);
			$("#modalEditarUsuario .nombreUsuario").val(respuesta["nombre"]);
			$("#modalEditarUsuario .apellidoUsuario").val(respuesta["apellido"]);
			$("#modalEditarUsuario .editarTipoDocumento").val(respuesta["tipo_documento"]);
			$("#modalEditarUsuario .editarNumDocumento").val(respuesta["num_documento"]);
			$("#modalEditarUsuario .editarDireccion").val(respuesta["direccion"]);
			$("#modalEditarUsuario .editarCargo").val(respuesta["cargo"]);
			$("#modalEditarUsuario .editarCiudad").val(respuesta["ciudad"]);
			$("#modalEditarUsuario .editarTelefono").val(respuesta["telefono"]);
			$("#modalEditarUsuario .editarEmail").val(respuesta["email"]);
			$("#modalEditarUsuario .tagsInputTelefono").tagsinput('items');

			if (respuesta["tipo_documento"] == "DNI") {

				$("#modalEditarUsuario .editarNumDocumento").attr("maxlength", "8");



			}else{
				$("#modalEditarUsuario .editarNumDocumento").attr("maxlength", "12");


			}


			/*=============================================
			CARGAMOS LOS TELEFONOS
			=============================================*/	
			
			if(respuesta["telefono"] != null){

				$("#modalEditarUsuario .editarTelefonoUsuario").html('<label>Telefonos (*):</label>'+    
                
                '<input type="text" class="form-control input-lg tagsInputTelefono editarTelefono" value="'+respuesta["telefono"]+'" name="editarTelefono" >');

				$("#modalEditarUsuario .tagsInputTelefono").tagsinput('items');

			}else{

				$("#modalEditarUsuario .editarTelefonoUsuario").html('<label>Telefonos (*):</label>'+    
                
                '<input type="text" class="form-control input-lg tagsInputTelefono editarTelefono" placeholder="Ingresar Telefono" name="editarTelefono" >');

				$("#modalEditarUsuario .tagsInputTelefono").tagsinput('items');
			}
		}

	})
})


/**
	EDITAR USUARIOS

**/


$(".tablaUsuarios tbody").on("click", ".btnCambiarPassword", function(){
 
 	var idEditarUsuario =$(this).attr("idUsuario");

 	//console.log(idEditarUsuario);

	var datos = new FormData();
	datos.append("idEditarUsuario", idEditarUsuario);


	$.ajax({

		url: "ajax/usuarios.ajax.php",
		method: "POST",
		data: datos,
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json",
		success: function(respuesta){

			//console.log(respuesta);
			$("#modalCambiarPassword .PasswordIdUsuario").val(respuesta["id"]);
			$("#modalCambiarPassword .PasswordNombreUsuario").val(respuesta["nombre"] + " "+ respuesta["apellido"]);
			$("#modalCambiarPassword .apellidoUsuario").val();




		}

	})
})