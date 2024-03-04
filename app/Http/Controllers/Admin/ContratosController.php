<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contratos;
use App\Models\Vehiculos;
use Illuminate\Http\Request;

class ContratosController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-contrato', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear-contrato', ['only' => ['create']]);
        $this->middleware('permission:editar-contrato', ['only' => ['edit']]);
    }

    public function index()
    {
        return view('admin.ventas.contratos.index');
    }


    public function create()
    {

        return view('admin.ventas.contratos.create');
    }

    public function edit(Contratos $contrato)
    {
        return view('admin.ventas.contratos.edit', compact('contrato'));
    }


    public function update(Request $request, Contratos $contrato)
    {

        $contrato->update($request->all());
        $contrato->vehiculos()->detach();
        $resul = $contrato->vehiculos()->attach($request->items);
        return redirect()->route('admin.ventas.contratos.index')->with('update', 'El Contrato se actualizo con exito');
    }
}
