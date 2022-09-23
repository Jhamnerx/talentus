<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComprasFacturasRequest;
use App\Models\ComprasFacturas;
use App\Models\plantilla;
use Illuminate\Http\Request;

class ComprasFacturasController extends Controller
{

    public function index()
    {
        return view('admin.compras.facturas.index');
    }


    public function create()
    {
        return view('admin.compras.facturas.create');
    }


    public function store(ComprasFacturasRequest $request)
    {


        $factura = ComprasFacturas::create($request->all());

        ComprasFacturas::createItems($factura, $request->items);

        return redirect()->route('admin.compras.facturas.index');
    }


    public function show(ComprasFacturas $factura)
    {
        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();
        return view('admin.compras.facturas.show', compact('factura', 'plantilla'));
    }

    public function edit(ComprasFacturas $factura)
    {
        return view('admin.compras.facturas.edit', compact('factura'));
    }

    public function update(Request $request, ComprasFacturas $factura)
    {
        $factura->update($request->all());
        $factura->detalles()->delete();

        ComprasFacturas::createItems($factura, $request->items);

        return redirect()->route('admin.compras.facturas.index');
    }
}
