<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PresupuestosRequest;
use App\Models\plantilla;
use App\Models\Presupuestos;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

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
        $tipoCambio = UtilesController::tipoCambio();
         $serial = $this->setNextSequenceNumber();
        dd($serial);
        return view('admin.ventas.presupuestos.create', compact('tipoCambio', 'last'));
    }

    public function setNextSequenceNumber()
    {
        

        $last = Presupuestos::orderBy('numero', 'desc')
            ->take(1)
            ->first();

        $nextSequenceNumber = ($last) ? $last->numero + 1 : 1;

        return $nextSequenceNumber;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PresupuestosRequest $request)
    {

      //dd($request->divisa);


        $presupuesto = Presupuestos::create([
            'empresa_id' => $request->empresa_id,
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


        $presupuesto->save();

        presupuestos::createItems($presupuesto, $request->items);

        return redirect()->route('admin.ventas.presupuestos.index')->with('store', 'El Presupuesto se creo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function show(Presupuestos $presupuesto)
    {


        $plantilla = plantilla::find(session('empresa'));
        return view('admin.ventas.presupuestos.show', compact('presupuesto', 'plantilla'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Presupuestos $presupuesto)
    {
        $tipoCambio = UtilesController::tipoCambio();


        return view('admin.ventas.presupuestos.edit', compact('presupuesto', 'tipoCambio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function update(PresupuestosRequest $request, Presupuestos $presupuesto)
    {

        //dd($request->all());
        $presupuesto->update($request->all());
        $presupuesto->detalles()->delete();

        presupuestos::createItems($presupuesto, $request->items);

        return redirect()->route('admin.ventas.presupuestos.index')->with('update', 'El Presupuesto se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presupuestos $presupuesto)
    {
        //
    }
}
