<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacturasRequest;
use App\Models\Facturas;
use App\Models\plantilla;
use Illuminate\Http\Request;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class VentasFacturasController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-ventas-facturas', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear-ventas-facturas', ['only' => ['create']]);
        $this->middleware('permission:editar-ventas-facturas', ['only' => ['edit']]);
    }


    public function index()
    {
        return view('admin.ventas.facturas.index');
    }

    public function create()
    {
        $numero = $this->setNextSequenceNumber();

        return view('admin.ventas.facturas.create', compact('numero'));
    }

    public static function setNextSequenceNumber()
    {

        $plantilla = plantilla::first();
        $id = IdGenerator::generate(['table' => 'facturas', 'field' => 'serie_numero', 'length' => 9, 'prefix' => $plantilla->series["factura"] . '-', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true, 'show_prefix' => false]);
        return $id;
    }

    public function show(Facturas $factura)
    {
        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();
        return view('admin.ventas.facturas.show', compact('factura', 'plantilla'));
    }

    public function edit(Facturas $factura)
    {

        return view('admin.ventas.facturas.edit', compact('factura'));
    }

    public function update(FacturasRequest $request, Facturas $factura)
    {
        $factura->update($request->all());
        $factura->detalles()->delete();

        Facturas::createItems($factura, $request->items);

        return redirect()->route('admin.ventas.facturas.index')->with('update', 'La Factura se actualizo con exito');
    }
}
