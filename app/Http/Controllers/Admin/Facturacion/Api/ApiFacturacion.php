<?php

namespace App\Http\Controllers\Admin\Facturacion\Api;

use DateTime;
use App\Models\Ventas;
use App\Models\Empresa;
use App\Models\plantilla;
use Illuminate\Http\Request;
use App\Models\VentasDetalle;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Invoice;
use App\Events\EmitirComprobante;
use App\Events\FirmarComprobante;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\SaleDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Greenter\Model\DocumentInterface;
use Illuminate\Support\Facades\Storage;
use Greenter\Xml\Builder\InvoiceBuilder;
use Luecano\NumeroALetras\NumeroALetras;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;

class ApiFacturacion extends Controller
{
    public function emitirInvoice(Ventas $venta, $metodo_type)
    {

        if ($metodo_type == "02") {

            return $this->emitirComprobante($venta);
        } else {


            return  $this->createXmlInvoice($venta);
        }
    }

    //CREAR XML - FIRMADO Y ENVIO A SUNAT
    public function emitirComprobante(Ventas $venta)
    {
        $util = Util::getInstance();
        $formatter = new NumeroALetras();
        $cliente = $this->getCliente($venta);


        // RELACIONAR FACTURA CON GUIA DE REMISION EMITIDA
        // $guiaRemision = (new Document())
        // ->setTipoDoc('09') // Guia de Remision remitente: 09, catalogo 01
        // ->setNroDoc('T001-2'); // Serie y correlativo de la guia de remision



        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setFecVencimiento(new DateTime($venta->fecha_vencimiento))
            ->setTipoOperacion('0101')
            ->setObservacion($venta->observacion)
            ->setTipoDoc($venta->tipo_comprobante_id)
            ->setSerie($venta->serie)
            ->setCorrelativo($venta->correlativo)
            ->setFechaEmision(new DateTime($venta->fecha_hora_emision))
            ->setTipoMoneda($venta->divisa)
            ->setCompany($util->getCompany())
            ->setClient($cliente)
            ->setMtoOperGravadas($venta->op_gravadas)
            ->setMtoOperExoneradas($venta->op_exoneradas)
            ->setMtoOperInafectas($venta->op_inafectas)
            ->setMtoIGV($venta->igv)
            ->setTotalImpuestos($venta->igv)
            ->setValorVenta($venta->op_gravadas + $venta->op_exoneradas + $venta->op_inafectas)
            ->setSubTotal($venta->total)
            ->setMtoImpVenta($venta->total);


        // $invoice->setGuias([
        //     $guiaRemision // Incluir guia remision.
        // ])

        //EVALUAR SI LA VENTA ES A CREDITO
        if ($venta->forma_pago == 'CREDITO') {

            $invoice->setFormaPago(new FormaPagoCredito($venta->total, $venta->divisa));
            $cuotas = $this->addCuotas($venta);
            $invoice->setCuotas($cuotas);
        } else {

            $invoice->setFormaPago(new FormaPagoContado());
        }


        //AÑADIR DESCUENTO SI ES QUE HAY
        if ($venta->descuento > 0) {

            $invoice->setDescuentos([
                (new Charge())
                    ->setCodTipo('02') // Catalog. 53
                    ->setMontoBase($venta->op_gravadas + $venta->op_exoneradas + $venta->op_inafectas)
                    ->setFactor($venta->descuento_factor)
                    ->setMonto($venta->descuento)
            ]);
        }


        //ESTBLECER EL VENDEDOR DEL COMPROBANTE
        $invoice->setSeller((new Client())
            ->setRznSocial(Auth::user()->name));

        //ESTABLECER ITEMS DEL COMPROBANTE
        $items = $this->getItemsInvoice($venta->ventaDetalles);

        $invoice->setDetails($items)
            ->setLegends([
                (new Legend())
                    ->setCode('1000')
                    ->setValue($formatter->toInvoice($venta->total, 2, 'soles'))
            ]);

        //dd($invoice);
        // Envio a SUNAT.
        $see = $util->getSee();

        /** Si solo desea enviar un XML ya generado utilice esta función**/
        //$res = $see->sendXml(get_class($invoice), $invoice->getName(), file_get_contents($ruta_XML));

        $result = $see->send($invoice);

        // Guardar XML firmado digitalmente.
        $util->writeXml($invoice, $see->getFactory()->getLastXml());

        if (!$result->isSuccess()) {

            $msg = $util->getErrorResponse($result->getError());

            return $msg;
        }

        /**@var $res BillResult*/
        $cdr = $result->getCdrResponse();
        $util->writeCdr($invoice, $result->getCdrZip());

        $respuesta = $util->showResponse($invoice, $cdr);
        return $respuesta['fe_mensaje_sunat'];
    }

    public function sendInvoiceOnly(Ventas $venta)
    {
        $util = Util::getInstance();
        $formatter = new NumeroALetras();
        $cliente = $this->getCliente($venta);
        $plantilla = plantilla::first();

        // RELACIONAR FACTURA CON GUIA DE REMISION EMITIDA
        // $guiaRemision = (new Document())
        // ->setTipoDoc('09') // Guia de Remision remitente: 09, catalogo 01
        // ->setNroDoc('T001-2'); // Serie y correlativo de la guia de remision

        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setFecVencimiento(new DateTime($venta->fecha_vencimiento))
            ->setTipoOperacion('0101')
            ->setObservacion($venta->observacion)
            ->setTipoDoc($venta->tipo_comprobante_id)
            ->setSerie($venta->serie)
            ->setCorrelativo($venta->correlativo)
            ->setFechaEmision(new DateTime($venta->fecha_hora_emision))
            ->setTipoMoneda($venta->divisa)
            ->setCompany($util->getCompany())
            ->setClient($cliente)
            ->setMtoOperGravadas($venta->op_gravadas)
            ->setMtoOperExoneradas($venta->op_exoneradas)
            ->setMtoOperInafectas($venta->op_inafectas)
            ->setMtoIGV($venta->igv)
            ->setTotalImpuestos($venta->igv)
            ->setValorVenta($venta->op_gravadas + $venta->op_exoneradas + $venta->op_inafectas)
            ->setSubTotal($venta->total)
            ->setMtoImpVenta($venta->total);


        // $invoice->setGuias([
        //     $guiaRemision // Incluir guia remision.
        // ])

        //EVALUAR SI LA VENTA ES A CREDITO
        if ($venta->forma_pago == 'CREDITO') {

            $invoice->setFormaPago(new FormaPagoCredito($venta->total, $venta->divisa));
            $cuotas = $this->addCuotas($venta);
            $invoice->setCuotas($cuotas);
        } else {

            $invoice->setFormaPago(new FormaPagoContado());
        }


        //AÑADIR DESCUENTO SI ES QUE HAY
        if ($venta->descuento > 0) {

            $invoice->setDescuentos([
                (new Charge())
                    ->setCodTipo('02') // Catalog. 53
                    ->setMontoBase($venta->op_gravadas + $venta->op_exoneradas + $venta->op_inafectas)
                    ->setFactor($venta->descuento_factor)
                    ->setMonto($venta->descuento)
            ]);
        }


        //ESTBLECER EL VENDEDOR DEL COMPROBANTE
        $invoice->setSeller((new Client())
            ->setRznSocial(Auth::user()->name));

        //ESTABLECER ITEMS DEL COMPROBANTE
        $items = $this->getItemsInvoice($venta->ventaDetalles);

        $invoice->setDetails($items)
            ->setLegends([
                (new Legend())
                    ->setCode('1000')
                    ->setValue($formatter->toInvoice($venta->total, 2, 'soles'))
            ]);
        // Envio a SUNAT.
        $see = $util->getSee();

        $result = $see->sendXml(get_class($invoice), $invoice->getName(), Storage::disk('facturacion')->get($plantilla->empresa->nombre . '/xml' . '/' . $venta->nombre_xml));

        if (!$result->isSuccess()) {

            $msg = $util->getErrorResponse($result->getError());

            return $msg;
        }

        /**@var $res BillResult*/
        $cdr = $result->getCdrResponse();
        $util->writeCdr($invoice, $result->getCdrZip());

        $respuesta = $util->showResponse($invoice, $cdr);
        return $respuesta['fe_mensaje_sunat'];
    }



    //CREAR XML Y FIRMADO - PENDIENTE DE ENVIO
    public function createXmlInvoice(Ventas $venta)
    {
        $util = Util::getInstance();
        $formatter = new NumeroALetras();
        // Cliente
        $cliente = $this->getCliente($venta);

        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setFecVencimiento(new DateTime($venta->fecha_vencimiento))
            ->setTipoOperacion('0101')
            ->setObservacion($venta->observacion)
            ->setTipoDoc($venta->tipo_comprobante_id)
            ->setSerie($venta->serie)
            ->setCorrelativo($venta->correlativo)
            ->setFechaEmision(new DateTime($venta->fecha_hora_emision))
            ->setTipoMoneda($venta->divisa)
            ->setCompany($util->getCompany())
            ->setClient($cliente)
            ->setMtoOperGravadas($venta->op_gravadas)
            ->setMtoOperExoneradas($venta->op_exoneradas)
            ->setMtoOperInafectas($venta->op_inafectas)
            ->setMtoIGV($venta->igv)
            ->setTotalImpuestos($venta->igv)
            ->setValorVenta($venta->op_gravadas + $venta->op_exoneradas + $venta->op_inafectas)
            ->setSubTotal($venta->total)
            ->setMtoImpVenta($venta->total);

        //EVALUAR SI LA VENTA ES A CREDITO
        if ($venta->forma_pago == 'CREDITO') {

            $invoice->setFormaPago(new FormaPagoCredito($venta->total, $venta->divisa));
            $cuotas = $this->addCuotas($venta);
            $invoice->setCuotas($cuotas);
        } else {

            $invoice->setFormaPago(new FormaPagoContado());
        }

        //AÑADIR DESCUENTO SI ES QUE HAY
        if ($venta->descuento > 0) {

            $invoice->setDescuentos([
                (new Charge())
                    ->setCodTipo('02') // Catalog. 53
                    ->setMontoBase($venta->op_gravadas + $venta->op_exoneradas + $venta->op_inafectas)
                    ->setFactor($venta->descuento_factor)
                    ->setMonto($venta->descuento)
            ]);
        }

        //ESTBLECER EL VENDEDOR DEL COMPROBANTE
        $invoice->setSeller((new Client())
            ->setRznSocial(Auth::user()->name));


        //ESTABLECER ITEMS DEL COMPROBANTE
        $items = $this->getItemsInvoice($venta->ventaDetalles);


        $invoice->setDetails($items)
            ->setLegends([
                (new Legend())
                    ->setCode('1000')
                    ->setValue($formatter->toInvoice($venta->total, 2, 'soles'))
            ]);

        //FIRMADO Y GUARDADO DEL XML
        $see = $util->getSee();
        $xml = $see->getXmlSigned($invoice);
        $util->writeXml($invoice, $xml);

        return "El comprobante fue firmado, Pendiente de Envio";
    }

    //DEVOLVER OBJETO CLIENTE
    public function getCliente(Ventas $venta)
    {
        // Cliente
        $cliente = (new Client())
            ->setTipoDoc($venta->cliente->tipo_documento_id)
            ->setNumDoc($venta->cliente->numero_documento)
            ->setRznSocial($venta->cliente->razon_social)
            ->setAddress((new Address())
                ->setDireccion($venta->cliente->direccion))
            ->setEmail($venta->cliente->email)
            ->setTelephone($venta->cliente->telefono);

        return $cliente;
    }
    //CREAR OBJETO DE CUOTAS
    public function addCuotas(Ventas $venta)
    {
        $cuota = [];

        foreach ($venta->detalle_cuotas as $detalle_cuota) {

            $cuota[] = (new Cuota())
                ->setMonto($detalle_cuota['importe'])
                ->setFechaPago(new DateTime($detalle_cuota['fecha']));
        }

        return $cuota;
    }
    public function getItemsInvoice($items)
    {

        $detalle = [];

        foreach ($items as $item) {

            // Detalle gravado
            $i = (new SaleDetail())
                ->setCodProducto($item->codigo)
                ->setUnidad($item->unit)
                ->setDescripcion($item->descripcion)
                ->setCantidad($item->cantidad)
                ->setMtoValorUnitario($item->valor_unitario)
                ->setMtoValorVenta($item->sub_total)
                ->setMtoBaseIgv($item->sub_total)
                ->setPorcentajeIgv($item->porcentaje_igv)
                ->setIgv($item->igv)
                ->setTipAfeIgv($item->codigo_afectacion) // Catalog: 07
                ->setTotalImpuestos($item->igv + $item->total_icbper)
                ->setMtoPrecioUnitario($item->precio_unitario);

            if ($item->afecto_icbper) {
                $i->setIcbper($item->cantidad * $item->icbper) // (cantidad)*(factor ICBPER)
                    ->setFactorIcbper($item->icbper);
            }

            $detalle[] = $i;
        }

        return $detalle;
    }

    public function enviarSunat(Ventas $venta)
    {
    }
}
