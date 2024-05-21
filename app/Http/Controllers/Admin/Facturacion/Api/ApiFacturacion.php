<?php

namespace App\Http\Controllers\Admin\Facturacion\Api;

use DateTime;
use Carbon\Carbon;
use App\Models\Ventas;
use App\Models\Clientes;
use App\Models\plantilla;
use App\Models\Comprobantes;
use App\Models\Detracciones;
use App\Models\GuiaRemision;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Client\Client;
use Greenter\Model\Voided\Voided;
use Greenter\Model\Company\Address;
use Greenter\Model\Despatch\Puerto;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Prepayment;
use Greenter\Model\Sale\SaleDetail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\Shipment;
use App\Events\Facturacion\EmitirNota;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Voided\VoidedDetail;
use Illuminate\Support\Facades\Storage;
use Greenter\Model\Sale\DetailAttribute;
use Luecano\NumeroALetras\NumeroALetras;
use Greenter\Model\Despatch\AdditionalDoc;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Response\StatusCdrResult;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Greenter\Services\InvalidServiceResponseException;
use App\Events\Facturacion\EmitirGuia as FacturacionEmitirGuia;
use App\Events\Facturacion\EmitirComprobante as FacturacionEmitirComprobante;

class ApiFacturacion extends Controller
{
    public $filename = null;

    public function emitirInvoice(Ventas $venta, $metodo_type, $tipo_operacion = '0101')
    {
        if ($metodo_type == "02") {

            return $this->emitirComprobante($venta, $tipo_operacion);
        } else {


            return  $this->createXmlInvoice($venta, $tipo_operacion);
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
    public function emitirNotaCredito(Comprobantes $nota, $tipo_comprobante)
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
                    ->setValue($formatter->toInvoice($nota->total, 2, $nota->divisa == 'PEN' ? 'SOLES' : 'DÓLARES'))
            ]);


        // Envio a SUNAT.
        $see = $util->getSee();
        $result = $see->send($note);


        // Guardar XML firmado digitalmente.
        $util->writeXml($note, $see->getFactory()->getLastXml());

        if (!$result->isSuccess()) {

            $msg = $util->getErrorResponse($result->getError());
            $this->updateNota($nota, $msg, 'update', $note);
            return $msg;
        }


        /**@var $res BillResult*/
        $cdr = $result->getCdrResponse();

        //Guardar CDR recibido
        $util->writeCdr($note, $result->getCdrZip());


        $respuesta = $util->showResponse($note, $cdr);


        //ACTUALIZAR COMPROBANTE CON LOS DATOS DEVUELTOS POR EL API
        $this->updateNota($nota, $respuesta, 'update', $note);

        return $respuesta;
    }

    //EMITIR NOTA DE DEBITO
    public function emitirNotaDebito(Comprobantes $nota, $tipo_comprobante)
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
                    ->setValue($formatter->toInvoice($nota->total, 2, $nota->divisa == 'PEN' ? 'SOLES' : 'DÓLARES'))
            ]);


        // Envio a SUNAT.
        $see = $util->getSee();
        $result = $see->send($note);

        // Guardar XML firmado digitalmente.
        $util->writeXml($note, $see->getFactory()->getLastXml());

        if (!$result->isSuccess()) {

            $msg = $util->getErrorResponse($result->getError());
            $this->updateNota($nota, $msg, 'update', $note);
            return $msg;
        }

        /**@var $res BillResult*/
        $cdr = $result->getCdrResponse();

        //Guardar CDR recibido
        $util->writeCdr($note, $result->getCdrZip());


        $respuesta = $util->showResponse($note, $cdr);

        //ACTUALIZAR COMPROBANTE CON LOS DATOS DEVUELTOS POR EL API
        $this->updateNota($nota, $respuesta, 'update', $note);

        return $respuesta;
    }

    //ACTUALIZAR NOTA CON LA RESPUESTA DE SUNAT
    public function updateNota($nota, $respuesta, $action, $note)
    {
        EmitirNota::dispatch($nota, $respuesta, $action, $note);
    }

    //CREAR XML - FIRMADO Y ENVIO A SUNAT
    public function emitirComprobante(Ventas $venta, $tipo_operacion)
    {

        $util = Util::getInstance();
        $invoice = $this->createObjetInvoice($venta, $tipo_operacion);

        // Envio a SUNAT.
        $see = $util->getSee();
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
    //CREAR XML Y FIRMADO - PENDIENTE DE ENVIO
    public function createXmlInvoice(Ventas $venta, $tipo_operacion)
    {

        $util = Util::getInstance();
        $invoice = $this->createObjetInvoice($venta, $tipo_operacion);

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
                'nombre_cdr' => 'R-' . $invoice->getName(),
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

    public function createObjetInvoice(Ventas $venta, $tipo_operacion)
    {

        $util = Util::getInstance();

        $cliente = $this->getCliente($venta->cliente);
        // RELACIONAR FACTURA CON GUIA DE REMISION EMITIDA
        // $guiaRemision = (new Document())
        // ->setTipoDoc('09') // Guia de Remision remitente: 09, catalogo 01
        // ->setNroDoc('T001-2'); // Serie y correlativo de la guia de remision

        $invoice = new Invoice();
        $invoice
            ->setUblVersion('2.1')
            ->setFecVencimiento(new DateTime($venta->fecha_vencimiento))
            ->setTipoOperacion($tipo_operacion)  // Catalogo 51
            ->setObservacion($venta->comentario)
            ->setTipoDoc($venta->tipo_comprobante_id)
            ->setSerie($venta->serie)
            ->setCorrelativo($venta->correlativo)
            ->setFechaEmision(new DateTime($venta->fecha_emision))
            ->setTipoMoneda($venta->divisa)
            ->setCompany($util->getCompany())
            ->setClient($cliente)
            ->setMtoOperGravadas($venta->op_gravadas)
            ->setMtoOperExoneradas($venta->op_exoneradas)
            ->setMtoOperInafectas($venta->op_inafectas)
            ->setMtoIGV($venta->igv)
            ->setIcbper($venta->icbper)
            ->setTotalImpuestos($venta->igv + $venta->icbper)
            ->setMtoImpVenta($venta->total);

        if ($venta->detraccion) {

            $invoice->setDetraccion($this->getDetraccion($venta->detraccion));
        }

        if ($venta->anticipos->count() > 0) {
            //ESTABLECER VALORES
            $invoice->setValorVenta($venta->ventaDetalles->sum('sub_total'))
                ->setSubTotal($venta->ventaDetalles->sum('total'));

            //ESTABLECER ANTICIPOS
            foreach ($venta->anticipos as $anticipo) {
                $invoice->setAnticipos([
                    (new Prepayment())
                        ->setTipoDocRel($anticipo->tipo_comprobante_ref) // catalog. 12
                        ->setNroDocRel($anticipo->serie_correlativo_ref)
                        ->setTotal($anticipo->total_invoice_ref)
                ]);

                $invoice->setDescuentos([
                    (
                        new Charge())
                        ->setCodTipo('04')
                        ->setMonto($anticipo->valor_venta_ref) // anticipo
                        ->setMontoBase(2124)
                ]);
            }

            $invoice->setTotalAnticipos($venta->anticipos->sum('total_invoice_ref'));
        } else {
            //ESTABLECER VALORES
            $invoice->setValorVenta($venta->op_gravadas + $venta->op_exoneradas + $venta->op_inafectas)
                ->setSubTotal($venta->total);
        }

        // $invoice->setGuias([
        //     $guiaRemision // Incluir guia remision.
        // ])

        //EVALUAR SI LA VENTA ES A CREDITO
        if ($venta->forma_pago == 'CREDITO') {
            $invoice->setFormaPago(new FormaPagoCredito($venta->detalle_cuotas->sum('importe'), $venta->divisa));
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
                    ->setMontoBase($venta->sub_total)
                    ->setFactor($venta->descuento_factor)
                    ->setMonto($venta->descuento)
            ]);
        }

        //ESTBLECER EL VENDEDOR DEL COMPROBANTE
        $invoice->setSeller((new Client())
            ->setRznSocial(Auth::user()->name));

        //ESTABLECER ITEMS DEL COMPROBANTE
        $items = $this->getItemsInvoice($venta->ventaDetalles);

        $invoice->setDetails($items) //CATALAGO 52 - LEYENDA
            ->setLegends($this->getLegends($venta));

        return $invoice;
    }

    public function getLegends($venta)
    {
        $formatter = new NumeroALetras();

        if ($venta->detraccion) {

            $legends = [
                (new Legend())
                    ->setCode('1000')
                    ->setValue($formatter->toInvoice($venta->total, 2, $venta->divisa == 'PEN' ? 'SOLES' : 'DÓLARES')),
                (new Legend())
                    ->setCode('2006')
                    ->setValue('Operación sujeta a detracción')
            ];

            return $legends;
        } else {
            $legends = [
                (new Legend())
                    ->setCode('1000')
                    ->setValue($formatter->toInvoice($venta->total, 2, $venta->divisa == 'PEN' ? 'SOLES' : 'DÓLARES'))
            ];

            return $legends;
        }
    }

    public function sendInvoiceOnly(Ventas $venta)
    {
        $util = Util::getInstance();
        $plantilla = plantilla::first();

        // Envio a SUNAT.
        $see = $util->getSee();

        $result = $see->sendXml(get_class($venta->clase), $venta->clase->getName(), Storage::disk('facturacion')->get($plantilla->empresa->nombre . '/xml' . '/' . $venta->nombre_xml . '.xml'));

        if (!$result->isSuccess()) {

            $msg = $util->getErrorResponse($result->getError());
            $this->updateComprobante($venta, $msg, 'BORRADOR', 'no_update', $venta->clase);
            return $msg;
        }

        /**@var $res BillResult*/
        $cdr = $result->getCdrResponse();
        //Guardar CDR recibido
        $util->writeCdr($venta->clase, $result->getCdrZip());

        $respuesta = $util->showResponse($venta->clase, $cdr);

        //ACTUALIZAR COMPROBANTE CON LOS DATOS DEVUELTOS POR EL API
        $this->updateComprobante($venta, $respuesta, 'COMPLETADO', 'no_update', $venta->clase);

        return $respuesta;
    }

    public function getDetraccion(Detracciones $detraccion)
    {

        // MONEDA SIEMPRE EN SOLES
        $d = (new Detraction())
            // Carnes y despojos comestibles
            ->setCodBienDetraccion($detraccion->codigo_detraccion) // catalog. 54
            // Deposito en cuenta
            ->setCodMedioPago($detraccion->metodo_pago_id) // catalog. 59
            ->setCtaBanco($detraccion->cuenta_bancaria)
            ->setPercent($detraccion->porcentaje)
            ->setMount($detraccion->monto);

        return $d;
    }

    public function sendInvoiceOnlyNota(Comprobantes $nota)
    {
        $util = Util::getInstance();
        $plantilla = plantilla::first();

        // Envio a SUNAT.
        $see = $util->getSee();

        $result = $see->sendXml(get_class($nota->clase), $nota->clase->getName(), Storage::disk('facturacion')->get($plantilla->empresa->nombre . '/xml' . '/' . $nota->nombre_xml . '.xml'));

        if (!$result->isSuccess()) {

            $msg = $util->getErrorResponse($result->getError());
            return $msg;
        }

        /**@var $res BillResult*/
        $cdr = $result->getCdrResponse();
        //Guardar CDR recibido
        $util->writeCdr($nota->clase, $result->getCdrZip());

        $respuesta = $util->showResponse($nota->clase, $cdr);

        //ACTUALIZAR COMPROBANTE CON LOS DATOS DEVUELTOS POR EL API
        $this->updateNota($nota, $respuesta, 'no_update', $nota->clase);
        return $respuesta;
    }


    public function sendInvoiceOnlyGuia($guia)
    {
        $util = Util::getInstance();
        $plantilla = plantilla::first();

        // Envio a SUNAT.
        $api = $util->getSeeApi();
        try {
            $res = $api->send($guia->clase);
        } catch (InvalidServiceResponseException $e) {
            return [
                'success' => false,
                'error_session' => $e->getMessage(),
            ];
        }

        $res = $api->sendXml($guia->clase->getName(), Storage::disk('facturacion')->get($plantilla->empresa->nombre . '/xml' . '/' . $guia->nombre_xml . '.xml'));

        if (!$res->isSuccess()) {

            $respuesta = $util->getErrorResponse($res->getError());
            $this->updateGuiaRemision($guia, $respuesta, $guia->clase, 'no_update');
            return $respuesta;
        }

        /**@var $res SummaryResult*/
        $ticket = $res->getTicket();

        $res = $api->getStatus($ticket);
        $this->updateTicket($guia, $ticket);

        if (!$res->isSuccess()) {
            $respuesta = $util->getErrorResponse($res->getError());
            $this->updateGuiaRemision($guia, $respuesta, $guia->clase);
            return $respuesta;
        }

        $cdr = $res->getCdrResponse();
        //Guardar CDR recibido
        $util->writeCdr($guia->clase, $res->getCdrZip());

        $respuesta = $util->showResponse($guia->clase, $cdr);

        $this->updateGuiaRemision($guia, $respuesta, $guia->clase, 'no_update');
        return $respuesta;
    }

    public function consultaTicket($guia)
    {
        $util = Util::getInstance();

        // Envio a SUNAT.
        $api = $util->getSeeApi();

        $res = $api->getStatus($guia->ticket);

        if (!$res->isSuccess()) {
            $respuesta = $util->getErrorResponse($res->getError());
            $this->updateGuiaRemision($guia, $respuesta, $guia->clase, 'no_update');
            return $respuesta;
        }

        $cdr = $res->getCdrResponse();
        //Guardar CDR recibido
        $util->writeCdr($guia->clase, $res->getCdrZip());

        $respuesta = $util->showResponse($guia->clase, $cdr);
        $this->updateGuiaRemision($guia, $respuesta, $guia->clase, 'no_update');

        return $respuesta;
    }


    public function updateComprobante(Ventas $venta, $respuesta, $estado, $action, $invoice)
    {
        FacturacionEmitirComprobante::dispatch($venta, $respuesta, $estado, $action, $invoice);
    }

    //DEVOLVER OBJETO CLIENTE
    public function getCliente(Clientes $cliente)
    {
        // Cliente
        $cliente = (new Client())
            ->setTipoDoc($cliente->tipo_documento_id)
            ->setNumDoc(trim($cliente->numero_documento))
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
                ->setTotalImpuestos($item->igv + $item->total_icbper);

            if ($item->codigo_afectacion == '10') {
                $i->setMtoPrecioUnitario($item->precio_unitario);
            } else {
                $i->setMtoPrecioUnitario($item->valor_unitario);
            }

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
                    ->setEmisor($plantilla->ruc)
                    ->setNro($guia->venta->serie_correlativo);

                $despatch->setAddDocs([$relDoc]);
            }
        }

        //ESTABLECER ITEMS DE LA GUIA DE REMISION
        $despatch->setDetails($this->getItemsGuia($guia->detalle));
        $despatch->setObservacion($guia->observacion);
        // Envio a SUNAT.
        $api = $util->getSeeApi();
        try {
            $res = $api->send($despatch);
        } catch (InvalidServiceResponseException $e) {
            return [
                'success' => false,
                'error_session' => $e->getMessage(),
            ];
        }
        // Guardar XML firmado digitalmente.
        $util->writeXml($despatch, $api->getLastXml());

        if (!$res->isSuccess()) {
            $respuesta = $util->getErrorResponse($res->getError());
            $this->updateGuiaRemision($guia, $respuesta, $despatch);

            return $respuesta;
        }

        /**@var $res SummaryResult*/
        $ticket = $res->getTicket();

        $res = $api->getStatus($ticket);
        $this->updateTicket($guia, $ticket);
        //CREAR TABLA TICKETS PARA NO PERDERLOS
        if (!$res->isSuccess()) {
            $respuesta = $util->getErrorResponse($res->getError());
            $this->updateGuiaRemision($guia, $respuesta, $despatch); //ACTUALIZAR GUIA CUANDO SOLO OBTENEMOS EL TICKET

            return $respuesta;
        }

        $cdr = $res->getCdrResponse();
        //Guardar CDR recibido
        $util->writeCdr($despatch, $res->getCdrZip());

        $respuesta = $util->showResponse($despatch, $cdr);
        $this->updateGuiaRemision($guia, $respuesta, $despatch);
        return $respuesta;
    }


    public function updateClaseGuia(GuiaRemision $guia)
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
                    ->setEmisor($plantilla->ruc)
                    ->setNro($guia->venta->serie_correlativo);

                $despatch->setAddDocs([$relDoc]);
            }
        }

        //ESTABLECER ITEMS DE LA GUIA DE REMISION
        $despatch->setDetails($this->getItemsGuia($guia->detalle));
        $despatch->setObservacion($guia->observacion);

        $guia->update([
            'clase' => $despatch,
        ]);


        $respuesta
            =  [
                'estado_texto' => 'ESTADO: SE CREÓ LA CLASE',
                'fe_mensaje_sunat' => "El comprobante fue serializado correctamente",
                'fe_mensaje_error' => null,
                'nota' => '',
                'fe_codigo_error' => null,
            ];
        return $respuesta;
    }

    //FUNCION QUE SE EJECUTA CUANDO SE ACTUALIZA UNA GUIA DE REMISION
    public function createXmlGuia(GuiaRemision $guia)
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
                    ->setEmisor($plantilla->ruc)
                    ->setNro($guia->venta->serie_correlativo);

                $despatch->setAddDocs([$relDoc]);
            }
        }

        //ESTABLECER ITEMS DE LA GUIA DE REMISION
        $despatch->setDetails($this->getItemsGuia($guia->detalle));
        $despatch->setObservacion($guia->observacion);

        // Envio a SUNAT.
        $api = $util->getSeeApi();
        try {
            $res = $api->send($despatch);
        } catch (InvalidServiceResponseException $e) {
            return [
                'success' => false,
                'error_session' => $e->getMessage(),
            ];
        }

        // Guardar XML firmado digitalmente.
        $util->writeXml($despatch, $api->getLastXml());

        if (!$res->isSuccess()) {
            $respuesta = $util->getErrorResponse($res->getError());
            $this->updateGuiaRemision($guia, $respuesta, $despatch);
            return $respuesta;
        }

        /**@var $res SummaryResult*/
        $ticket = $res->getTicket();

        $res = $api->getStatus($ticket);
        $this->updateTicket($guia, $ticket);

        if (!$res->isSuccess()) {
            $respuesta = $util->getErrorResponse($res->getError());
            $this->updateGuiaRemision($guia, $respuesta, $despatch, 'no_update'); //ACTUALIZAR GUIA CUANDO SOLO OBTENEMOS EL TICKET

            return $respuesta;
        }

        $cdr = $res->getCdrResponse();
        //Guardar CDR recibido
        $util->writeCdr($despatch, $res->getCdrZip());

        $respuesta = $util->showResponse($despatch, $cdr);
        $this->updateGuiaRemision($guia, $respuesta, $despatch);

        return $respuesta;
    }

    public function updateGuiaRemision($guia, $respuesta, $despatch, $action = 'update')
    {

        FacturacionEmitirGuia::dispatch($guia, $respuesta, $despatch, $action);
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
                ->setCodLocal($guia->codigo_establecimiento_llegada); // Código de establecimiento anexo
        }

        return $direction;
    }
    //ESTABLECER DIRECCION DE PARTIDA
    public function getDirectionGuiaPartida($guia, $ruc): Direction
    {
        $direction = new Direction($guia->ubigeo_partida, $guia->direccion_partida);

        if ($guia->motivo_traslado_id == '04') {

            $direction->setRuc($ruc)
                ->setCodLocal($guia->codigo_establecimiento_partida); // Código de establecimiento anexo
        }

        return $direction;
    }


    public function anularComprobante($datos, $resumen)
    {

        $util = Util::getInstance();

        $detail1 = new VoidedDetail();
        $detail1->setTipoDoc($datos['tipo_comprobante'])
            ->setSerie($datos['serie_ref'])
            ->setCorrelativo($datos['correlativo_ref'])
            ->setDesMotivoBaja($datos['motivo']);

        $voided = new Voided();
        $voided->setCorrelativo($datos['correlativo'])
            // Fecha Generacion menor que Fecha comunicacion
            ->setFecGeneracion(new DateTime($datos['fecha_emision_invoice'])) //FECHA DE LA EMISION DE LOS COMPROBANTES
            ->setFecComunicacion(new DateTime($datos['fecha_generacion']))
            ->setCompany($util->getCompany())
            ->setDetails([$detail1]);

        // Envio a SUNAT.
        $see = $util->getSee();
        $res = $see->send($voided);

        // Guardar XML firmado digitalmente.
        $util->writeXml($voided, $see->getFactory()->getLastXml());

        if (!$res->isSuccess()) {
            $msg =  $util->getErrorResponse($res->getError());
            $this->actualizarResumen($resumen, $msg, $voided, 'update');
            return $msg;
        }

        /**@var SummaryResult $res */
        $ticket = $res->getTicket();
        $this->updateTicket($resumen, $ticket);
        // echo 'Ticket :<strong>' . $ticket . '</strong>';

        $res = $see->getStatus($ticket);

        if (!$res->isSuccess()) {
            $msg =  $util->getErrorResponse($res->getError());
            $this->actualizarResumen($resumen, $msg, $voided, 'update');
            return $msg;
        }

        $cdr = $res->getCdrResponse();

        //Guardar CDR recibido
        $util->writeCdr($voided, $res->getCdrZip());

        $respuesta = $util->showResponse($voided, $cdr);

        //ACTUALIZAR COMPROBANTE CON LOS DATOS DEVUELTOS POR EL API
        $this->actualizarResumen($resumen, $respuesta, $voided, 'update');
        return $respuesta;
    }

    public function consultaTicketAnulacion($resumen)
    {
        $util = Util::getInstance();

        $see = $util->getSee();

        $res = $see->getStatus($resumen->ticket);

        if (!$res->isSuccess()) {
            $msg =  $util->getErrorResponse($res->getError());
            return $msg;
        }

        $cdr = $res->getCdrResponse();

        //Guardar CDR recibido
        $util->writeCdr($resumen->clase, $res->getCdrZip());

        $respuesta = $util->showResponse($resumen->clase, $cdr);
        //ACTUALIZAR COMPROBANTE CON LOS DATOS DEVUELTOS POR EL API
        $this->actualizarResumen($resumen, $respuesta, $resumen->clase, 'update');

        return $respuesta;
    }

    public function getTicketAnulacion($resumen)
    {
        $util = Util::getInstance();

        // Envio a SUNAT.
        $see = $util->getSee();
        $res = $see->send($resumen->clase);

        // Guardar XML firmado digitalmente.
        $util->writeXml($resumen->clase, $see->getFactory()->getLastXml());

        if (!$res->isSuccess()) {
            $msg =  $util->getErrorResponse($res->getError());
            $this->actualizarResumen($resumen, $msg, $resumen->clase, 'update');
            return $msg;
        }

        /**@var SummaryResult $res */
        $ticket = $res->getTicket();
        $this->updateTicket($resumen, $ticket);
        return true;
    }


    public function updateTicket($invoice, $ticket)
    {
        $invoice->update([
            'ticket' => $ticket
        ]);
    }

    public function actualizarResumen($resumen, $respuesta, $voided, $action)
    {
        //actualizarResumen si action es no_update solo se actualiza el estado del resumen
        if ($action == 'no_update') {
            $resumen->update(
                [
                    'estado_texto' => $respuesta['estado_texto'],
                    'fe_mensaje_sunat' => $respuesta['fe_mensaje_sunat'],
                    'fe_mensaje_error' => $respuesta['fe_mensaje_error'],
                    'nota' => $respuesta['nota'],
                    'fe_codigo_error' => $respuesta['fe_codigo_error'],
                    'cdr_base64' => $respuesta['cdr_base64'],
                    'fe_estado' => $respuesta['fe_estado'],
                    'hash' => $respuesta['hash'],
                    'hash_cdr' => $respuesta['hash_cdr'],
                    'code_sunat' => $respuesta['code_sunat'],
                    'fecha_envio' => Carbon::now(),
                ]
            );
        }

        if ($action == 'update') {
            $resumen->update(
                [
                    'estado_texto' => $respuesta['estado_texto'],
                    'fe_mensaje_sunat' => $respuesta['fe_mensaje_sunat'],
                    'fe_mensaje_error' => $respuesta['fe_mensaje_error'],
                    'nota' => $respuesta['nota'],
                    'fe_codigo_error' => $respuesta['fe_codigo_error'],
                    'nombre_cdr' => $respuesta['nombre_cdr'],
                    'xml_base64' => $respuesta['xml_base64'],
                    'cdr_base64' => $respuesta['cdr_base64'],
                    'fe_estado' => $respuesta['fe_estado'],
                    'hash' => $respuesta['hash'],
                    'hash_cdr' => $respuesta['hash_cdr'],
                    'code_sunat' => $respuesta['code_sunat'],
                    'clase' => $voided,
                    'fecha_envio' => Carbon::now(),
                ]

            );

            if ($respuesta['nombre_xml']) {
                $resumen->update(
                    [
                        'nombre_xml' => $respuesta['nombre_xml'],

                    ]
                );
            }
        }
    }

    /**
     * @param array<string, string> $fields
     * @return StatusCdrResult|null
     */
    public function getStatusCdr(array $fields): ?StatusCdrResult
    {
        $util = Util::getInstance();

        $service = $util->getCdrStatusService();

        $arguments = [
            $fields['ruc'],
            $fields['tipo'],
            $fields['serie'],
            intval($fields['correlativo'])
        ];

        if (isset($fields['cdr'])) {
            $result = $service->getStatusCdr(...$arguments);
            if ($result->getCdrZip()) {
                $this->filename = 'R-' . implode('-', $arguments) . '.zip';
                //savedFile($filename, $result->getCdrZip());
            }

            return $result;
        }

        return $service->getStatus(...$arguments);
    }
}
