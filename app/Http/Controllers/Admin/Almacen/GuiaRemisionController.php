<?php

namespace App\Http\Controllers\Admin\Almacen;

use App\Http\Controllers\Controller;
use App\Models\GuiaRemision;
use App\Http\Requests\StoreGuiaRemisionRequest;
use App\Http\Requests\UpdateGuiaRemisionRequest;

class GuiaRemisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreGuiaRemisionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGuiaRemisionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GuiaRemision  $guiaRemision
     * @return \Illuminate\Http\Response
     */
    public function show(GuiaRemision $guiaRemision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GuiaRemision  $guiaRemision
     * @return \Illuminate\Http\Response
     */
    public function edit(GuiaRemision $guiaRemision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGuiaRemisionRequest  $request
     * @param  \App\Models\GuiaRemision  $guiaRemision
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGuiaRemisionRequest $request, GuiaRemision $guiaRemision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GuiaRemision  $guiaRemision
     * @return \Illuminate\Http\Response
     */
    public function destroy(GuiaRemision $guiaRemision)
    {
        //
    }
}
