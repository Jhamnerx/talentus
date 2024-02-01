<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresupuestosRequest;
use App\Models\plantilla;
use App\Models\Presupuestos;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class PresupuestoController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cotizaciones', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear-cotizaciones', ['only' => ['create']]);
        $this->middleware('permission:editar-cotizaciones', ['only' => ['edit']]);
    }

    public function index()
    {

        return view('admin.ventas.presupuestos.index');
    }

    public function create()
    {
        return view('admin.ventas.presupuestos.create');
    }

    public function edit(Presupuestos $presupuesto)
    {

        return view('admin.ventas.presupuestos.edit', compact('presupuesto'));
    }
}
