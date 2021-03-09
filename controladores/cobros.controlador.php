<?php

class ControladorCobros{

	/*=============================================
	MOSTRAR CLIENTES AYUDA
	=============================================*/

	static public function ctrMostrarClientes(){
        $empresa = [];
        $item = "tipo";
        $valor = "Cliente";
        $count = 0;
		    $tabla = "persona";

        $respuesta = ModeloPersona::mdlMostrarPersona($tabla, $item, $valor, $count);
        
        if($respuesta){
            
            for ($i=0; $i < count($respuesta) ; $i++) { 

      			 $empresa += [$respuesta[$i]['id'] => $respuesta[$i]['nombre'] ];
            }
            // $texto = substr($texto, 0, -1);
            // $texto.='}';

        }
        return json_encode($empresa);

    }
  /*=============================================
  MOSTRAR COBROS LISTA
  =============================================*/

  static public function ctrMostrarCobros($item, $valor){

    $tabla = "cobros";

    $respuesta = ModeloCobros::mdlMostrarCobros($tabla, $item, $valor);

    return $respuesta;

  } 

  /*=============================================
  REGISTRO COBROS LISTA
  =============================================*/

  static public function ctrMostrarRegistroCobro($item, $valor){

    $tabla = "registro_pagos";

    $respuesta = ModeloCobros::mdlMostrarRegistroCobro($tabla, $item, $valor);

    return $respuesta;

  } 

    /**
     * CREAR REGISTRO COBRO
     */

    static public function ctrCrearRegistroCobro(){

        if (isset($_POST["nameEmpresa"])) {

            $datos = array(
                        'empresa' =>$_POST["nameEmpresa"],
                        'estado' =>"2",
                        'fechaVencimiento'=>$_POST["fecha_hora"],
                        'periodo'=>$_POST["periodo"],
                        'monto'=>$_POST["monto"],
                        'cantidadunidad'=>$_POST["cantidadunidad"],
                        'ciudad'=>$_POST["ciudad"],
                        'tipoPago'=>$_POST["tipoPago"],
                        'observacion'=>$_POST["observacion"]
                        );

            $tabla="cobros";

            $respuesta= ModeloCobros::mdlIngresarCobro($tabla, $datos);

            if($respuesta == 1){

                echo'<script>

                swal({
                      type: "success",
                      title: "Se añadido Correctament El Registro",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      }).then(function(result){
                        if (result.value) {

                        window.location = "cobros";

                        }
                    })

                </script>';

            }else{

            echo'<script>

                swal({
                      type: "error",
                      title: "¡Los datos no pueden llevar caracteres especiales o vacios!",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      })

            </script>';

            return;

            }

        }

    }


    public static function ctrEditarRegistroCobro(){


    	if (isset($_POST["idEditarCobro"])) {

            $datos = array(
                        'idCobro'=>$_POST["idEditarCobro"],
                        'empresa' =>$_POST["editarEmpresa"],
                        'fechaVencimiento'=>$_POST["editarFecha"],
                        'periodo'=>$_POST["editarPeriodo"],
                        'monto'=>$_POST["editarMonto"],
                        'cantidadunidad'=>$_POST["editarCantidadunidad"],
                        'ciudad'=>$_POST["editarCiudad"],
                        'tipoPago'=>$_POST["editarTipoPago"],
                        'observacion'=>$_POST["editarObservacion"]
                        );

            $tabla= "cobros";

            $respuesta = ModeloCobros::mdlEditarCobro($tabla, $datos);

          

            if($respuesta == 1){

                echo'<script>

                swal({
                      type: "success",
                      title: "Edicion Exitosa",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      }).then(function(result){
                        if (result.value) {

                        window.location = "cobros";

                        }
                    })

                </script>';

            }else{

            echo'<script>

                swal({
                      type: "error",
                      title: "¡Los datos no pueden llevar caracteres especiales o vacios!",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      })

            </script>';

            return;

            }
    	}


    }





/**
 * MARCAR PAGADO REGISTRO
 */

    public static function ctrPagarRegistroCobro(){


      if (isset($_POST["pagarIdCobro"])) {

            $datosCobro = array(
                        'idCobro'=>$_POST["pagarIdCobro"],
                        'estado'=>"2",
                        'fechaVencimiento'=>$_POST["pagarFecha"],
                        'tipoPago'=>$_POST["pagoTipoPago"],
                        );

            $tabla= "cobros";




            $respuesta = ModeloCobros::mdlPagarCobro($tabla, $datosCobro);

            $datosRegistro = array(
                        'idCobro'=>$_POST["pagarIdCobro"],
                        'tipoPago'=>$_POST["pagoTipoPago"],
                        'cantidad'=>$_POST["cantidadPago"],
                        'descripcion'=>$_POST["pagoDescripcion"]
                        );


            $respuesta1 = ModeloCobros::mdlCrearRegistroPago("registro_pagos", $datosRegistro);


            $notificaciones = ModeloNotificaciones::mdlMostrarNotificaciones("notificaciones","idCobro", $_POST["pagarIdCobro"]);


            if ($notificaciones) {

             $respuesta = ModeloNotificaciones::mdlEliminarNotificacion("notificaciones", $_POST["pagarIdCobro"]);

            }


            if($respuesta == 1){

                echo'<script>

                swal({
                      type: "success",
                      title: "Registro Pagado",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      }).then(function(result){
                        if (result.value) {

                        window.location = "cobros";

                        }
                    })

                </script>';

            }else{

            echo'<script>

                swal({
                      type: "error",
                      title: "¡Los datos no pueden llevar caracteres especiales o vacios!",
                      showConfirmButton: true,
                      confirmButtonText: "Cerrar"
                      })

            </script>';

            return;

            }
      }


    }

}
