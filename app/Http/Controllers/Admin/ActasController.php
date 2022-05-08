<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actas;
use Illuminate\Http\Request;

class ActasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.certificados.actas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.certificados.actas.create');
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
     * @param  \App\Models\Actas  $actas
     * @return \Illuminate\Http\Response
     */
    public function show(Actas $actas)
    {
        return view('admin.vehiculos.actas.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Actas  $actas
     * @return \Illuminate\Http\Response
     */
    public function edit(Actas $actas)
    {
        return view('admin.vehiculos.actas.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Actas  $actas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actas $actas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actas  $actas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actas $actas)
    {
        //
    }
}
