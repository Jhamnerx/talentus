<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlotasRequest;
use App\Models\Clientes;
use App\Models\Flotas;
use Illuminate\Http\Request;

class FlotasController extends Controller
{

    public function index()
    {
        return view('admin.vehiculos.flotas.index');
    }
}
