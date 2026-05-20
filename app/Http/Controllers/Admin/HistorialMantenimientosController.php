<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HistorialMantenimientosController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-vehiculos-historial-mantenimientos', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.vehiculos.historial-mantenimientos.index');
    }
}
