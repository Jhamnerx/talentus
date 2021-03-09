$(".editarRol ").on("click", function(){
	$(".permiso").iCheck('uncheck');
	var idRol = $(this).attr("idRol");

      if (idRol == 1) {

            $(".nombreRol").val("ADMIN");
            $(".idRolGuardar").val(1);

      }
	if (idRol == 2) {

		$(".nombreRol").val("CAJERA");
            $(".idRolGuardar").val(2);

	}
	if (idRol == 3) {

		$(".nombreRol").val("SECRETARIA");
            $(".idRolGuardar").val(3);

	}
	if (idRol == 4) {

		$(".nombreRol").val("EMPLEADO");
            $(".idRolGuardar").val(4);

	}
	if (idRol == 5) {

		$(".nombreRol").val("ADMINISTRADORA");
            $(".idRolGuardar").val(5);

	}
      if (idRol == 6) {

            $(".nombreRol").val("TECNICO");
            $(".idRolGuardar").val(6);

      }
	var datos = new FormData();
	datos.append("idRol", idRol);
    $.ajax({

      url:"ajax/roles.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta){
            //console.log(respuesta);
      	function ArrayPermiso(element, index, array) {

      		//console.log(element.estado);

      		if (element.estado == "true") {
		      	$("."+element.permiso).iCheck('check');
                        $(".idRolGuardar").val(element.rol);

		      	//console.log(".permiso ."+element.permiso)
      		}



      	}

      	respuesta.forEach(ArrayPermiso);

      }

  })


})


$(".btnGuardRol").on("click", function(){
      var idRolGuardar = $(".idRolGuardar").val();
      var Palmacen = $(".almacen").iCheck('update')[0].checked;
      var Pcompras = $(".compras").iCheck('update')[0].checked;
      var Pventas = $(".ventas").iCheck('update')[0].checked;
      var Pvehiculos = $(".vehiculos").iCheck('update')[0].checked;
      var Padministracion = $(".administracion").iCheck('update')[0].checked;
      var Ptecnico = $(".tecnico").iCheck('update')[0].checked;


      var datos = new FormData();
      datos.append("idRolGuardar", idRolGuardar);
      datos.append("Palmacen", Palmacen);
      datos.append("Pcompras", Pcompras);
      datos.append("Pventas", Pventas);
      datos.append("Pvehiculos", Pvehiculos);
      datos.append("Padministracion", Padministracion);
      datos.append("Ptecnico", Ptecnico);
      $.ajax({
            url:"ajax/roles.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function(respuesta){
                  
                 // console.log("respuesta", respuesta);

                  if(respuesta != ""){

                        swal({
                          type: "success",
                          title: "Rol Guardado",
                          showConfirmButton: true,
                          confirmButtonText: "Cerrar"
                          }).then(function(result){
                              if (result.value) {

                              window.location = "plantilla";

                              }
                        })
                  }

            }

      })


})