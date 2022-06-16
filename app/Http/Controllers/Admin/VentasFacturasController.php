<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $plantilla = plantilla::where('empresas_id', session('empresa'))->first();;

        return view('admin.ventas.facturas.create', compact('numero', 'plantilla'));
    }

    public function setNextSequenceNumber()
    {

        $id = IdGenerator::generate(['table' => 'facturas','field'=>'numero', 'length' => 5, 'prefix' => ' ']);

        return trim($id);
    }


    public function store(Request $request)
    {
       // dd($request->all());
        $factura = Facturas::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function show(Facturas $ventasFacturas)
    {
        return view('admin.ventas.facturas.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function edit(Facturas $ventasFacturas)
    {
        return view('admin.ventas.facturas.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facturas $ventasFacturas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facturas $ventasFacturas)
    {
        //
    }
}
