<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicioTecnico;
use Illuminate\Http\Request;

class ServicioTecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.servicio-tecnico.index');
    }
    public function pendientes()
    {
        return view('admin.servicio-tecnico.tareas-pendientes');
    }
    public function completadas()
    {
        return view('admin.servicio-tecnico.tareas-completadas');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.servicio-tecnico.create');
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
     * @param  \App\Models\ServicioTecnico  $servicioTecnico
     * @return \Illuminate\Http\Response
     */
    public function show(ServicioTecnico $servicioTecnico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ServicioTecnico  $servicioTecnico
     * @return \Illuminate\Http\Response
     */
    public function edit(ServicioTecnico $servicioTecnico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ServicioTecnico  $servicioTecnico
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ServicioTecnico $servicioTecnico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ServicioTecnico  $servicioTecnico
     * @return \Illuminate\Http\Response
     */
    public function destroy(ServicioTecnico $servicioTecnico)
    {
        //
    }
}
