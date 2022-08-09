<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecibosRequest;
use App\Models\Recibos;
use App\Models\plantilla;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class RecibosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ventas.recibos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $numero = $this->setNextSequenceNumber();
        $plantilla = plantilla::where('empresas_id', session('empresa'))->first();
        return view('admin.ventas.recibos.create', compact('numero', 'plantilla'));
    }

    public function setNextSequenceNumber()
    {

        $id = IdGenerator::generate(['table' => 'recibos','field'=>'numero', 'length' => 5, 'prefix' => ' ']);

        return trim($id);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecibosRequest $request)
    {
        $factura = Recibos::create($request->all());

        Recibos::createItems($factura, $request->items);

        return redirect()->route('admin.ventas.recibos.index')->with('store', 'El Recibo se guardo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recibos  $recibos
     * @return \Illuminate\Http\Response
     */
    public function show(Recibos $recibos)
    {
        return view('admin.ventas.recibos.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recibos  $recibos
     * @return \Illuminate\Http\Response
     */
    public function edit(Recibos $recibo)
    {
        return view('admin.ventas.recibos.edit', compact('recibo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recibos  $recibos
     * @return \Illuminate\Http\Response
     */
    public function update(RecibosRequest $request, Recibos $recibo)
    {
        $recibo->update($request->all());
        $recibo->detalles()->delete();

        Recibos::createItems($recibo, $request->items);

        return redirect()->route('admin.ventas.recibos.index')->with('update', 'El recibo se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recibos  $recibos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recibos $recibos)
    {
        //
    }
}
