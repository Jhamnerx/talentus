<?php

require_once "../controladores/plantilla.controlador.php";
require_once "../modelos/plantilla.modelo.php";

class AjaxPlantilla{

	/*=============================================
	CAMBIAR LOGOTIPO
	=============================================*/	

	public $imagenLogo;

	public function ajaxCambiarLogotipo(){

		$item = "logo";
		$valor = $this->imagenLogo;

		$respuesta = ControladorPlantilla::ctrActualizarLogoIcono($item, $valor);

		echo $respuesta;


	}

	/*=============================================
	CAMBIAR ICONO
	=============================================*/

	public $imagenIcono;	

	public function ajaxCambiarIcono(){

		$item = "icono";
		$valor = $this->imagenIcono;

		$respuesta = ControladorPlantilla::ctrActualizarLogoIcono($item, $valor);

		echo $respuesta;

	}

	/*=============================================
	CAMBIAR BACKGROUNd
	=============================================*/

	public $imagenBackground;	

	public function ajaxCambiarBackground(){

		$item = "fondoLogin";
		$valor = $this->imagenBackground;

		$respuesta = ControladorPlantilla::ctrActualizarLogoIcono($item, $valor);

		echo $respuesta;


	}
	/*=============================================
	CAMBIAR FONDO CONTRATO
	=============================================*/

	public $imagenContrato;	

	public function ajaxCambiarContrato(){

		$item = "fondoContrato";
		$valor = $this->imagenContrato;

		$respuesta = ControladorPlantilla::ctrActualizarLogoIcono($item, $valor);
		
		echo $respuesta;

	}
	/*=============================================
	CAMBIAR FONDO ACTA
	=============================================*/

	public $imagenActa;	

	public function ajaxCambiarActa(){

		$item = "fondoActa";
		$valor = $this->imagenActa;

		$respuesta = ControladorPlantilla::ctrActualizarLogoIcono($item, $valor);

		echo $respuesta;
		//echo json_encode($valor);

	}
	/*=============================================
	CAMBIAR FONDO CERTIFICADO
	=============================================*/

	public $imagenCertificado;	

	public function ajaxCambiarCertificado(){

		$item = "fondoCertificado";
		$valor = $this->imagenCertificado;

		$respuesta = ControladorPlantilla::ctrActualizarLogoIcono($item, $valor);

		echo $respuesta;

	}


	/*=============================================
	CAMBIAR FONDO FIRMA
	=============================================*/

	public $imagenFirma;	

	public function ajaxCambiarFirma(){

		$item = "fondoFirma";
		$valor = $this->imagenFirma;

		$respuesta = ControladorPlantilla::ctrActualizarLogoIcono($item, $valor);

		echo $respuesta;

	}


	/*=============================================
	CAMBIAR COLORES
	=============================================*/

	public $barraSuperior;
	public $textoSuperior;
	public $colorFondo;
	public $colorTexto;	

	public function ajaxCambiarColor(){

		$datos = array("barraSuperior"=>$this->barraSuperior,
					   "textoSuperior"=>$this->textoSuperior,
					   "colorFondo"=>$this->colorFondo,
					   "colorTexto"=>$this->colorTexto);

		$respuesta = ControladorPlantilla::ctrActualizarColores($datos);

		echo $respuesta;

	}

	/*=============================================
	CAMBIAR REDES SOCIALES
	=============================================*/

	public $redesSociales;

	public function ajaxCambiarRedes(){

		$item = "redesSociales";
		$valor = $this->redesSociales;

		$respuesta = ControladorPlantilla::ctrActualizarLogoIcono($item, $valor);

		echo $respuesta;

	}

	/*=============================================
	CAMBIAR SCRIPT
	=============================================*/

	public $apiFacebook;
	public $pixelFacebook;
	public $googleAnalytics;

	public function ajaxCambiarScript(){

		$datos = array("apiFacebook"=>$this->apiFacebook,
					   "pixelFacebook"=>$this->pixelFacebook,
					   "googleAnalytics"=>$this->googleAnalytics);

		$respuesta = ControladorPlantilla::ctrActualizarScript($datos);

		echo $respuesta;

	}

	/*=============================================
	CAMBIAR INFORMACIÓN
	=============================================*/

	public $impuesto;
	public $envioNacional;
	public $envioInternacional;
	public $tasaMinimaNal;
	public $tasaMinimaInt;
	public $seleccionarPais;
	public $modoPaypal;
	public $clienteIdPaypal;
	public $llaveSecretaPaypal;
	public $modoPayu;
	public $merchantIdPayu;
	public $accountIdPayu;
	public $apiKeyPayu;

	public function ajaxCambiarInformacion(){

		$datos = array("impuesto"=>$this->impuesto,
						"envioNacional"=>$this->envioNacional,
						"envioInternacional"=>$this->envioInternacional,
						"tasaMinimaNal"=>$this->tasaMinimaNal,
						"tasaMinimaInt"=>$this->tasaMinimaInt,
						"seleccionarPais"=>$this->seleccionarPais,
						"modoPaypal"=>$this->modoPaypal,
						"clienteIdPaypal"=>$this->clienteIdPaypal,
						"llaveSecretaPaypal"=>$this->llaveSecretaPaypal,
						"modoPayu"=>$this->modoPayu,
						"merchantIdPayu"=>$this->merchantIdPayu,
						"accountIdPayu"=>$this->accountIdPayu,
						"apiKeyPayu"=>$this->apiKeyPayu);

		$respuesta = ControladorPlantilla::ctrActualizarInformacion($datos);

		echo $respuesta;

	}


	/*=============================================
	CAMBIAR INFORMACIÓN EMPRESA
	=============================================*/

	public $datosEmpresa;

	public function ajaxCambiarInformacionEmpresa(){

		$item = "empresa";
		$valor = $this->datosEmpresa;

		$respuesta = ControladorPlantilla::ctrActualizarEmpresa($item, $valor);

		echo $respuesta;

	}


}

/*=============================================
CAMBIAR LOGOTIPO
=============================================*/	
if(isset($_FILES["imagenLogo"])){

	$logotipo = new AjaxPlantilla();
	$logotipo -> imagenLogo = $_FILES["imagenLogo"];
	$logotipo -> ajaxCambiarLogotipo();

}

/*=============================================
CAMBIAR ICONO
=============================================*/	
if(isset($_FILES["imagenIcono"])){

	$icono = new AjaxPlantilla();
	$icono -> imagenIcono = $_FILES["imagenIcono"];
	$icono -> ajaxCambiarIcono();

}

/*=============================================
CAMBIAR BACKGROUND
=============================================*/	
if(isset($_FILES["imagenBackground"])){

	$background = new AjaxPlantilla();
	$background -> imagenBackground = $_FILES["imagenBackground"];
	$background -> ajaxCambiarBackground();

}

/*=============================================
CAMBIAR FONDO CONTRATO
=============================================*/	
if(isset($_FILES["imagenContrato"])){

	$contrato = new AjaxPlantilla();
	$contrato -> imagenContrato = $_FILES["imagenContrato"];
	$contrato -> ajaxCambiarContrato();

}


/*=============================================
CAMBIAR FONDO ACTA
=============================================*/	
if(isset($_FILES["imagenActa"])){

	$acta = new AjaxPlantilla();
	$acta -> imagenActa = $_FILES["imagenActa"];
	$acta -> ajaxCambiarActa();

}

/*=============================================
CAMBIAR FONDO CERTIFICADO
=============================================*/	
if(isset($_FILES["imagenCertificado"])){

	$certificado = new AjaxPlantilla();
	$certificado -> imagenCertificado = $_FILES["imagenCertificado"];
	$certificado -> ajaxCambiarCertificado();

}

/*=============================================
CAMBIAR FONDO FIRMA
=============================================*/	
if(isset($_FILES["imagenFirma"])){

	$firma = new AjaxPlantilla();
	$firma -> imagenFirma = $_FILES["imagenFirma"];
	$firma -> ajaxCambiarFirma();

}

/*=============================================
CAMBIAR COLORES
=============================================*/	

if(isset($_POST["barraSuperior"])){

	$colores = new AjaxPlantilla();
	$colores -> barraSuperior = $_POST["barraSuperior"];
	$colores -> textoSuperior = $_POST["textoSuperior"];
	$colores -> colorFondo = $_POST["colorFondo"];
	$colores -> colorTexto = $_POST["colorTexto"];
	$colores -> ajaxCambiarColor();

}


/*=============================================
CAMBIAR REDES SOCIALES
=============================================*/	

if(isset($_POST["redesSociales"])){

	$redesSociales = new AjaxPlantilla();
	$redesSociales -> redesSociales = $_POST["redesSociales"];
	$redesSociales -> ajaxCambiarRedes();

}

/*=============================================
CAMBIAR SCRIPT
=============================================*/	

if(isset($_POST["apiFacebook"])){

	$script = new AjaxPlantilla();
	$script -> apiFacebook = $_POST["apiFacebook"];
	$script -> pixelFacebook = $_POST["pixelFacebook"];
	$script -> googleAnalytics = $_POST["googleAnalytics"];
	$script -> ajaxCambiarScript();

}

/*=============================================
CAMBIAR INFORMACION
=============================================*/	

if(isset($_POST["impuesto"])){

	$informacion = new AjaxPlantilla();
	$informacion -> impuesto = $_POST["impuesto"];
	$informacion -> envioNacional = $_POST["envioNacional"];
	$informacion -> envioInternacional = $_POST["envioInternacional"];
	$informacion -> tasaMinimaNal = $_POST["tasaMinimaNal"];
	$informacion -> tasaMinimaInt = $_POST["tasaMinimaInt"];
	$informacion -> seleccionarPais = $_POST["seleccionarPais"];
	$informacion -> modoPaypal = $_POST["modoPaypal"];
	$informacion -> clienteIdPaypal = $_POST["clienteIdPaypal"];
	$informacion -> llaveSecretaPaypal = $_POST["llaveSecretaPaypal"];
	$informacion -> modoPayu = $_POST["modoPayu"];
	$informacion -> merchantIdPayu = $_POST["merchantIdPayu"];
	$informacion -> accountIdPayu = $_POST["accountIdPayu"];
	$informacion -> apiKeyPayu = $_POST["apiKeyPayu"];
	$informacion -> ajaxCambiarInformacion();

}

/*=============================================
CAMBIAR INFORMACION EMPRESA
=============================================*/	

if(isset($_POST["empresa"])){

	$empresa = new AjaxPlantilla();
	$empresa -> datosEmpresa = $_POST["empresa"];
	$empresa -> ajaxCambiarInformacionEmpresa();

}