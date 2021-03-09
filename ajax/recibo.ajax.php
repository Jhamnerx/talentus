<?php
require_once '../controladores/recibo.controlador.php';
require_once '../modelos/recibo.modelo.php';

class AjaxRecibo
{

	/*=============================================
  	GUARDAR RECIBO
  	=============================================*/
  	public $idcliente;
  	public $nEmpresa;
  	public $num_recibo;
  	public $tipoPago;
  	public $total_recibo;
  	public $divisa;
  	public $fecha;
		public $fechaPago;
  	public $item;
  	public $cantidad;
  	public $precio;


	public function ajaxGuardarRecibo()
	{

	  	$datos = array("idcliente"=>$this->idcliente,
	  				   "empresa"=>$this->nEmpresa,
	  				   "num_recibo"=>$this->num_recibo,
	  				   "tipoPago"=>$this->tipoPago,
	  				   "total_recibo"=>$this->total_recibo,
	  				   "fecha"=>$this->fecha,
							 "fechaPago"=>$this->fechaPago,
	  				   "divisa"=>$this->divisa,
	  				   "item"=>$this->item,
	  				   "cantidad"=>$this->cantidad,
	  				   "precio"=>$this->precio
	  					);

		$respuesta = ControladorRecibos::ctrGuardarRecibo($datos);

		echo json_encode($respuesta);

	}


	/*=============================================
  	EDITAR RECIBO
  	=============================================*/
  	public $clienteIdEditar;
  	public $idDetalle;
  	public $idReciboEditar;
  	public $nEmpresaEditar;
  	public $num_reciboEditar;
  	public $tipoPagoEditar;
  	public $total_reciboEditar;
  	public $divisaEditar;
  	public $fechaEditar;
		public $fechaPagoEditar;
  	public $itemEditar;
  	public $cantidadEditar;
  	public $precioEditar;


	public function ajaxEditarRecibo()
	{

	  	$datos = array("idcliente"=>$this->clienteIdEditar,
	  				   "id"=>$this->idReciboEditar,
	  				   "idDetalle"=>$this->idDetalle,
	  				   "empresa"=>$this->nEmpresaEditar,
	  				   "num_recibo"=>$this->num_reciboEditar,
	  				   "tipoPago"=>$this->tipoPagoEditar,
	  				   "total_recibo"=>$this->total_reciboEditar,
	  				   "fecha"=>$this->fechaEditar,
							 "fechaPagoEditar" =>$this->fechaPagoEditar,
	  				   "divisa"=>$this->divisaEditar,
	  				   "item"=>$this->itemEditar,
	  				   "cantidad"=>$this->cantidadEditar,
	  				   "precio"=>$this->precioEditar
	  					);

		$respuesta = ControladorRecibos::ctrEditarRecibo($datos);

		echo json_encode($respuesta);

	}

	/*=============================================
  	MOSTRAR RECIBO
  	=============================================*/
  	public $idRecibo;

  	public function ajaxMostrarRecibo(){

  		$item = "id";
		$valor = $this->idRecibo;

		$recibo = ControladorRecibos::ctrMostrarRecibo($item, $valor);

		echo json_encode($recibo);
  	}
	/*=============================================
  	MOSTRAR RECIBOS REPORTE
  	=============================================*/
  	public $FechaRecibo;

  	public function ajaxMostrarRecibos(){

  		$item = "fecha";
		$valor = $this->FechaRecibo;

		$recibo = ControladorRecibos::ctrMostrarRecibos($item, $valor);

		echo json_encode($recibo);
  	}
	/*=============================================
  	DETALLE RECIBO
  	=============================================*/
  	public $idRecibo_detalle;

  	public function ajaxDetalleRecibo(){

  		$item = "idrecibo";
		$valor = $this->idRecibo_detalle;

		$detalle = "";

		$reciboDetalle = ControladorRecibos::ctrDetalleRecibo($item, $valor);


        foreach ($reciboDetalle as $key => $value) {


        	$detalle .= '<tr class="filas"><td><input type="hidden" class="idDetalle" name="idDetalle[]" value="'.$value["id"].'"><input type="text" class="form-control itemEditar" item="" name="itemEditar[]" value="'.$value["item"].'"></td>
	        		  <td><input required style="width: 90px;" type="number" min="1" class="form-control cantidadEditar" name="cantidadEditar[]" id="cantidadEditar[]" value="'.$value["cantidad"].'"></td><td><input style="width: 120px;" type="number" min="1" step="any" class="form-control precioEditar" name="precioEditar[]" value="'.$value["precio"].'"></td>
	        		  <td><span name="subtotalEditar" class="subtotalEditar">'.round(($value["precio"]*$value["cantidad"]), 2).'</span></td>
        		  </tr>';
        }


        echo $detalle;
  	}


  /*=============================================
  CAMBIAR ESTADO RECIBO
  =============================================*/

  public $activarRecibo;
  public $idReciboEstado;
  public $itemEstado;

  public function ajaxCambiarRecibo(){



    $estado = ModeloRecibos::mdlActualizarRecibo("recibo", $this->itemEstado, $this->activarRecibo, "id", $this->idReciboEstado);


    echo $estado;


  }
}

/*=============================================
GUARDAR RECIBO
=============================================*/
if (isset($_POST["nameEmpresa"])) {

	$guardarRecibo = new AjaxRecibo();
	$guardarRecibo -> idcliente = $_POST["nameEmpresa"];
	$guardarRecibo -> nEmpresa = $_POST["nEmpresa"];
	$guardarRecibo -> num_recibo = $_POST["num_recibo"];
	$guardarRecibo -> tipoPago = $_POST["tipoPago"];
	$guardarRecibo -> total_recibo = $_POST["total_recibo"];
	$guardarRecibo -> fecha = $_POST["fecha_hora"];
	$guardarRecibo -> fechaPago = $_POST["fechaPagoRecibo"];
	$guardarRecibo -> divisa = $_POST["divisa"];
	$guardarRecibo -> item = $_POST["item"];
	$guardarRecibo -> cantidad = $_POST["cantidad"];
	$guardarRecibo -> precio = $_POST["precio"];
	$guardarRecibo -> ajaxGuardarRecibo();
}

/*=============================================
EDITAR RECIBO
=============================================*/
if (isset($_POST["clienteIdEditar"])) {

	$editarRecibo = new AjaxRecibo();
	$editarRecibo -> idDetalle = $_POST["idDetalle"];
	$editarRecibo -> idReciboEditar = $_POST["idReciboEditar"];
	$editarRecibo -> clienteIdEditar = $_POST["clienteIdEditar"];
	$editarRecibo -> nEmpresaEditar = $_POST["nEmpresa"];
	$editarRecibo -> num_reciboEditar = $_POST["num_reciboEditar"];
	$editarRecibo -> tipoPagoEditar = $_POST["tipoPagoEditar"];
	$editarRecibo -> total_reciboEditar = $_POST["total_reciboEditar"];
	$editarRecibo -> fechaEditar = $_POST["fechaEditar"];
	$editarRecibo -> fechaPagoEditar = $_POST["fechaPagoReciboEditar"];
	$editarRecibo -> divisaEditar = $_POST["divisaEditar"];
	$editarRecibo -> itemEditar = $_POST["itemEditar"];
	$editarRecibo -> cantidadEditar = $_POST["cantidadEditar"];
	$editarRecibo -> precioEditar = $_POST["precioEditar"];
	$editarRecibo -> ajaxEditarRecibo();
}


/*=============================================
MOSTRAR RECIBO
=============================================*/
if (isset($_POST["idReciboverEditar"])) {

	$mostrarRecibo = new AjaxRecibo();
	$mostrarRecibo -> idRecibo = $_POST["idReciboverEditar"];
	$mostrarRecibo -> ajaxMostrarRecibo();
}

/*=============================================
MOSTRAR RECIBOS
=============================================*/
if (isset($_POST["FechaRecibo"])) {

	$mostrarRecibos = new AjaxRecibo();
	$mostrarRecibos -> FechaRecibo = $_POST["FechaRecibo"];
	$mostrarRecibos -> ajaxMostrarReciboS();
}

/*=============================================
LISTAR DETALLE
=============================================*/
if (isset($_POST["idRecibo_detalle"])) {

	$detalleRecibo = new AjaxRecibo();
	$detalleRecibo -> idRecibo_detalle = $_POST["idRecibo_detalle"];
	$detalleRecibo -> ajaxDetalleRecibo();
}

//CAMBIAR ESTADOS
if(isset($_POST["activarRecibo"])){

	$activarRecibo = new AjaxRecibo();
	$activarRecibo -> activarRecibo = $_POST["activarRecibo"];
	$activarRecibo -> idReciboEstado = $_POST["idReciboEstado"];
	$activarRecibo -> itemEstado = $_POST["item"];
	$activarRecibo -> ajaxCambiarRecibo();

}



 ?>
