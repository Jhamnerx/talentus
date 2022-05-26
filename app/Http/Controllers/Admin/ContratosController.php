<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContratosRequest;
use App\Models\Contratos;
use App\Models\Vehiculos;
use Illuminate\Http\Request;

class ContratosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ventas.contratos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehiculos = Vehiculos::all();
        return view('admin.ventas.contratos.create', compact('vehiculos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContratosRequest $request)
    {
        //dd($request->all());
        $contrato = Contratos::create($request->all());

        Contratos::createItems($contrato, $request->items);

        return redirect()->route('admin.ventas.contratos.index')->with('store', 'El Contrato se creo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contratos  $contratos
     * @return \Illuminate\Http\Response
     */
    public function show(Contratos $contratos)
    {
        return view('admin.ventas.contratos.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contratos  $contratos
     * @return \Illuminate\Http\Response
     */
    public function edit(Contratos $contrato)
    {
        return view('admin.ventas.contratos.edit', compact('contrato'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contratos  $contratos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contratos $contrato)
    {
        dd($request->all());
        $contrato->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contratos  $contratos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contratos $contratos)
    {
        //
    }
}
