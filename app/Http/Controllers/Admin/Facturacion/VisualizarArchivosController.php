<?php

namespace App\Http\Controllers\Admin\Facturacion;

use App\Http\Controllers\Controller;
use App\Models\Comprobantes;
use App\Models\GuiaRemision;
use App\Models\Ventas;
use Illuminate\Http\Request;

class VisualizarArchivosController extends Controller
{
    public function pdf($serie_correlativo)
    {

        $venta = Ventas::where('serie_correlativo', $serie_correlativo)->firstOrFail();

        return $venta->getPdf();
    }

    public function ticket($serie_correlativo)
    {
    }

    public function xml($serie_correlativo)
    {
        $venta = Ventas::where('serie_correlativo', $serie_correlativo)->firstOrFail();

        return $venta->downloadXml();
    }

    public function cdr($serie_correlativo)
    {
    }


    public function pdf_guia($id, $serie_correlativo)
    {
        $guia = GuiaRemision::where('serie_correlativo', $serie_correlativo)->where('id', $id)->firstOrFail();
        return $guia->getPdf();
    }

    public function xml_guia($serie_correlativo)
    {
        $guia = GuiaRemision::where('serie_correlativo', $serie_correlativo)->firstOrFail();

        return $guia->downloadXml();
    }




    public function pdf_nota($id, $serie_correlativo)
    {
        $comprobante = Comprobantes::where('serie_correlativo', $serie_correlativo)->where('id', $id)->firstOrFail();
        return $comprobante->getPdf();
    }
}
