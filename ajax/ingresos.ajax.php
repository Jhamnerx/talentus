<?php 
require_once "../controladores/ingresos.controlador.php";
require_once "../modelos/ingresos.modelo.php";
require_once "../modelos/servicios.modelo.php";
/**
 * 
 */
class AjaxIngresos
{
	/*=============================================
  	GUARDAR INGRESO
  	=============================================*/	
  	public $proveedor;
  	public $fecha;
  	public $tipo_comprobante;
  	public $divisa_ingreso;
  	public $serie_comprobante;
  	public $num_comprobante;
  	public $impuesto;
  	public $idarticulo;
  	public $cantidad;
  	public $precio_compra;
  	public $precio_venta;
  	public $total_compra;



	public function ajaxGuardarIngreso()
	{

	  	$datos = array("proveedor"=>$this->proveedor,
	  				   "idusuario"=>1,
	  				   "fecha"=>$this->fecha,
	  				   "tipo_comprobante"=>$this->tipo_comprobante,
	  				   "divisa_ingreso"=>$this->divisa_ingreso,
	  				   "serie_comprobante"=>$this->serie_comprobante,
	  				   "numero_comprobante"=>$this->num_comprobante,
	  				   "impuesto_ingreso"=>$this->impuesto,
	  				   "idarticulo"=>$this->idarticulo,
	  				   "cantidad"=>$this->cantidad,
	  				   "precio_compra"=>$this->precio_compra,
	  				   "precio_venta"=>$this->precio_venta,
	  				   "total_compra"=>$this->total_compra
	  					);

		$respuesta = ControladorIngresos::ctrGuardarIngreso($datos);

		echo $respuesta;

	}


	/*=============================================
  	MOSTRAR INGRESO
  	=============================================*/	
  	public $idingreso;

  	public function ajaxMostrarIngreso(){

  		$item = "id";
		$valor = $this->idingreso;

		$ingresos = ControladorIngresos::ctrMostrarIngresos($item, $valor);

		echo json_encode($ingresos);
  	}

	/*=============================================
  	ANULAR INGRESO
  	=============================================*/	
  	public $idanular;

  	public function ajaxAnularIngreso(){

  		$item1= "id";
		$valor1 = $this->idanular;
		$item2 = "estado";
		$valor2 = 0;
		$tabla = "ingreso";

		$respuesta = ModeloIngresos::mdlAnularIngresos($tabla, $item1, $valor1, $item2, $valor2);

		echo $respuesta;
  	}


	/*=============================================
  	DETALLE INGRESO
  	=============================================*/	
  	public $idingreso_detalle;

  	public function ajaxDetalleIngreso(){

  		$item = "idingreso";
		$valor = $this->idingreso_detalle;
		$total = 0;

		$detalle = "";

		$ingresoDetalle = ControladorIngresos::ctrDetalleIngresos($item, $valor);

		$detalle .= '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tbody>';

        foreach ($ingresoDetalle as $key => $value) {

        	$item = "id";
		    $valor = $value["idarticulo"];
		    $tabla = "servicios";


		    $articulo = ModeloServicios::mdlMostrarServicios($tabla, $item, $valor);

        	$detalle .= '<tr class="filas"><td></td><td>'.$articulo["nombre"].'</td>
	        		  <td>'.$value["cantidad"].'</td><td>'.$value["precio_compra"].'</td>
	        		  <td>'.$value["precio_venta"].'</td><td>'.round($value["precio_compra"]*$value["cantidad"], 2).'</td>
        		  </tr>';

				$total = $total+(round($value["precio_compra"]*$value["cantidad"], 2));
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
GUARDAR INGRESO
=============================================*/
if (isset($_POST["idproveedor"])) {

	$guardarIngreso = new AjaxIngresos();
	$guardarIngreso -> proveedor = $_POST["idproveedor"];
	$guardarIngreso -> fecha = $_POST["fecha_hora"];
	$guardarIngreso -> tipo_comprobante = $_POST["tipo_comprobante"];
	$guardarIngreso -> divisa_ingreso = $_POST["divisa"];
	$guardarIngreso -> serie_comprobante = $_POST["serie_comprobante"];
	$guardarIngreso -> num_comprobante = $_POST["num_comprobante"];
	$guardarIngreso -> impuesto = $_POST["impuesto"];
	$guardarIngreso -> idarticulo = $_POST["idarticulo"];
	$guardarIngreso -> cantidad = $_POST["cantidad"];
	$guardarIngreso -> precio_compra = $_POST["precio_compra"];
	$guardarIngreso -> precio_venta = $_POST["precio_venta"];
	$guardarIngreso -> total_compra = $_POST["total_compra"];
	$guardarIngreso -> ajaxGuardarIngreso();
}
/*=============================================
MOSTRAR INGRESO
=============================================*/
if (isset($_POST["idingreso"])) {

	$mostrarIngreso = new AjaxIngresos();
	$mostrarIngreso -> idingreso = $_POST["idingreso"];
	$mostrarIngreso -> ajaxMostrarIngreso();
}


/*=============================================
LISTAR DETALLE
=============================================*/
if (isset($_POST["idingreso_detalle"])) {

	$detalleIngreso = new AjaxIngresos();
	$detalleIngreso -> idingreso_detalle = $_POST["idingreso_detalle"];
	$detalleIngreso -> ajaxDetalleIngreso();
}


/*=============================================
ANULAR INGRESO
=============================================*/
if (isset($_POST["idanular"])) {

	$anularIngreso = new AjaxIngresos();
	$anularIngreso -> idanular = $_POST["idanular"];
	$anularIngreso -> ajaxAnularIngreso();
}
 ?>