<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlotasRequest;
use App\Models\Clientes;
use App\Models\Flotas;
use Illuminate\Http\Request;

class FlotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.vehiculos.flotas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vehiculos.flotas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flotas  $flotas
     * @return \Illuminate\Http\Response
     */
    public function show(Flotas $flotas)
    {
        return view('admin.vehiculos.flotas.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flotas  $flotas
     * @return \Illuminate\Http\Response
     */
    public function edit(Flotas $flota)
    {

        $clientes = Clientes::pluck('razon_social', 'id');
        return view('admin.vehiculos.flotas.edit', compact('flota', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flotas  $flotas
     * @return \Illuminate\Http\Response
     */
    public function update(FlotasRequest $request, Flotas $flota)
    {

        $flota->update($request->all());
        return redirect()->route('admin.vehiculos.flotas.index')->with('update', 'La Flota se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flotas  $flotas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flotas $flotas)
    {
        //
    }
}
