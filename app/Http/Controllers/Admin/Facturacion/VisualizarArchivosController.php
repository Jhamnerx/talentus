<?php

namespace App\Http\Controllers\Facturacion;

use App\Http\Controllers\Controller;
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
    }

    public function cdr($serie_correlativo)
    {
    }
}
