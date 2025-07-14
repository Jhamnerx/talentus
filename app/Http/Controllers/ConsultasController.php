<?php

namespace App\Http\Controllers;

use App\Models\Actas;
use Illuminate\Http\Request;

class ConsultasController extends Controller
{
    public function consultaActas($codigo = null)
    {
        return view('app.consulta.actas.index', compact('codigo'));
    }
    public function consultaCertificado($codigo = null)
    {
        return view('app.consulta.certificados.gps', compact('codigo'));
    }
    public function consultaCertificadoVelocimetro($codigo = null)
    {
        return view('app.consulta.certificados.velocimetro', compact('codigo'));
    }
    public function consultaVehiculos()
    {
        return view('app.consulta.vehiculos.index');
    }

    public function transmision()
    {
        return view('app.consulta.transmision.index');
    }
}
