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
}
