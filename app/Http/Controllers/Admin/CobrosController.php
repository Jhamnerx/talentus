<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Cobros;
use Illuminate\Http\Request;

class CobrosController extends Controller
{
    function __construct() {}


    public function index()
    {
        return view('admin.cobros.index');
    }


    public function create()
    {
        return view('admin.cobros.create');
    }

    public function edit(Cobros $cobro)
    {
        return view('admin.cobros.edit', compact('cobro'));
    }

    /**
     * Muestra el dashboard de notificaciones de cobro
     */
    public function notificaciones()
    {
        return view('admin.cobros.notificaciones');
    }
}
