<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresupuestosRequest;
use App\Models\plantilla;
use App\Models\Presupuestos;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class PresupuestoController extends Controller
{
    public function index()
    {

        return view('admin.ventas.presupuestos.index');
    }

    public function create()
    {
        return view('admin.ventas.presupuestos.create');
    }

    public static function setNextSequenceNumber()
    {
        $plantilla = plantilla::first();
        $id = IdGenerator::generate(['table' => 'presupuestos', 'field' => 'numero', 'length' => 8, 'prefix' => $plantilla->series["cotizacion"] . '-', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true]);
        return $id;
    }


    public function show(Presupuestos $presupuesto)
    {
        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();
        return view('admin.ventas.presupuestos.show', compact('presupuesto', 'plantilla'));
    }

    public function edit(Presupuestos $presupuesto)
    {

        return view('admin.ventas.presupuestos.edit', compact('presupuesto'));
    }
}
