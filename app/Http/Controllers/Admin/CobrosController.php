<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cobros;
use Illuminate\Http\Request;

class CobrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cobros.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cobros.create');
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
     * @param  \App\Models\Cobros  $cobros
     * @return \Illuminate\Http\Response
     */
    public function show(Cobros $cobros)
    {
         return view('admin.cobros.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cobros  $cobros
     * @return \Illuminate\Http\Response
     */
    public function edit(Cobros $cobros)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cobros  $cobros
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cobros $cobros)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cobros  $cobros
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cobros $cobros)
    {
        //
    }
}
