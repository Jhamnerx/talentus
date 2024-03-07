<?php

namespace App\Http\Controllers\Admin\Facturacion\Api;

use DateTime;
use App\Models\Ventas;
use App\Models\plantilla;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\SaleDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Luecano\NumeroALetras\NumeroALetras;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use App\Events\Facturacion\EmitirComprobante as FacturacionEmitirComprobante;
use App\Events\Facturacion\EmitirNota;
use App\Models\Clientes;
use App\Models\NotaCredito;
use App\Models\NotaDebito;

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
    //DETERMINAR SI ES NOTA DE DEBITO O CREDITO
    public function emitirNota($nota, $tipo_comprobante)
    {

        if ($tipo_comprobante == '07') {
            return  $this->emitirNotaCredito($nota, $tipo_comprobante);
        }
        if ($tipo_comprobante == '08') {

            return $this->emitirNotaDebito($nota, $tipo_comprobante);
        }
    }
    //EMITIR NOTA DE CREDITO
    public function emitirNotaCredito(NotaCredito $nota, $tipo_comprobante)
    {

        $util = Util::getInstance();
        $formatter = new NumeroALetras();
        $cliente = $this->getCliente($nota->cliente);

        $note = new Note();
        $note
            ->setUblVersion('2.1')
            ->setTipoDoc('07')
            ->setSerie($nota->serie)
            ->setCorrelativo($nota->correlativo)
            ->setFechaEmision($nota->fecha_emision)
            ->setTipDocAfectado($nota->tipo_comprobante_ref) // Tipo Doc: Factura
            ->setNumDocfectado($nota->serie_correlativo_ref) // Factura: Serie-Correlativo
            ->setCodMotivo($nota->sustento_id) // Catalogo. 09
            ->setDesMotivo($nota->sustento->descripcion)
            ->setTipoMoneda($nota->divisa)
            // ->setGuias([/* Guias (Opcional) */
            //     (new Document())
            //         ->setTipoDoc('09')
            //         ->setNroDoc('0001-213')
            // ])
            ->setCompany($util->getCompany())
            ->setClient($cliente)
            ->setMtoOperGravadas($nota->op_gravadas)
            ->setMtoOperExoneradas($nota->op_exoneradas)
            ->setMtoOperInafectas($nota->op_inafectas)
            ->setMtoIGV($nota->igv)
            ->setIcbper($nota->icbper)
            ->setTotalImpuestos($nota->igv + $nota->icbper)
            ->setMtoImpVenta($nota->total);

        //EVALUAR SI LA NOTA ES A CREDITO
        if ($nota->venta->forma_pago == 'CREDITO') {

            $note->setFormaPago(new FormaPagoCredito($nota->total, $nota->divisa));
            $cuotas = $this->addCuotas($nota->venta);
            $note->setCuotas($cuotas);
        }
        //ESTABLECER ITEMS DEL COMPROBANTE
        $items = $this->getItemsInvoice($nota->venta->ventaDetalles);

        $note->setDetails($items)
            ->setLegends([
                (new Legend())
                    ->setCode('1000')
                    ->setValue($formatter->toInvoice($nota->total, 2, 'soles'))
            ]);


        // Envio a SUNAT.
        $see = $util->getSee();
        $result = $see->send($note);


        // Guardar XML firmado digitalmente.
        $util->writeXml($note, $see->getFactory()->getLastXml());

        if (!$result->isSuccess()) {

            $msg = $util->getErrorResponse($result->getError());
            $this->updateNota($tipo_comprobante, $nota, $msg, 'update', $note);
            return $msg;
        }


        /**@var $res BillResult*/
        $cdr = $result->getCdrResponse();

        //Guardar CDR recibido
        $util->writeCdr($note, $result->getCdrZip());


        $respuesta = $util->showResponse($note, $cdr);


        //ACTUALIZAR COMPROBANTE CON LOS DATOS DEVUELTOS POR EL API
        $this->updateNota($tipo_comprobante, $nota, $respuesta, 'update', $note);

        return $respuesta;
    }

    //EMITIR NOTA DE DEBITO
    public function emitirNotaDebito(NotaDebito $nota, $tipo_comprobante)
    {
        $util = Util::getInstance();
        $formatter = new NumeroALetras();
        $cliente = $this->getCliente($nota->cliente);

        $note = new Note();
        $note
            ->setUblVersion('2.1')
            ->setTipDocAfectado($nota->tipo_comprobante_ref)
            ->setNumDocfectado($nota->serie_correlativo_ref)
            ->setCodMotivo($nota->sustento_id)
            ->setDesMotivo($nota->sustento->descripcion)
            ->setTipoDoc('08')
            ->setSerie($nota->serie)
            ->setFechaEmision($nota->fecha_emision)
            ->setCorrelativo($nota->correlativo)
            ->setTipoMoneda($nota->divisa)
            ->setCompany($util->getCompany())
            ->setClient($cliente)
            ->setMtoOperGravadas($nota->op_gravadas)
            ->setMtoOperExoneradas($nota->op_exoneradas)
            ->setMtoOperInafectas($nota->op_inafectas)
            ->setMtoIGV($nota->igv)
            ->setIcbper($nota->icbper)
            ->setTotalImpuestos($nota->igv + $nota->icbper)
            ->setMtoImpVenta($nota->total);

        //EVALUAR SI LA NOTA ES A CREDITO
        if ($nota->venta->forma_pago == 'CREDITO') {

            $note->setFormaPago(new FormaPagoCredito($nota->total, $nota->divisa));
            $cuotas = $this->addCuotas($nota->venta);
            $note->setCuotas($cuotas);
        }

        //ESTABLECER ITEMS DEL COMPROBANTE
        $items = $this->getItemsInvoice($nota->venta->ventaDetalles);

        $note->setDetails($items)
            ->setLegends([
                (new Legend())
                    ->setCode('1000')
                    ->setValue($formatter->toInvoice($nota->total, 2, 'soles'))
            ]);


        // Envio a SUNAT.
        $see = $util->getSee();
        $result = $see->send($note);

        // Guardar XML firmado digitalmente.
        $util->writeXml($note, $see->getFactory()->getLastXml());

        if (!$result->isSuccess()) {

            $msg = $util->getErrorResponse($result->getError());
            $this->updateNota($tipo_comprobante, $nota, $msg, 'update', $note);
            return $msg;
        }

        /**@var $res BillResult*/
        $cdr = $result->getCdrResponse();

        //Guardar CDR recibido
        $util->writeCdr($note, $result->getCdrZip());


        $respuesta = $util->showResponse($note, $cdr);

        //ACTUALIZAR COMPROBANTE CON LOS DATOS DEVUELTOS POR EL API
        $this->updateNota($tipo_comprobante, $nota, $respuesta, 'update', $note);

        return $respuesta;
    }



    //CREAR XML - FIRMADO Y ENVIO A SUNAT
    public function emitirComprobante(Ventas $venta)
    {

        $util = Util::getInstance();

        $formatter = new NumeroALetras();
        $cliente = $this->getCliente($venta->cliente);

        // RELACIONAR FACTURA CON GUIA DE REMISION EMITIDA
        // $guiaRemision = (new Document())
        // ->setTipoDoc('09') // Guia de Remision remitente: 09, catalogo 01
        // ->setNroDoc('T001-2'); // Serie y correlativo de la guia de remision



        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setFecVencimiento(new DateTime($venta->fecha_vencimiento))
            ->setTipoOperacion('0101')
            ->setObservacion($venta->comentario)
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
            ->setIcbper($venta->icbper)
            ->setTotalImpuestos($venta->igv + $venta->icbper)
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

        /** Si solo desea enviar un XML ya generado utilice esta función**/
        //$res = $see->sendXml(get_class($invoice), $invoice->getName(), file_get_contents($ruta_XML));

        $result = $see->send($invoice);

        // Guardar XML firmado digitalmente.
        $util->writeXml($invoice, $see->getFactory()->getLastXml());

        if (!$result->isSuccess()) {

            $msg = $util->getErrorResponse($result->getError());
            $this->updateComprobante($venta, $msg, 'BORRADOR', 'update', $invoice);
            return $msg;
        }

        /**@var $res BillResult*/
        $cdr = $result->getCdrResponse();
        //Guardar CDR recibido
        $util->writeCdr($invoice, $result->getCdrZip());

        $respuesta = $util->showResponse($invoice, $cdr);

        //ACTUALIZAR COMPROBANTE CON LOS DATOS DEVUELTOS POR EL API
        $this->updateComprobante($venta, $respuesta, 'COMPLETADO', 'update', $invoice);

        return $respuesta;
    }


    public function sendInvoiceOnly(Ventas $venta)
    {
        $util = Util::getInstance();
        $formatter = new NumeroALetras();
        $cliente = $this->getCliente($venta->cliente);
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
            ->setObservacion($venta->comentario)
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
            ->setIcbper($venta->icbper)
            ->setTotalImpuestos($venta->igv + $venta->icbper)
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

        $result = $see->sendXml(get_class($invoice), $invoice->getName(), Storage::disk('facturacion')->get($plantilla->empresa->nombre . '/xml' . '/' . $venta->nombre_xml . '.xml'));

        if (!$result->isSuccess()) {

            $msg = $util->getErrorResponse($result->getError());

            //$this->updateComprobante($venta, $msg, 'BORRADOR', 'no_update', $invoice);
            // dd($msg);
            return $msg;
        }

        /**@var $res BillResult*/
        $cdr = $result->getCdrResponse();
        //Guardar CDR recibido
        $util->writeCdr($invoice, $result->getCdrZip());

        $respuesta = $util->showResponse($invoice, $cdr);

        //ACTUALIZAR COMPROBANTE CON LOS DATOS DEVUELTOS POR EL API
        $this->updateComprobante($venta, $respuesta, 'COMPLETADO', 'no_update', $invoice);

        return $respuesta;
    }

    //CREAR XML Y FIRMADO - PENDIENTE DE ENVIO
    public function createXmlInvoice(Ventas $venta)
    {
        $util = Util::getInstance();
        $formatter = new NumeroALetras();
        // Cliente
        $cliente = $this->getCliente($venta->cliente);

        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setFecVencimiento(new DateTime($venta->fecha_vencimiento))
            ->setTipoOperacion('0101')
            ->setObservacion($venta->comentario)
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
            ->setIcbper($venta->icbper)
            ->setTotalImpuestos($venta->igv + $venta->icbper)
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
        $xml_base64 = $util->writeXmlOnly($invoice, $xml);
        $hash = $util->getHash($invoice);

        $respuesta
            =  [
                'estado_texto' => 'ESTADO: SOLO XML CREADO',
                'fe_mensaje_sunat' => "El comprobante fue firmado, Pendiente de Envio",
                'fe_mensaje_error' => null,
                'nota' => '',
                'fe_codigo_error' => null,
                'nombre_xml' => $invoice->getName(),
                'xml_base64' => $xml_base64,
                'cdr_base64' => null,
                'fe_estado' => 0,
                'hash' => $hash,
                'hash_cdr' => null,
                'code_sunat' => null,

            ];


        $this->updateComprobante($venta, $respuesta, 'BORRADOR', 'update', $invoice);

        return $respuesta;
    }

    public function updateComprobante(Ventas $venta, $respuesta, $estado, $action, $invoice)
    {
        FacturacionEmitirComprobante::dispatch($venta, $respuesta, $estado, $action, $invoice);
    }

    //ACTUALIZAR NOTA CON LA RESPUESTA DE SUNAT
    public function updateNota($tipo_comprobante, $nota, $respuesta, $action, $note)
    {
        EmitirNota::dispatch($tipo_comprobante, $nota, $respuesta, $action, $note);
    }


    //DEVOLVER OBJETO CLIENTE
    public function getCliente(Clientes $cliente)
    {
        // Cliente
        $cliente = (new Client())
            ->setTipoDoc($cliente->tipo_documento_id)
            ->setNumDoc($cliente->numero_documento)
            ->setRznSocial($cliente->razon_social)
            ->setAddress((new Address())
                ->setDireccion($cliente->direccion))
            ->setEmail($cliente->email)
            ->setTelephone($cliente->telefono);

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

    public function convertCertificado($ruta, $password)
    {
        $util = Util::getInstance();

        $respuesta = $util->convertToPem($ruta, $password);

        return $respuesta;
    }
}
