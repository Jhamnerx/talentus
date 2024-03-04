<?php

namespace App\Http\Controllers\Admin\Facturacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComprobantesController extends Controller
{
    public function index()
    {
        return view('admin.comprobantes.index');
    }

    public function emitirFactura()
    {
        return view('admin.comprobantes.factura.create');
    }

    public function emitirBoleta()
    {
        return view('admin.comprobantes.boleta.create');
    }

    public function emitirNotaVenta()
    {
        return view('admin.comprobantes.nota-venta.create');
    }

    public function emitirNotaCredito()
    {
        return view('admin.comprobantes.nota-credito.create');
    }

    public function emitirNotaDebito()
    {
        return view('admin.comprobantes.nota-debito.create');
    }
}
