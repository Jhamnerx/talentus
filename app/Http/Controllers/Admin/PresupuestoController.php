<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresupuestosRequest;
use App\Models\plantilla;
use App\Models\Presupuestos;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.ventas.presupuestos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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


    public function store(PresupuestosRequest $request)
    {

        $presupuesto = Presupuestos::create([
            'clientes_id' => $request->clientes_id,
            'numero' => $request->numero,
            'fecha' => $request->fecha,
            'fecha_caducidad' => $request->fecha_caducidad,
            'divisa' => $request->divisa,
            'tipoCambio' => $request->tipoCambio,
            'nota' => $request->nota,
            'subtotal' => $request->subtotal,
            'impuesto' => $request->impuesto,
            'total' => $request->total,
            'subtotalSoles' => $request->divisa == "USD" ? $request->subtotalSoles : NULL,
            'impuestoSoles' => $request->divisa == "USD" ? $request->impuestoSoles : NULL,
            'totalSoles' => $request->divisa == "USD" ? $request->totalSoles : NULL,

        ]);

        Presupuestos::createItems($presupuesto, $request->items);

        return redirect()->route('admin.ventas.presupuestos.index')->with('store', 'El Presupuesto se creo con exito');
    }

    public function show(Presupuestos $presupuesto)
    {

        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();
        return view('admin.ventas.presupuestos.show', compact('presupuesto', 'plantilla'));
    }

    public function edit(Presupuestos $presupuesto)
    {
        $tipoCambio = UtilesController::tipoCambio();

        return view('admin.ventas.presupuestos.edit', compact('presupuesto', 'tipoCambio'));
    }

    public function update(PresupuestosRequest $request, Presupuestos $presupuesto)
    {

        $presupuesto->update($request->all());
        $presupuesto->detalles()->delete();

        presupuestos::createItems($presupuesto, $request->items);

        return redirect()->route('admin.ventas.presupuestos.index')->with('update', 'El Presupuesto se actualizo con exito');
    }


    public function destroy(Presupuestos $presupuesto)
    {
        //
    }
}
