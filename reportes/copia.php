<?php 

require_once "../controladores/ventas.controlador.php";
require_once "../controladores/persona.controlador.php";
require_once "../modelos/ventas.modelo.php";
require_once "../modelos/persona.modelo.php";
require_once "../modelos/servicios.modelo.php";

if (isset($_SERVER["REQUEST_URI"])) {
	/**
	 * OBTENER ID VENTA
	 * DESDE URL
	 */
	$dir= $_SERVER["REQUEST_URI"];
	$url = explode("/", $dir);
	$html = "<!DOCTYPE html>
				<html>";
	/**
	 * CONSULTAR
	 * VENTA
	 */

	$item = "id";
	$valor = $url[4];
	$venta = ControladorVentas::ctrMostrarVentas($item, $valor);

$html.='
<head>
	<title>Factura N°'.$venta["serie_comprobante"].'-'.$venta["num_comprobante"].' </title>
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext" rel="stylesheet" type="text/css">
	<!-- <link rel="stylesheet" href="sass/main.css" media="screen" charset="utf-8"/> -->
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="content-type" content="text-html; charset=utf-8">
  <script src="../../vistas/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="../kendo.all.min.js"></script>
    <script>

      function exportPDF() {
        kendo.drawing.drawDOM(".factura", {
          forcePageBreak: ".new-page",
          paperSize: "A4",
          margin: {top: "0cm", bottom: "0cm", left: "0cm"},
          scale: 0.75,
          height: 500
        }).then(function(group){
          kendo.drawing.pdf.saveAs(group, "factura");
        });
      }
      kendo.pdf.defineFont({
        "DejaVu Sans"             : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans.ttf",
        "DejaVu Sans|Bold"        : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Bold.ttf",
        "DejaVu Sans|Bold|Italic" : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
        "DejaVu Sans|Italic"      : "https://kendo.cdn.telerik.com/2016.2.607/styles/fonts/DejaVu/DejaVuSans-Oblique.ttf",
        "WebComponentsIcons"      : "https://kendo.cdn.telerik.com/2017.1.223/styles/fonts/glyphs/WebComponentsIcons.ttf"
    });


$( document ).ready(function() {
    console.log( "ready!" );
    exportPDF();
});
    </script>
	<style type="text/css">
		html, body, div, span, applet, object, iframe,
		h1, h2, h3, h4, h5, h6, p, blockquote, pre,
		a, abbr, acronym, address, big, cite, code,
		del, dfn, em, img, ins, kbd, q, s, samp,
		small, strike, strong, sub, sup, tt, var,
		b, u, i, center,
		dl, dt, dd, ol, ul, li,
		fieldset, form, label, legend,
		table, caption, tbody, tfoot, thead, tr, th, td,
		article, aside, canvas, details, embed,
		figure, figcaption, footer, header, hgroup,
		menu, nav, output, ruby, section, summary,
		time, mark, audio, video {
			margin: 0;
			padding: 0;
			border: 0;
			font: inherit;
			font-size: 100%;
			vertical-align: baseline;
		}

		html {
			line-height: 1;
		}

		ol, ul {
			list-style: none;
		}

		table {
			border-collapse: collapse;
			border-spacing: 0;
		}

		caption, th, td {
			text-align: left;
			font-weight: normal;
			vertical-align: middle;
		}

		q, blockquote {
			quotes: none;
		}
		q:before, q:after, blockquote:before, blockquote:after {
			content: "";
			content: none;
		}

		a img {
			border: none;
		}

		article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {
			display: block;
		}

		body {
			font-family: "Source Sans Pro", sans-serif;
			font-weight: 300;
			font-size: 12px;
			margin: 0;
			padding: 0;
			color: #777777;
		}
		body a {
			text-decoration: none;
			color: inherit;
		}
		body a:hover {
			color: inherit;
			opacity: 0.7;
		}
		body .container {
			min-width: 500px;
			margin: 0 auto;
			padding: 0 30px;
		}
		body .clearfix:after {
			content: "";
			display: table;
			clear: both;
		}
		body .left {
			float: left;
		}
		body .right {
			float: right;
		}
		body .helper {
			height: 100%;
		}

		header {
			height: 40px;
			margin-top: 20px;
			margin-bottom: 40px;
			padding: 0px 5px 0;
		}
		header figure {
			float: left;
			width: 40px;
			margin-right: 10px;
		}
		header figure img {
			height: 40px;
		}
		header .company-info {
			color: #BDB9B9;
		}
		header .company-info .title {
			margin-bottom: 5px;
			color: #052c52;
			font-weight: 600;
			font-size: 2em;
		}
		header .company-info .line {
			display: inline-block;
			height: 9px;
			margin: 0 4px;
			border-left: 1px solid #052c52;
		}

		section .details {
			min-width: 500px;
			margin-bottom: 40px;
			padding: 10px 35px;
			background-color: #052c52;
			color: #ffffff;
		}
		section .details .client {
			width: 50%;
			line-height: 16px;
		}
		section .details .client .name {
			font-weight: 600;
		}
		section .details .data {
			width: 50%;
			text-align: right;
		}
		section .details .title {
			margin-bottom: 15px;
			font-size: 3em;
			font-weight: 400;
			text-transform: uppercase;
		}
		section .table-wrapper {
			position: relative;
			overflow: hidden;
		}
		section .table-wrapper:before {
			content: "";
			display: block;
			position: absolute;
			top: 33px;
			left: 30px;
			width: 90%;
			height: 100%;
			border-top: 2px solid #000;
			border-left: 2px solid #000;
			z-index: -1;
		}
		section .no-break {
			page-break-inside: avoid;
		}
		section table {
			width: 100%;
			margin-bottom: -20px;
			table-layout: fixed;
			border-collapse: separate;
			border-spacing: 5px 20px;
		}
		section table .no {
			width: 50px;
		}
		section table .desc {
			width: 55%;
		}
		section table .qty, section table .unit, section table .total {
			width: 15%;
		}
		section table tbody.head {
			vertical-align: middle;
			border-color: inherit;
		}
		section table tbody.head th {
			text-align: center;
			color: white;
			font-weight: 600;
			text-transform: uppercase;
		}
		section table tbody.head th div {
			display: inline-block;
			padding: 7px 0;
			width: 100%;
			background: #BDB9B9;
		}
		section table tbody.head th.desc div {
			width: 115px;
			margin-left: -110px;
		}
		section table tbody.body td {
			padding: 10px 5px;
			background: #F3F3F3;
			text-align: center;
		}
		section table tbody.body h3 {
			margin-bottom: 5px;
			color: #052c52;
			font-weight: 600;
		}
		section table tbody.body .no {
			padding: 0px;
			background-color: #052c52;
			color: #ffffff;
			font-size: 1.66666666666667em;
			font-weight: 600;
			line-height: 50px;
		}
		section table tbody.body .desc {
			padding-top: 0;
			padding-bottom: 0;
			background-color: transparent;
			color: #777787;
			text-align: left;
		}
		section table tbody.body .total {
			color: #052c52;
			font-weight: 600;
		}
		section table tbody.body tr.total td {
			padding: 5px 10px;
			background-color: transparent;
			border: none;
			color: #777777;
			text-align: right;
		}
		section table tbody.body tr.total .empty {
			background: white;
		}
		section table tbody.body tr.total .total {
			font-size: 1.18181818181818em;
			font-weight: 600;
			color: #052c52;
		}
		section table.grand-total {
			margin-top: 40px;
			margin-bottom: 0;
			border-collapse: collapse;
			border-spacing: 0px 0px;
			margin-bottom: 40px;
		}
		section table.grand-total tbody td {
			padding: 0 10px 10px;
			background-color: #052c52;
			color: #ffffff;
			font-weight: 400;
			text-align: right;
		}
		section table.grand-total tbody td.no, section table.grand-total tbody td.desc, section table.grand-total tbody td.qty {
			background-color: transparent;
		}
		section table.grand-total tbody td.total, section table.grand-total tbody td.grand-total {
			border-right: 5px solid #ffffff;
		}
		section table.grand-total tbody td.grand-total {
			padding: 0;
			font-size: 1.16666666666667em;
			font-weight: 600;
			background-color: transparent;
		}
		section table.grand-total tbody td.grand-total div {
			float: right;
			padding: 10px 5px;
			background-color: #21BCEA;
		}
		section table.grand-total tbody td.grand-total div span {
			margin-right: 5px;
		}
		section table.grand-total tbody tr:first-child td {
			padding-top: 10px;
		}

		footer {
			margin-bottom: 20px;
			padding: 0 5px;
		}
		footer .thanks {
			margin-bottom: 40px;
			color: #052c52;
			font-size: 1.16666666666667em;
			font-weight: 600;
		}
		footer .notice {
			margin-bottom: 25px;
		}
		footer .end {
			padding-top: 5px;
			border-top: 2px solid #052c52;
			text-align: center;
		}

	</style>
</head>
	';
	/**
	 * CONSULTAR
	 * CLIENTE
	 */
	$item = "id";
    $valor = $venta["idcliente"];
    $count = 1;
    $cliente = ControladorPersona::ctrMostrarPersona($item, $valor, $count);

$html.='
<body class="factura">
	<header class="clearfix">
		<div class="container">
			<figure>
				<img class="logo" src="data:image/svg+xml;charset=utf-8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+Cjxzdmcgd2lkdGg9IjQxcHgiIGhlaWdodD0iNDFweCIgdmlld0JveD0iMCAwIDQxIDQxIiB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbG5zOnNrZXRjaD0iaHR0cDovL3d3dy5ib2hlbWlhbmNvZGluZy5jb20vc2tldGNoL25zIj4KICAgIDwhLS0gR2VuZXJhdG9yOiBTa2V0Y2ggMy40LjEgKDE1NjgxKSAtIGh0dHA6Ly93d3cuYm9oZW1pYW5jb2RpbmcuY29tL3NrZXRjaCAtLT4KICAgIDx0aXRsZT5MT0dPPC90aXRsZT4KICAgIDxkZXNjPkNyZWF0ZWQgd2l0aCBTa2V0Y2guPC9kZXNjPgogICAgPGRlZnM+PC9kZWZzPgogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCIgc2tldGNoOnR5cGU9Ik1TUGFnZSI+CiAgICAgICAgPGcgaWQ9IklOVk9JQ0UtMiIgc2tldGNoOnR5cGU9Ik1TQXJ0Ym9hcmRHcm91cCIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTMwLjAwMDAwMCwgLTMwLjAwMDAwMCkiIGZpbGw9IiMyQThFQUMiPgogICAgICAgICAgICA8ZyBpZD0iWkFHTEFWTEpFIiBza2V0Y2g6dHlwZT0iTVNMYXllckdyb3VwIiB0cmFuc2Zvcm09InRyYW5zbGF0ZSgzMC4wMDAwMDAsIDE1LjAwMDAwMCkiPgogICAgICAgICAgICAgICAgPGcgaWQ9IkxPR08iIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuMDAwMDAwLCAxNS4wMDAwMDApIiBza2V0Y2g6dHlwZT0iTVNTaGFwZUdyb3VwIj4KICAgICAgICAgICAgICAgICAgICA8cGF0aCBkPSJNMzkuOTI0NjM2MywxOC40NDg2MjEgTDMzLjc3MDczNTgsMTEuODQyMjkyMyBMMzMuNzcwNzM1OCw0LjIxMDUyNjgxIEMzMy43NzA3MzU4LDIuODMwOTIyMzYgMzIuNzI5MzQxMSwxLjcxMjU0NDE0IDMxLjQ0MTczNzIsMS43MTI1NDQxNCBDMzAuMTU3NDExOSwxLjcxMjU0NDE0IDI5LjExNjAxNzMsMi44MzA5MjIzNiAyOS4xMTYwMTczLDQuMjEwNTI2ODEgTDI5LjExNjAxNzMsNi44NDUxMTcwNCBMMjQuNTMzNzM3NCwxLjkyNjAzNDcxIEMyMi4yNjgwNTg1LC0wLjUwNDQxNDA5NCAxOC4zMjkwMTcxLC0wLjUwMDEyNDQ4NCAxNi4wNjg4NzEsMS45MzAzMjQzMiBMMC42ODExNDgzMjksMTguNDQ4NjIxIEMtMC4yMjY5NDY5ODQsMTkuNDI1NjYyMSAtMC4yMjY5NDY5ODQsMjEuMDA2NzY4MiAwLjY4MTE0ODMyOSwyMS45ODIwNDk0IEMxLjU5MDE2NTc3LDIyLjk1OTA5MDUgMy4wNjU3ODIyMywyMi45NTkwOTA1IDMuOTczODc3NTUsMjEuOTgyMDQ5NCBMMTkuMzU5OTYwOSw1LjQ2Mzc1Mjc1IEMxOS44NjE0OTg0LDQuOTI4NDMxNDcgMjAuNzQ0Nzk4Niw0LjkyODQzMTQ3IDIxLjI0MzQ2NzIsNS40NjIxMDI5IEwzNi42MzE5MDcxLDIxLjk4MjA0OTQgQzM3LjA4ODU2NzUsMjIuNDcwNTE1IDM3LjY4MzM0MjgsMjIuNzEzNzAyOSAzOC4yNzgxMTgsMjIuNzEzNzAyOSBDMzguODc0MDIwNCwyMi43MTM3MDI5IDM5LjQ3MDAyNTIsMjIuNDcwNTE1IDM5LjkyNTA0NjIsMjEuOTgyMDQ5NCBDNDAuODMzNTUxMywyMS4wMDY3NjgyIDQwLjgzMzU1MTMsMTkuNDI1NjYyMSAzOS45MjQ2MzYzLDE4LjQ0ODYyMSBMMzkuOTI0NjM2MywxOC40NDg2MjEgWiIgaWQ9IkZpbGwtMSI+PC9wYXRoPgogICAgICAgICAgICAgICAgICAgIDxwYXRoIGQ9Ik0yMS4xMTEzOTc0LDEwLjIwNTg2MTIgQzIwLjY2NDM2ODIsOS43MjYzMDQ4MiAxOS45NDA2OTkzLDkuNzI2MzA0ODIgMTkuNDk0ODk5NiwxMC4yMDU4NjEyIEw1Ljk1OTg0Mjk2LDI0LjczMTM1OTIgQzUuNzQ2MTEzMiwyNC45NjAzNTg0IDUuNjI1MjExNDIsMjUuMjczNjA5OSA1LjYyNTIxMTQyLDI1LjYwMDA2MDIgTDUuNjI1MjExNDIsMzYuMTk0ODQ2IEM1LjYyNTIxMTQyLDM4LjY4MDcyOTcgNy41MDI3NzUwNyw0MC42OTYxODYzIDkuODE4NDUzOTgsNDAuNjk2MTg2MyBMMTYuNTE5NDg2Myw0MC42OTYxODYzIEwxNi41MTk0ODYzLDI5LjU1NTQxMDIgTDI0LjA4NTA2ODgsMjkuNTU1NDEwMiBMMjQuMDg1MDY4OCw0MC42OTYxODYzIEwzMC43ODY2MTM1LDQwLjY5NjE4NjMgQzMzLjEwMjI5MjQsNDAuNjk2MTg2MyAzNC45Nzk3NTM2LDM4LjY4MDcyOTcgMzQuOTc5NzUzNiwzNi4xOTQ4NDYgTDM0Ljk3OTc1MzYsMjUuNjAwMDYwMiBDMzQuOTc5NzUzNiwyNS4yNzM2MDk5IDM0Ljg1OTY3MTUsMjQuOTYwMzU4NCAzNC42NDUyMjQ1LDI0LjczMTM1OTIgTDIxLjExMTM5NzQsMTAuMjA1ODYxMiBaIiBpZD0iRmlsbC0zIj48L3BhdGg+CiAgICAgICAgICAgICAgICA8L2c+CiAgICAgICAgICAgIDwvZz4KICAgICAgICA8L2c+CiAgICA8L2c+Cjwvc3ZnPg==" alt="">
			</figure>
			<div class="company-info">
				<h2 class="title">Talentus Techonology</h2>
				<span>Trujillo, Av. America Norte 1810</span>
				<span class="line"></span>
				<a class="phone" href="tel:602-519-0450">931742904</a>
				<span class="line"></span>
				<a class="email" href="mailto:clientes@talentustechnology.com">clientes@talentustechnology.com</a>
			</div>
		</div>
	</header>


';

$html.='
	<section>
		<div class="details clearfix">
			<div class="client left">
				<p>FACTURA A:</p>
				<p class="name">'.$cliente["nombre"].'';

				if ($cliente["nombre"] != null) {

					$html.=$cliente["apellido"]." ";
				}
			$html.='</p>
				<p>
					'.$cliente["direccion"].',<br>
				</p>
				<a href="mailto:'.$cliente["email"].'">'.$cliente["email"].'</a>
			</div>
			<div class="data right">
				<div class="title">Factura '.$venta["serie_comprobante"].'-'.$venta["num_comprobante"].' </div>
				<div class="date">
					Fecha: '.$fecha=date_format(date_create($venta["fecha_hora"]),"d/m/Y").'<br>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="table-wrapper">
				<table>
					<tbody class="head">
						<tr>
							<th class="no"></th>
							<th class="desc"><div>Descripcion</div></th>
							<th class="qty"><div>Cantidad</div></th>
							<th class="unit"><div>Precio Unitario</div></th>
							<th class="total"><div>Total</div></th>
						</tr>
					</tbody>
					<tbody class="body">
';
	/**
	 * CONSULTAR
	 * DETALLE VENTA
	 */
	$item = "idventa";
	$valor = $venta["id"];
	$total = 0;

	$detalle = "";

	$ventaDetalle = ControladorVentas::ctrDetalleVentas($item, $valor);

	/**
	 * CONSULTAR
	 * DETALLE VENTA
	 */
	$descuento = 0;
	 foreach ($ventaDetalle as $key => $value) {

    	$item = "id";
	    $valor = $value["idarticulo"];
	    $tabla = "servicios";


	    $articulo = ModeloServicios::mdlMostrarServicios($tabla, $item, $valor);

    	if ($venta["divisa"] == "PEN") {

			$simbolo = "S/";

		}else if($venta["divisa"] == "USD"){

			$simbolo = "$";

		}else if($venta["divisa"] == "EUR"){

			$simbolo = "€";

		}else{

			$simbolo = "MXN";
		}
		$html.='<tr>
					<td class="no">'.($key+1).'</td>
					<td class="desc">'.$articulo["nombre"].'</td>
					<td class="qty">'.$value["cantidad"].'</td>
					<td class="unit">'.$simbolo.' '.$value["precio_venta"].'</td>
					<td class="total">'.$simbolo.' '.round(($value["cantidad"]*$value["precio_venta"]), 2).'</td>
				</tr>';

	$descuento = $descuento + $value["descuento"];
	}
    
$html.=' 
					</tbody>
				</table>
			</div>
			<div class="no-break">
				<table class="grand-total">
					<tbody>
						<tr>
							<td class="no"></td>
							<td class="desc"></td>
							<td class="qty"></td>
							<td class="unit">SUBTOTAL:</td>
							<td class="total">'.$simbolo.' '.($venta["total_venta"]+$descuento).'</td>
						</tr>
						<tr>
							<td class="no"></td>
							<td class="desc"></td>
							<td class="qty"></td>
							<td class="unit">DESCUENTO:</td>
							<td class="total">- '.$simbolo.' '.$descuento.'</td>
						</tr>
						<tr>
							<td class="no"></td>
							<td class="desc"></td>
							<td class="qty"></td>
							<td class="unit">IGV 18%:</td>';

						if ($venta["tipo_comprobante"] == "Factura + IGV") {
							
							$igv = ($venta["total_venta"] * $venta["impuesto"])/100;
  							$total = $venta["total_venta"] +  $igv;

						}elseif($venta["tipo_comprobante"] == "Factura IGV INC"){
							$g= "1.".round($venta["impuesto"]);
							$total = ($venta["total_venta"]/$g);

  							$igv = $venta["total_venta"] - $total;

						}else{

							$total = $venta["total_venta"];
						}

					$html.='<td class="total">$'.round($igv, 2).'</td>
						</tr>
						<tr>
							<td class="grand-total" colspan="5"><div><span>TOTAL:</span>$'.round($total, 2).'</div></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
';
$html .='
	<footer>
		<div class="container">
			<div class="thanks">Thank you!</div>
			<div class="notice">
				<div>NOTICE:</div>
				<div>A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
			</div>
			<div class="end">Invoice was created on a computer and is valid without the signature and seal.</div>
		</div>
	</footer>

</body>

</html>
';
echo $html;
}else{


}
	
	


	
// require_once '../vendor/autoload.php';

// $mpdf = new \Mpdf\Mpdf();
// $mpdf->WriteHTML($html);
// $mpdf->Output();
// $mpdf = new \Mpdf\Mpdf([
// 	'margin_left' => 20,
// 	'margin_right' => 15,
// 	'margin_top' => 48,
// 	'margin_bottom' => 25,
// 	'margin_header' => 10,
// 	'margin_footer' => 10
// ]);
?>





