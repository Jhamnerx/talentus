<?php

namespace App\Listeners\Facturacion;

use App\Events\Facturacion\EmitirComprobante;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateComprobante
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EmitirComprobante $event): void
    {

        if ($event->action == 'no_update') {
            $event->venta->update(
                [
                    'estado_texto' => $event->respuesta['estado_texto'],
                    'fe_mensaje_sunat' => $event->respuesta['fe_mensaje_sunat'],
                    'fe_mensaje_error' => $event->respuesta['fe_mensaje_error'],
                    'nota' => $event->respuesta['nota'],
                    'fe_codigo_error' => $event->respuesta['fe_codigo_error'],
                    'cdr_base64' => $event->respuesta['cdr_base64'],
                    'fe_estado' => $event->respuesta['fe_estado'],
                    'hash' => $event->respuesta['hash'],
                    'hash_cdr' => $event->respuesta['hash_cdr'],
                    'code_sunat' => $event->respuesta['code_sunat'],
                    'estado' => $event->estado
                ]
            );
        }

        if ($event->action == 'update') {

            $event->venta->update(
                [
                    'estado_texto' => $event->respuesta['estado_texto'],
                    'fe_mensaje_sunat' => $event->respuesta['fe_mensaje_sunat'],
                    'fe_mensaje_error' => $event->respuesta['fe_mensaje_error'],
                    'nota' => $event->respuesta['nota'],
                    'fe_codigo_error' => $event->respuesta['fe_codigo_error'],
                    'nombre_xml' => $event->respuesta['nombre_xml'],
                    'nombre_cdr' => $event->respuesta['nombre_cdr'],
                    'xml_base64' => $event->respuesta['xml_base64'],
                    'cdr_base64' => $event->respuesta['cdr_base64'],
                    'fe_estado' => $event->respuesta['fe_estado'],
                    'hash' => $event->respuesta['hash'],
                    'hash_cdr' => $event->respuesta['hash_cdr'],
                    'code_sunat' => $event->respuesta['code_sunat'],
                    'estado' => $event->estado,
                    'clase' => $event->invoice,
                ]
            );
        }
    }
}
