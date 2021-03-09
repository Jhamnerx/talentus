<?php 
require_once "../controladores/ventas.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../modelos/servicios.modelo.php";
/**
 * 
 */
class AjaxVentas
{
	/*=============================================
  	GUARDAR Venta
  	=============================================*/	
  	public $cliente;
  	public $empresa;
  	public $tipoPago;
  	public $fecha;
  	public $tipo_comprobante;
  	public $divisa_venta;
  	public $serie_comprobante;
  	public $num_comprobante;
  	public $impuesto;
  	public $idarticulo;
  	public $cantidad;
  	public $precio_venta;
  	public $descuento;
  	public $total_venta;



	public function ajaxGuardarVenta()
	{

	  	$datos = array("cliente"=>$this->cliente,
	  				   "empresa"=>$this->empresa,
	  				   "idusuario"=>1,
	  				   "tipoPago"=>$this->tipoPago,
	  				   "fecha"=>$this->fecha,
	  				   "tipo_comprobante"=>$this->tipo_comprobante,
	  				   "divisa_venta"=>$this->divisa_venta,
	  				   "serie_comprobante"=>$this->serie_comprobante,
	  				   "numero_comprobante"=>$this->num_comprobante,
	  				   "impuesto_venta"=>$this->impuesto,
	  				   "idarticulo"=>$this->idarticulo,
	  				   "cantidad"=>$this->cantidad,
	  				   "precio_venta"=>$this->precio_venta,
	  				   "descuento"=>$this->descuento,
	  				   "total_venta"=>$this->total_venta
	  					);

		$respuesta = ControladorVentas::ctrGuardarVenta($datos);

		echo json_encode($respuesta);

	}


	/*=============================================
  	MOSTRAR VENTA
  	=============================================*/	
  	public $idVenta;

  	public function ajaxMostrarVenta(){

  		$item = "id";
		$valor = $this->idVenta;

		$ventas = ControladorVentas::ctrMostrarVentas($item, $valor);

		echo json_encode($ventas);
  	}

	/*=============================================
  	ANULAR VENTA
  	=============================================*/	
  	public $idanular;

  	public function ajaxAnularVenta(){

  		$item1= "id";
		$valor1 = $this->idanular;
		$item2 = "estado";
		$valor2 = 0;
		$tabla = "venta";

		$respuesta = ModeloVentas::mdlAnularVentas($tabla, $item1, $valor1, $item2, $valor2);;

		echo $respuesta;
  	}


	/*=============================================
  	DETALLE VENTA
  	=============================================*/	
  	public $idVenta_detalle;

  	public function ajaxDetalleVenta(){

  		$item = "idventa";
		$valor = $this->idVenta_detalle;
		$total = 0;

		$detalle = "";

		$ventaDetalle = ControladorVentas::ctrDetalleVentas($item, $valor);

		$detalle .= '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tbody>';

        foreach ($ventaDetalle as $key => $value) {

        	$item = "id";
		    $valor = $value["idarticulo"];
		    $tabla = "servicios";


		    $articulo = ModeloServicios::mdlMostrarServicios($tabla, $item, $valor);

        	$detalle .= '<tr class="filas"><td></td><td>'.$articulo["nombre"].'</td>
	        		  <td>'.$value["cantidad"].'</td><td>'.$value["precio_venta"].'</td><td>'.$value["descuento"].'</td>
	        		  <td>'.round(($value["precio_venta"]*$value["cantidad"])-$value["descuento"], 2).'</td>
        		  </tr>';

				$total = $total+round(($value["precio_venta"]*$value["cantidad"])-$value["descuento"], 2);
        }

		$detalle .= '</tbody><tfoot>
                            <th>TOTAL</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><h4 id="total">S/. '.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                        </tfoot>';

        echo $detalle;
  	}
}




/*=============================================
GUARDAR Venta
=============================================*/
if (isset($_POST["idcliente"])) {

	$guardarVenta = new AjaxVentas();
	$guardarVenta -> cliente = $_POST["idcliente"];
	$guardarVenta -> empresa = $_POST["nEmpresa"];
	$guardarVenta -> tipoPago = $_POST["tipoPago"];
	$guardarVenta -> fecha = $_POST["fecha_hora"];
	$guardarVenta -> tipo_comprobante = $_POST["tipo_comprobante"];
	$guardarVenta -> divisa_venta = $_POST["divisa"];
	$guardarVenta -> serie_comprobante = $_POST["serie_comprobante"];
	$guardarVenta -> num_comprobante = $_POST["num_comprobante"];
	$guardarVenta -> impuesto = $_POST["impuesto"];
	$guardarVenta -> idarticulo = $_POST["idarticulo"];
	$guardarVenta -> cantidad = $_POST["cantidad"];
	$guardarVenta -> precio_venta = $_POST["precio_venta"];
	$guardarVenta -> descuento = $_POST["descuento"];
	$guardarVenta -> total_venta = $_POST["total_venta"];
	$guardarVenta -> ajaxGuardarVenta();
}
/*=============================================
MOSTRAR VENTA
=============================================*/
if (isset($_POST["idVenta"])) {

	$mostrarVenta = new AjaxVentas();
	$mostrarVenta -> idVenta = $_POST["idVenta"];
	$mostrarVenta -> ajaxMostrarVenta();
}


/*=============================================
LISTAR DETALLE
=============================================*/
if (isset($_POST["idVenta_detalle"])) {

	$detalleVenta = new AjaxVentas();
	$detalleVenta -> idVenta_detalle = $_POST["idVenta_detalle"];
	$detalleVenta -> ajaxDetalleVenta();
}


/*=============================================
ANULAR VENTA
=============================================*/
if (isset($_POST["idanular"])) {

	$anularVenta = new AjaxVentas();
	$anularVenta -> idanular = $_POST["idanular"];
	$anularVenta -> ajaxAnularVenta();
}
 ?>