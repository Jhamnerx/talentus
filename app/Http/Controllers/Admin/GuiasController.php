<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guias;
use Illuminate\Http\Request;

class GuiasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.almacen.guias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.almacen.guias.create');
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
     * @param  \App\Models\Guias  $guias
     * @return \Illuminate\Http\Response
     */
    public function show(Guias $guias)
    {
        return view('admin.almacen.guias.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guias  $guias
     * @return \Illuminate\Http\Response
     */
    public function edit(Guias $guias)
    {
        return view('admin.almacen.guias.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guias  $guias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guias $guias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guias  $guias
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guias $guias)
    {
        //
    }
}
