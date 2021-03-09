<?php
session_start();
date_default_timezone_set("America/Lima");
setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
require_once "modelos/categorias.modelo.php";
require_once "modelos/servicios.modelo.php";
require_once "modelos/persona.modelo.php";
require_once "modelos/ingresos.modelo.php";
require_once "modelos/cobros.modelo.php";
require_once "modelos/ventas.modelo.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/flotas.modelo.php";
require_once "modelos/contratos.modelo.php";
require_once "modelos/plantilla.modelo.php";
require_once "modelos/vehiculos.modelo.php";
require_once "modelos/contacto.modelo.php";
require_once "modelos/actas.modelo.php";
require_once "modelos/ciudad.modelo.php";
require_once "modelos/certificado.modelo.php";
require_once "modelos/dispositivos.modelo.php";
require_once "modelos/notificaciones.modelo.php";
require_once "modelos/roles.modelo.php";
require_once "modelos/lineas.modelo.php";
require_once "modelos/reportes.modelo.php";
require_once "modelos/tarea.modelo.php";
require_once "modelos/recibo.modelo.php";
require_once "modelos/slide.modelo.php";

require_once "modelos/rutas.php";

require_once "controladores/utiles.php";
require_once "controladores/categorias.controlador.php";
require_once "controladores/servicios.controlador.php";
require_once "controladores/persona.controlador.php";
require_once "controladores/ingresos.controlador.php";
require_once "controladores/cobros.controlador.php";
require_once "controladores/ventas.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/flotas.controlador.php";
require_once "controladores/contratos.controlador.php";
require_once "controladores/vehiculos.controlador.php";
require_once "controladores/contacto.controlador.php";
require_once "controladores/actas.controlador.php";
require_once "controladores/ciudad.controlador.php";
require_once "controladores/certificado.controlador.php";
require_once "controladores/dispositivos.controlador.php";
require_once "controladores/notificaciones.controlador.php";

require_once "controladores/roles.controlador.php";
require_once "controladores/lineas.controlador.php";
require_once "controladores/reportes.controlador.php";
require_once "controladores/tarea.controlador.php";
require_once "controladores/recibo.controlador.php";
require_once "controladores/slide.controlador.php";


require_once "controladores/plantilla.controlador.php";


require_once "extensiones/PHPMailer/PHPMailerAutoload.php";
require_once "extensiones/vendor/autoload.php";

$plantilla = new ControladorPlantilla();
$plantilla -> plantilla();