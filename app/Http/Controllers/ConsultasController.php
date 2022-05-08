<?php

namespace App\Http\Controllers;

use App\Models\Actas;
use Illuminate\Http\Request;

class ConsultasController extends Controller
{
    public function consultaActas()
    {
        return view('app.consulta.actas.index');
    }
    public function consultaVehiculos()
    {
        return view('app.consulta.vehiculos.index');
    }
}
