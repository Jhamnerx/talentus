/*=============================================
LOADER
=============================================*/
var myVar;

function loaderPagina() {
    myVar = setTimeout(showPage(), 200);
}

function showPage() {

    //$("#spinner-content").classList.add("spinner-hidden");
    $("#spinner-content").addClass("spinner-hidden");

    setTimeout(removeSpinner(), 1000);
}

function removeSpinner() {

    //document.getElementById("spinner-content").style.display = "none";
    $(".spinner-content").css("display", "none");
}

/*=============================================
ENLACES PAGINACIÓN
=============================================*/

var url = window.location.href;

var indice = url.split("/");




var pagActual = indice[4];

if (pagActual == "" || pagActual == "inicio") {

  localStorage.removeItem("botonera");
}


/* iCheck */

$('input').iCheck({
	checkboxClass: 'icheckbox_square-blue',
	radioClass: 'iradio_square-blue',
	increaseArea: '20%' // optional
});


$(document).ready(function(){

});
/* jQueryKnob */
$('.knob').knob();

/* SideBar Menu */
$('.sidebar-menu').tree();

//Colorpicker
$('.my-colorpicker').colorpicker();

//Tags Input
$(".tagsInput").tagsinput({
	maxTags: 10,
	confirmKeys: [44],
	cancelConfirmKeysOnEmpty: false,
 	trimValue: false
})


  $(".tagsInputTelefono").tagsinput({
    maxTags: 10,
    maxChars: 9,
    confirmKeys: [44],
    cancelConfirmKeysOnEmpty: false,
    trimValue: false
  })




$(".bootstrap-tagsinput").css({"padding":"6px",
							   "width":"100%",
 							   "border-radius":"1px"})

//Datepicker	
$('.datepicker').datepicker({
	format: 'dd/mm/yyyy',
  autoclose: true
});

/*=============================================
CORRECCIÓN BOTONERAS OCULTAS BACKEND	
=============================================*/

if(window.matchMedia("(max-width:767px)").matches){
	
	$("body").removeClass('sidebar-collapse');

}else{

	// $("body").addClass('sidebar-collapse');
}

/*=============================================
ACTIVAR SIDEBAR
=============================================*/

$(document).on("click", ".sidebar-menu .inicio", function(){

	localStorage.setItem("botonera", $(this).children().attr("href"));

})

$(document).on("click", ".sidebar-menu .treeview li", function(){

	localStorage.setItem("botonera", $(this).children().attr("href"));

})

if(localStorage.getItem("botonera") == "inicio"){

	$(".sidebar-menu li").removeClass("active");

	$(".sidebar-menu li a[href='inicio']").parent().addClass("active")
	
}else{

	$(".sidebar-menu li").removeClass("active");

	$("a[href='"+localStorage.getItem("botonera")+"']").parent().parent().parent().addClass("active")
	
}

var rutaOculta = $(".rutaOculta").val();


  /* The todo list plugin */
  $('.todo-list').todoList({
    onCheck  : function () {
      window.console.log($(this), 'The element has been checked');
    },
    onUnCheck: function () {
      window.console.log($(this), 'The element has been unchecked');
    }
  });


  function ClearUrl(cadena){
   // Definimos los caracteres que queremos eliminar
   var charEspeciales = "!@#$^&%*()+=-[]\/{}|:<>?,.";

   // Los eliminamos todos
   for (var i = 0; i < charEspeciales.length; i++) {
   
       cadena = cadena.replace(new RegExp("\\" + charEspeciales[i], 'gi'), '');
	   
   }   


   // Quitamos espacios y los sustituimos por - 
   cadena = cadena.replace(/ /g,"-");

   // Quitamos acentos y "ñ". Fijate en que va sin comillas el primer parametro
   cadena = cadena.replace(/á/gi,"a");
   cadena = cadena.replace(/é/gi,"e");
   cadena = cadena.replace(/í/gi,"i");
   cadena = cadena.replace(/ó/gi,"o");
   cadena = cadena.replace(/ú/gi,"u");
   cadena = cadena.replace(/ñ/gi,"n");
   return cadena;

}

    //Date picker
    $('#datepicker').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
    /**
     * SELECT 2
     * 
     */
     $('.select2').select2()

/*=============================================
SUBIR LOGOTIPO
=============================================*/

$("#subirLogo").change(function(){

  var imagenLogo = this.files[0];

  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(imagenLogo["type"] != "image/jpeg" && imagenLogo["type"] != "image/png"){

      $("#subirLogo").val("");

      swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(imagenLogo["size"] > 4000000){

      $("#subirLogo").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    PREVISUALIZAMOS LA IMAGEN
    =============================================*/

    }else{

      var datosImagen = new FileReader;
      datosImagen.readAsDataURL(imagenLogo);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarLogo").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL LOGOTIPO
    =============================================*/

    $("#guardarLogo").click(function(){

      var datos = new FormData();
      datos.append("imagenLogo", imagenLogo);

      $.ajax({

      url:"ajax/plantilla.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        console.log(respuesta);
        if(respuesta == 1){
          swal({
              title: "Cambios guardados",
              text: "¡La plantilla ha sido actualizada correctamente!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){
            if (result.value) {

            window.location = "plantilla";

            }
          });
      
        }

        
      }

    })


    })

})

/*=============================================
SUBIR ICONO
=============================================*/

$("#subirIcono").change(function(){

  var imagenIcono = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(imagenIcono["type"] != "image/jpeg" && imagenIcono["type"] != "image/png"){

      $("#subirIcono").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(imagenIcono["size"] > 4000000){

      $("#subirIcono").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

  /*=============================================
    PREVISUALIZAMOS LA IMAGEN
    =============================================*/

    }else{

      var datosImagen = new FileReader;
      datosImagen.readAsDataURL(imagenIcono);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarIcono").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL ICONO
    =============================================*/

    $("#guardarIcono").click(function(){

    var datos = new FormData();
    datos.append("imagenIcono", imagenIcono);

    $.ajax({

      url:"ajax/plantilla.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        console.log(respuesta);
        
        if(respuesta == 1){

          swal({
              title: "Cambios guardados",
              text: "¡La plantilla ha sido actualizada correctamente!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){
            if (result.value) {

            window.location = "plantilla";

            }
          });
      
        }
    
      }

    });

  })

})




/*=============================================
SUBIR BACKGROUND
=============================================*/

$("#subirBackground").change(function(){

  var imagenBackground = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(imagenBackground["type"] != "image/jpeg" && imagenBackground["type"] != "image/png"){

      $("#subirBackground").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(imagenBackground["size"] > 4000000){

      $("#subirBackground").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

  /*=============================================
    PREVISUALIZAMOS LA IMAGEN
    =============================================*/

    }else{

      var datosImagen = new FileReader;
      datosImagen.readAsDataURL(imagenBackground);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarBackground").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL BACKGROUND
    =============================================*/

    $("#guardarBackground").click(function(){

    var datos = new FormData();
    datos.append("imagenBackground", imagenBackground);

    $.ajax({

      url:"ajax/plantilla.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        console.log(respuesta);
        
        if(respuesta == 1){

          swal({
              title: "Cambios guardados",
              text: "¡La plantilla ha sido actualizada correctamente!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){
            if (result.value) {

            window.location = "plantilla";

            }
          });
      
        }
    
      }

    });

  })

})




/*=============================================
SUBIR FONDO CONTRATO
=============================================*/

$("#subirContrato").change(function(){

  var imagenContrato = this.files[0];

  //console.log(imagenContrato);
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(imagenContrato["type"] != "image/jpeg" && imagenContrato["type"] != "image/png"){

      $("#subirContrato").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(imagenContrato["size"] > 4000000){

      $("#subirContrato").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

  /*=============================================
    PREVISUALIZAMOS LA IMAGEN
    =============================================*/

    }else{

      var datosImagen = new FileReader;
      datosImagen.readAsDataURL(imagenContrato);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarContrato").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL CONTRATO
    =============================================*/

    $("#guardarContrato").click(function(){

    var datosContrato = new FormData();
    datosContrato.append("imagenContrato", imagenContrato);

    //console.log(datosContrato);

    $.ajax({

      url:"ajax/plantilla.ajax.php",
      method: "POST",
      data: datosContrato,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        //console.log(respuesta);
        
        if(respuesta == 1){

          swal({
              title: "Cambios guardados",
              text: "¡La plantilla ha sido actualizada correctamente!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){
            if (result.value) {

            window.location = "plantilla";

            }
          });
      
        }
    
      }

    });

  })

})

/*=============================================
SUBIR FONDO ACTA
=============================================*/

$("#subirActa").change(function(){

  var imagenActa = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(imagenActa["type"] != "image/jpeg" && imagenActa["type"] != "image/png"){

      $("#subirActa").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(imagenActa["size"] > 4000000){

      $("#subirActa").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

  /*=============================================
    PREVISUALIZAMOS LA IMAGEN
    =============================================*/

    }else{

      var datosImagen = new FileReader;
      datosImagen.readAsDataURL(imagenActa);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarActa").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL ACTA
    =============================================*/

    $("#guardarActa").click(function(){

    var datos = new FormData();
    datos.append("imagenActa", imagenActa);

    $.ajax({

      url:"ajax/plantilla.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        console.log(respuesta);
        
        if(respuesta == 1){

          swal({
              title: "Cambios guardados",
              text: "¡La plantilla ha sido actualizada correctamente!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){
            if (result.value) {

            window.location = "plantilla";

            }
          });
      
        }
    
      }

    });

  })

})



/*=============================================
SUBIR FONDO CERTIFICADO
=============================================*/

$("#subirCertificado").change(function(){

  var imagenCertificado = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(imagenCertificado["type"] != "image/jpeg" && imagenCertificado["type"] != "image/png"){

      $("#subirCertificado").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(imagenCertificado["size"] > 4000000){

      $("#subirCertificado").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

  /*=============================================
    PREVISUALIZAMOS LA IMAGEN
    =============================================*/

    }else{

      var datosImagen = new FileReader;
      datosImagen.readAsDataURL(imagenCertificado);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarCertificado").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR EL CERTIFICADO
    =============================================*/

    $("#guardarCertificado").click(function(){

    var datos = new FormData();
    datos.append("imagenCertificado", imagenCertificado);

    $.ajax({

      url:"ajax/plantilla.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        console.log(respuesta);
        
        if(respuesta == 1){

          swal({
              title: "Cambios guardados",
              text: "¡La plantilla ha sido actualizada correctamente!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){
            if (result.value) {

            window.location = "plantilla";

            }
          });
      
        }
    
      }

    });

  })

})





////////////////////

/*=============================================
SUBIR FONDO FIRMA
=============================================*/

$("#subirFirma").change(function(){

  var imagenFirma = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(imagenFirma["type"] != "image/jpeg" && imagenFirma["type"] != "image/png"){

      $("#subirFirma").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    /*=============================================
    VALIDAMOS EL TAMAÑO DE LA IMAGEN
    =============================================*/

    }else if(imagenFirma["size"] > 4000000){

      $("#subirFirma").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

  /*=============================================
    PREVISUALIZAMOS LA IMAGEN
    =============================================*/

    }else{

      var datosImagen = new FileReader;
      datosImagen.readAsDataURL(imagenFirma);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $(".previsualizarFirma").attr("src", rutaImagen);

      })

    }

    /*=============================================
    GUARDAR FIRMA
    =============================================*/

    $("#guardarFirma").click(function(){

    var datos = new FormData();
    datos.append("imagenFirma", imagenFirma);

    $.ajax({

      url:"ajax/plantilla.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        console.log(respuesta);
        
        if(respuesta == 1){

          swal({
              title: "Cambios guardados",
              text: "¡La plantilla ha sido actualizada correctamente!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){
            if (result.value) {

            window.location = "plantilla";

            }
          });
    
        }
    
      }

    });

  })

})

/*=============================================
CAMBIAR COLOR REDES SOCIALES
=============================================*/

var checkBox = $(".seleccionarRed");

$("input[name='colorRedSocial']").on("ifChecked", function(){

  var color = $(this).val();
  var colorRed = null;

  var iconos = $(".redSocial");
  var redes = ["facebook", "youtube","twitter","google-plus","instagram", "pinterest"];
  
  if(color == "color"){

    colorRed = "Color";

  }else if(color == "blanco"){

    colorRed = "Blanco";

  }else{

    colorRed = "Negro";

  }

  for(var i = 0; i < iconos.length; i++){

    $(iconos[i]).attr("class","fa fa-"+redes[i]+" "+redes[i]+colorRed+" redSocial");
    $(checkBox[i]).attr("estilo", redes[i]+colorRed);

  }

  crearDatosJsonRedes();

})



/*=============================================
CAMBIAR URL REDES SOCIALES
=============================================*/
$(".cambiarUrlRed").change(function(){

  var cambiarUrlRed = $(".cambiarUrlRed");

  for(var i = 0; i < cambiarUrlRed.length; i++){

    $(checkBox[i]).attr("ruta", $(cambiarUrlRed[i]).val());

  }

  crearDatosJsonRedes();

})

/*=============================================
QUITAR RED SOCIAL
=============================================*/
$(".seleccionarRed").on("ifUnchecked",function(){

  $(this).attr("validarRed","");

  crearDatosJsonRedes();

})


/*=============================================
AGREGAR RED SOCIAL
=============================================*/

$(".seleccionarRed").on("ifChecked",function(){

  $(this).attr("validarRed", $(this).attr("red"));

  crearDatosJsonRedes();

})

/*=============================================
CREAR DATOS JSON PARA ALMACENAR EN BD
=============================================*/


function crearDatosJsonRedes(){

  var redesSociales = [];

  for(var i = 0; i < checkBox.length; i++){

    if($(checkBox[i]).attr("validarRed") != ""){

      redesSociales.push({"red": $(checkBox[i]).attr("red"),
                "estilo": $(checkBox[i]).attr("estilo"),
                "url": $(checkBox[i]).attr("ruta"),
                "activo": 1})


    }else{

      redesSociales.push({"red": $(checkBox[i]).attr("red"),
                "estilo": $(checkBox[i]).attr("estilo"),
                "url": $(checkBox[i]).attr("ruta"),
                "activo": 0})

    }

    $("#valorRedesSociales").val(JSON.stringify(redesSociales));

  }

}

/*=============================================
GUARDAR REDES SOCIALES
=============================================*/

$("#guardarRedesSociales").click(function(){

  var valorRedesSociales = $("#valorRedesSociales").val();

  var datos = new FormData();
  datos.append("redesSociales", valorRedesSociales);

  $.ajax({

    url:"ajax/plantilla.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function(respuesta){

      if(respuesta == 1){

        swal({
            title: "Cambios guardados",
            text: "¡La plantilla ha sido actualizada correctamente!",
            type: "success",
            confirmButtonText: "¡Cerrar!"
          }).then(function(result){
            if (result.value) {

            window.location = "plantilla";

            }
          });
    
      }

    }

  })

})


/*=============================================
CAMBIAR INFORMACIÓN EMPRESA
=============================================*/

$(".cambioEmpresa").change(function(){

  var nombre = $("#nombre").val();
  var telefono = $("#telefono").val();
  var direccion = $("#direccion").val();
  var provincia = $("#provincia").val();
  var pais = $("#pais").val();
  var correo = $("#correo").val();
  var lema = $("#lema").val();
  var cuenta = $("#cuenta").val();
  var ruc = $("#ruc").val();


  /*=============================================
  // FUNCIÓN PARA CAMBIAR LA INFORMACIÓN EMPRESA
  =============================================*/

  $("#guardarEmpresa").click(function(){

    var DatosEmpresa = [];


    DatosEmpresa.push({
              "nombre": nombre,
              "telefono": telefono,
               "direccion": direccion,
               "provincia": provincia,
               "pais": pais,
               "lema": lema,
               "cuenta": cuenta,
               "ruc": ruc,
               "correo": correo})


    guardarDatos = JSON.stringify(DatosEmpresa);

    console.log(guardarDatos);

    var datos = new FormData();

    datos.append("empresa", guardarDatos);


    $.ajax({

      url:"ajax/plantilla.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        
        if(respuesta == 1){

          swal({
              title: "Cambios guardados",
              text: "¡Informacion de Empresa Guardada!",
              type: "success",
              confirmButtonText: "¡Cerrar!"
            }).then(function(result){
            if (result.value) {

            window.location = "plantilla";

            }
          });
        
        }
                
      }

    })

  })

})
