<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComprasFacturas;
use Illuminate\Http\Request;

class ComprasFacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.compras.facturas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.compras.facturas.create');
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
     * @param  \App\Models\ComprasFacturas  $comprasFacturas
     * @return \Illuminate\Http\Response
     */
    public function show(ComprasFacturas $comprasFacturas)
    {
        return view('admin.compras.facturas.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComprasFacturas  $comprasFacturas
     * @return \Illuminate\Http\Response
     */
    public function edit(ComprasFacturas $comprasFacturas)
    {
        return view('admin.compras.facturas.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComprasFacturas  $comprasFacturas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComprasFacturas $comprasFacturas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComprasFacturas  $comprasFacturas
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComprasFacturas $comprasFacturas)
    {
        //
    }
}
