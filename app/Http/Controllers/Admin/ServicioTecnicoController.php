<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicioTecnico;
use Illuminate\Http\Request;

class ServicioTecnicoController extends Controller
{

    public function index()
    {
        return view('admin.tecnico.tareas.index');
    }

    public function tipo()
    {
        return view('admin.tecnico.tareas.tipo');
    }

    public function tecnicos()
    {
        return view('admin.tecnico.index');
    }
}
