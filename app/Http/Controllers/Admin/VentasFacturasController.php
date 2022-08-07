<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacturasRequest;
use App\Models\Facturas;
use App\Models\plantilla;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class VentasFacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ventas.facturas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $numero = $this->setNextSequenceNumber();
        $plantilla = plantilla::where('empresas_id', session('empresa'))->first();

        return view('admin.ventas.facturas.create', compact('numero', 'plantilla'));
    }

    public function setNextSequenceNumber()
    {

        $id = IdGenerator::generate(['table' => 'facturas','field'=>'numero', 'length' => 5, 'prefix' => ' ']);

        return trim($id);
    }


    public function store(FacturasRequest $request)
    {
       //dd($request->all());

        $factura = Facturas::create($request->all());

        Facturas::createItems($factura, $request->items);

        return redirect()->route('admin.ventas.facturas.index')->with('store', 'La Factura se guardo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VentasFacturas  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Facturas $factura)
    {
        return view('admin.ventas.facturas.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VentasFacturas  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Facturas $factura)
    {
        return view('admin.ventas.facturas.edit', compact('factura'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VentasFacturas  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(FacturasRequest $request, Facturas $factura)
    {
        //dd($request->all());
        $factura->update($request->all());
        $factura->detalles()->delete();

        Facturas::createItems($factura, $request->items);

        return redirect()->route('admin.ventas.facturas.index')->with('update', 'La Factura se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VentasFacturas  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facturas $factura)
    {
        //
    }
}
