<?php

namespace App\Http\Controllers;

use App\Models\r;
use Illuminate\Http\Request;

class SolicitudesController extends Controller
{

    public function create($solicitud)
    {
        return view('cliente.solicitudes.create', compact('solicitud'));
    }
}
