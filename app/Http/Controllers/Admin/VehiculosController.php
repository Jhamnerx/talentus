<?php

namespace App\Http\Controllers\Admin;

use App\Models\Vehiculos;
use App\Models\Dispositivos;
use Illuminate\Http\Request;
use App\Exports\VehiculosExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\VehiculosRequest;

class VehiculosController extends Controller
{
    public function index()
    {
        return view('admin.vehiculos.index');
    }
    public function show(Vehiculos $vehiculo)
    {
        return view('admin.vehiculos.show', compact('vehiculo'));
    }


    public function edit(Vehiculos $vehiculo)
    {
        return view('admin.vehiculos.edit', compact('vehiculo'));
    }


    public function update(Request $request, Vehiculos $vehiculo)
    {

        $requestVehiculo = new VehiculosRequest();
        $request->validate($requestVehiculo->rules($request->dispositivos_id, $request->numero, $vehiculo), $requestVehiculo->messages());

        $this->setDispositivoVendido($request->dispositivo_imei);

        $updates = $vehiculo->update($request->all());

        $changes =  $vehiculo->getChanges();
        if (array_key_exists('numero', $changes)) {
            return redirect()->route('admin.vehiculos.index')->with('updated-numero', $vehiculo->placa);
        } else {
            return redirect()->route('admin.vehiculos.index')->with('update', 'El vehiculo se actualizo con exito');
        }
        //
    }

    public function setDispositivoVendido($imei)
    {

        $dispositivo = Dispositivos::where('imei', $imei)->firstOrFail();
        if ($dispositivo && $dispositivo != "VENDIDO") {
            $dispositivo->estado = "VENDIDO";
            $dispositivo->save();
        }
    }

    public function exportExcel()
    {
        return Excel::download(new VehiculosExport, 'vehiculos.xls');
    }
}
