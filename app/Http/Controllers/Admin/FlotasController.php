<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FlotasRequest;
use App\Models\Clientes;
use App\Models\Flotas;
use Illuminate\Http\Request;

class FlotasController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-vehiculos-flotas', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.vehiculos.flotas.index');
    }
}
