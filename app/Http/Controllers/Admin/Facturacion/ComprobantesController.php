<?php

namespace App\Http\Controllers\Admin\Facturacion;

use App\Http\Controllers\Controller;

class ComprobantesController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-comprobantes', ['only' => ['index']]);
        $this->middleware('permission:comprobantes-emitir-factura', ['only' => ['emitirFactura']]);
        $this->middleware('permission:comprobantes-emitir-boleta', ['only' => ['emitirBoleta']]);
        $this->middleware('permission:comprobantes-emitir-nota-venta', ['only' => ['emitirNotaVenta']]);
        $this->middleware('permission:comprobantes-emitir-nota-credito', ['only' => ['emitirNotaCredito']]);
        $this->middleware('permission:comprobantes-emitir-nota-debito', ['only' => ['emitirNotaDebito']]);
    }


    public function index()
    {
        return view('admin.comprobantes.index');
    }
    public function notas()
    {
        return view('admin.comprobantes.notas-index');
    }

    public function emitirFactura($periodo_ids = null)
    {
        $periodo_ids = $periodo_ids ? json_decode($periodo_ids, true) : [];
        $presupuesto_id = request()->query('presupuesto_id');
        return view('admin.comprobantes.factura.create', compact('periodo_ids', 'presupuesto_id'));
    }

    public function emitirBoleta($periodo_ids = null)
    {
        $periodo_ids = $periodo_ids ? json_decode($periodo_ids, true) : [];
        $presupuesto_id = request()->query('presupuesto_id');
        return view('admin.comprobantes.boleta.create', compact('periodo_ids', 'presupuesto_id'));
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
