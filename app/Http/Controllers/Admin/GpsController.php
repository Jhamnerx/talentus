<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DispositivosExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\DispositivosRequest;
use App\Models\Dispositivos;
use App\Models\ModelosDispositivo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.almacen.dispositivos.index');
    }
    public function showModels()
    {
        return view('admin.almacen.dispositivos.modelos-index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $modelos = ModelosDispositivo::pluck('modelo', 'id');

        return view('admin.almacen.dispositivos.create', compact('modelos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DispositivosRequest $request)
    {

        // dd($request->all());
        Dispositivos::create($request->all());
        return redirect()->route('admin.almacen.dispositivos.index')->with('store', 'El dispositivo se guardo con exito');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gps  $gps
     * @return \Illuminate\Http\Response
     */
    public function show(Dispositivos $dispositivo)
    {
        return view('admin.almacen.dispositivos.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gps  $gps
     * @return \Illuminate\Http\Response
     */
    public function edit(Dispositivos $dispositivo)
    {
        $modelos = ModelosDispositivo::pluck('modelo', 'id');
        return view('admin.almacen.dispositivos.edit', compact('dispositivo', 'modelos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gps  $gps
     * @return \Illuminate\Http\Response
     */
    public function update(DispositivosRequest $request, Dispositivos $dispositivo)
    {
        $dispositivo->update($request->all());
        return redirect()->route('admin.almacen.dispositivos.index')->with('update', 'El dispositivo se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gps  $gps
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dispositivos $dispositivo)
    {
        //
    }
    public function exportExcel()
    {
        return Excel::download(new DispositivosExport, 'dispositivos.xls');

        redirect()->route('admin.dispositivos.index');
    }
}
