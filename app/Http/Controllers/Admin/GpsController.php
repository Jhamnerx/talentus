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

    public function index()
    {
        return view('admin.almacen.dispositivos.index');
    }
    public function showModels()
    {
        return view('admin.almacen.dispositivos.modelos-index');
    }

    public function create()
    {

        $modelos = ModelosDispositivo::pluck('modelo', 'id');

        return view('admin.almacen.dispositivos.create', compact('modelos'));
    }

    public function store(DispositivosRequest $request)
    {

        Dispositivos::create($request->all());
        return redirect()->route('admin.almacen.dispositivos.index')->with('store', 'El dispositivo se guardo con exito');;
    }

    public function show(Dispositivos $dispositivo)
    {
        return view('admin.almacen.dispositivos.show');
    }

    public function edit(Dispositivos $dispositivo)
    {
        $modelos = ModelosDispositivo::pluck('modelo', 'id');
        return view('admin.almacen.dispositivos.edit', compact('dispositivo', 'modelos'));
    }

    public function update(DispositivosRequest $request, Dispositivos $dispositivo)
    {
        $dispositivo->update($request->all());
        return redirect()->route('admin.almacen.dispositivos.index')->with('update', 'El dispositivo se actualizo con exito');
    }

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
