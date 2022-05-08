<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ajustes;
use Illuminate\Http\Request;

class AjustesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ajustes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Ajustes  $ajustes
     * @return \Illuminate\Http\Response
     */
    public function show(Ajustes $ajustes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ajustes  $ajustes
     * @return \Illuminate\Http\Response
     */
    public function edit(Ajustes $ajustes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ajustes  $ajustes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ajustes $ajustes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ajustes  $ajustes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ajustes $ajustes)
    {
        //
    }
}
