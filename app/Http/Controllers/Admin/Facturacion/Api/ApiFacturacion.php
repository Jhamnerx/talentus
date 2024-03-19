<?php

namespace App\Http\Controllers\Admin\Facturacion\Api;

use DateTime;
use App\Models\Ventas;
use App\Models\Clientes;
use App\Models\plantilla;
use App\Events\EmitirGuia;
use App\Models\NotaDebito;
use App\Models\NotaCredito;
use App\Models\GuiaRemision;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Despatch\Puerto;
use Greenter\Model\Sale\SaleDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\Shipment;
use App\Events\Facturacion\EmitirNota;
use Greenter\Model\Despatch\Direction;
use Illuminate\Support\Facades\Storage;
use Greenter\Model\Sale\DetailAttribute;
use Luecano\NumeroALetras\NumeroALetras;
use Greenter\Model\Despatch\AdditionalDoc;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use App\Events\Facturacion\EmitirComprobante as FacturacionEmitirComprobante;
use App\Events\Facturacion\EmitirGuia as FacturacionEmitirGuia;

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

    //EMITIR GUIA DE REMISION
    public function emitirGuia(GuiaRemision $guia)
    {
        $util = Util::getInstance();
        $plantilla = plantilla::first();
        $cliente = $this->getCliente($guia->cliente);

        //ESTABLECER DATOS DE LA GUIA DE REMISION
        $envio = new Shipment();
        $envio
            ->setCodTraslado($guia->motivo_traslado_id) // Cat.20 - Traslado entre establecimientos de la misma empresa
            ->setModTraslado($guia->modalidad_transporte_id) // Cat.18 - Transp. Privado
            ->setIndicadores(['SUNAT_Envio_IndicadorTrasladoVehiculoM1L']) // Transp M1 y L
            ->setFecTraslado(new DateTime($guia->fecha_inicio_traslado))
            ->setPesoTotal($guia->peso)
            ->setUndPesoTotal('KGM')
            ->setLlegada($this->getDirectionGuiaLLegada($guia, $plantilla->ruc))

            ->setPartida($this->getDirectionGuiaPartida($guia, $plantilla->ruc));


        //VERIFICA SI EL MOTIVO DE TRASLADO ES IMPORTACION O EXPORTACION y AGREGA EL PUERTO
        if ($guia->motivo_traslado_id == '08' || $guia->motivo_traslado_id == '09') {

            $envio->setContenedores([$guia->numero_contenedor]);

            $puerto = (new Puerto())->setCodigo($guia->data_puerto['code_puerto'])
                ->setNombre($guia->data_puerto['nombre_puerto']);

            $envio->setPuerto($puerto);
        }


        //VERIFICA SI EL MOTIVO DE TRASLADO ES OTRO Y AGREGA LA DESCRIPCION
        if ($guia->motivo_traslado_id == '13') {

            $envio->setDesTraslado($guia->descripcion_motivo_traslado);
        }
        //ESTABLECER GUIA DE REMISION
        $despatch = new Despatch();
        $despatch->setVersion('2022')
            ->setTipoDoc('09')
            ->setSerie($guia->serie)
            ->setCorrelativo($guia->correlativo)
            ->setFechaEmision(new DateTime($guia->fecha_emision))
            ->setCompany($util->getCompany())
            ->setDestinatario($cliente) // misma empresa
            ->setEnvio($envio);

        //AGREGAR DOCUMENTO RELACIONADO SI EL MOTIVO DE TRASLADO ES IMPORTACION O EXPORTACION
        if ($guia->motivo_traslado_id == '08' || $guia->motivo_traslado_id == '09') {

            $relDoc = (new AdditionalDoc())
                ->setTipo($guia->docu_rel_tipo)
                ->setTipoDesc('Declaración Aduanera de Mercancías')
                ->setNro($guia->docu_rel_numero);
            // ->setNro('235-2024-10-000329');  //formato para el nro de documento relacionado tipo 50
            $despatch->setAddDocs([$relDoc]);
        } else {

            //AGREGAR DOCUMENTO RELACIONADO SI ES QUE LA GUIA ESTA RELACIONADA A UNA VENTA
            if ($guia->venta) {

                $relDoc = (new AdditionalDoc())
                    ->setTipo($guia->venta->tipo_comprobante_id)
                    ->setTipoDesc('Factura')
                    ->setNro($guia->venta->serie_correlativo);

                $despatch->setAddDocs([$relDoc]);
            }
        }



        //ESTABLECER ITEMS DE LA GUIA DE REMISION
        $despatch->setDetails($this->getItemsGuia($guia->detalle));



        // Envio a SUNAT.
        $api = $util->getSeeApi();
        $res = $api->send($despatch);

        // Guardar XML firmado digitalmente.
        $util->writeXml($despatch, $api->getLastXml());
        // dd($despatch);
        if (!$res->isSuccess()) {
            $msg = $util->getErrorResponse($res->getError());
            return $msg;
        }

        /**@var $res SummaryResult*/
        $ticket = $res->getTicket();

        $res = $api->getStatus($ticket);

        if (!$res->isSuccess()) {
            $msg = $util->getErrorResponse($res->getError());
            return $msg;
        }

        $cdr = $res->getCdrResponse();
        //Guardar CDR recibido
        $util->writeCdr($despatch, $res->getCdrZip());

        $respuesta = $util->showResponse($despatch, $cdr);

        dd($respuesta);

        $this->updateGuiaRemision($guia, $respuesta, $despatch);

        return $respuesta;
    }

    public function updateGuiaRemision($guia, $respuesta, $despatch)
    {

        FacturacionEmitirGuia::dispatch($guia, $respuesta, $despatch);
    }

    //ESTABLECER ITEMS DE LA GUIA DE REMISION
    public function getItemsGuia($items)
    {
        $detalle = [];

        foreach ($items as $item) {

            $detalle[] = (new DespatchDetail())
                ->setCantidad($item->cantidad)
                ->setUnidad($item->unidad_medida)
                ->setDescripcion($item->descripcion)
                ->setCodigo($item->codigo)
                ->setCodProdSunat('50161509'); // Catalogo 25
            // ->setAtributos([
            //     (new DetailAttribute())
            //         ->setCode('7020')
            //         ->setName('Partida arancelaria')
            //         ->setValue('1701130000'),
            //     (new DetailAttribute())
            //         ->setCode('7022')
            //         ->setName('Indicador de bien normalizado')
            //         ->setValue('1')
            // ]);
        }

        return $detalle;
    }

    //ESTABLECER DIRECCION DE LLEGADA
    public function getDirectionGuiaLLegada($guia, $ruc): Direction
    {

        $direction = new Direction($guia->ubigeo_llegada, $guia->direccion_llegada);

        if ($guia->motivo_traslado_id == '04') {

            $direction->setRuc($ruc)
                ->setCodLocal('00001'); // Código de establecimiento anexo
        }

        return $direction;
    }
    //ESTABLECER DIRECCION DE PARTIDA
    public function getDirectionGuiaPartida($guia, $ruc): Direction
    {
        $direction = new Direction($guia->ubigeo_partida, $guia->direccion_partida);

        if ($guia->motivo_traslado_id == '04') {

            $direction->setRuc($ruc)
                ->setCodLocal('00002'); // Código de establecimiento anexo
        }

        return $direction;
    }
}
