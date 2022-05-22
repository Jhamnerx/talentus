<?php

namespace App\Http\Controllers;

use App\Models\Actas;
use Illuminate\Http\Request;

class ConsultasController extends Controller
{
    public function consultaActas($unique_hash = null)
    {
        return view('app.consulta.actas.index', compact('unique_hash'));
    }
    public function consultaVehiculos()
    {
        return view('app.consulta.vehiculos.index');
    }
}
