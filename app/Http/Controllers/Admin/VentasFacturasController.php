<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VentasFacturas;
use Illuminate\Http\Request;

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
        return view('admin.ventas.facturas.create');
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
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function show(VentasFacturas $ventasFacturas)
    {
        return view('admin.ventas.facturas.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function edit(VentasFacturas $ventasFacturas)
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
    public function update(Request $request, VentasFacturas $ventasFacturas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function destroy(VentasFacturas $ventasFacturas)
    {
        //
    }
}
