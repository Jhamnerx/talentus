<link rel="stylesheet" href="<?php echo $url; ?>vistas/css/formstyle.css">
<?php 


$plantilla = ControladorPlantilla::ctrSeleccionarPlantilla();
$empresa = json_decode($plantilla["empresa"], true);

/*=============================================
INICIO DE SESIÓN USUARIO
=============================================*/

if(isset($_SESSION["validarSesion"])){

    if($_SESSION["validarSesion"] == "ok"){

        echo '<script>
        
            localStorage.setItem("usuario","'.$_SESSION["id"].'");

        </script>';

    }

}
?>
    <div class="form-body" class="container-fluid">

        <div class="website-logo">
            <a>
                <div class="logo">
                    <img class="logo-size" src="<?php echo $plantilla["logo"] ?>" alt="">
                </div>
            </a>
        </div>

        <div class="row">
            <div class="img-holder">
                <div class="bg" style=" background-image: url('<?php echo $plantilla["fondoLogin"] ?>'); "></div>
                <div class="info-holder">

                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <hr>
                        <h3><?php echo strtoupper($empresa[0]["nombre"]) ?>.</h3>
                        <p><?php echo $empresa[0]["lema"] ?>.</p>
                        <div class="page-links">
                            <a class="active">Iniciar Sesion</a>
                        </div>
                        <form method="post" class="formularioIngreso">
                            <input class="form-control username" type="text" name="username"  placeholder="usuario o correo" required>
                            <input class="form-control password" type="password" name="password" placeholder="Password" autocomplete="password" required>
                            <div class="form-button">

                                <button id="submit" type="submit" class="ibtn">INICIAR</button>
                            </div>
                            ¿Eres Cliente? | <strong><a href="#modalRegistro" data-dismiss="modal" data-toggle="modal">Registrate</a></strong>
                        </form>
                        <!-- <div class="other-links">
                            <span>Or login with</span><a href="#"><i class="fab fa-facebook-f"></i></a><a href="#"><i class="fab fa-google"></i></a><a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>


<!--=====================================
VENTANA MODAL PARA EL REGISTRO
======================================-->

<div class="modal fade" id="modalRegistro" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <form method="post" onsubmit="return registroUsuario()">
                    <!-- Form Title -->
                    <div class="form-heading text-center">
                        <div class="title">Registro</div>
                        <p class="title-description">Ya tienes una cuenta? <a href="#" data-toggle="modal" data-dismiss="modal">Ingresa.</a></p>
                        <!-- Social Line -->
                        <div class="social-line"> 
                            <a href="#"><i class="fa fa-facebook facebook"></i></a> 
                            <a href=""><i class="fa fa-google-plus"></i></a> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <input type="text" id="regUsuario" name="regUsuario" placeholder="Nombre Completo" required>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <input type="text" id="regNumDocumento" name="regNumDocumento" placeholder="Numero Documento" required>
                        
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="email" id="regEmail" name="regEmail" placeholder="Correo Electrónico" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            
                            <input type="password" id="regPassword" name="regPassword" placeholder="Contraseña" required>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input id="regPoliticas" type="checkbox" />
                            <label>Aceptas nuestros <a href="terminos-condiciones">terminos y condiciones</a>?</label>

                        </div>
                    </div>
                    <?php

                    $registro = new ControladorUsuarios();
                    $registro -> ctrRegistroClientes();

                    ?>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="modern-button modern-red">Crear Cuenta</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>