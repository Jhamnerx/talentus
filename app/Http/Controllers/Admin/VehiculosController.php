<?php

namespace App\Http\Controllers\Admin;

use App\Exports\VehiculosExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehiculosRequest;
use App\Models\Vehiculos;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VehiculosController extends Controller
{
    public function index()
    {
        return view('admin.vehiculos.index');
    }


    public function edit(Vehiculos $vehiculo)
    {
        return view('admin.vehiculos.edit', compact('vehiculo'));
    }


    public function update(Request $request, Vehiculos $vehiculo)
    {

        $requestVehiculo = new VehiculosRequest();
        $request->validate($requestVehiculo->rules($request->dispositivos_id, $request->numero, $vehiculo), $requestVehiculo->messages());


        $updates = $vehiculo->update($request->all());

        $changes =  $vehiculo->getChanges();
        if (array_key_exists('numero', $changes)) {
            return redirect()->route('admin.vehiculos.index')->with('updated-numero', $vehiculo->placa);
        } else {
            return redirect()->route('admin.vehiculos.index')->with('update', 'El vehiculo se actualizo con exito');
        }
        //
    }

    public function exportExcel()
    {
        return Excel::download(new VehiculosExport, 'vehiculos.xls');
    }
}
