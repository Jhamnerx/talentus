<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facturas;
use App\Models\plantilla;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class VentasFacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.ventas.facturas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $numero = $this->setNextSequenceNumber();

        $plantilla = plantilla::find(session('empresa'));
        return view('admin.ventas.facturas.create', compact('numero', 'plantilla'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function setNextSequenceNumber()
    {
        
      // $last = Facturas::orderBy('sequence_number', 'desc')
     //        ->take(1)
     //        ->first();

        //var_dump($last->sequence_number);
        //  $last = IdGenerator::generate(['table' => 'presupuestos', 'length' => 8,'field' => 'numero', 'prefix' =>'PRE-']);
        $id = IdGenerator::generate(['table' => 'presupuestos','field'=>'numero', 'length' => 5, 'prefix' => ' ']);

        //$nextSequenceNumber = ($last) ? $last->sequence_number + 1 : 1;
        return trim($id);
    }
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function show(Facturas $ventasFacturas)
    {
        return view('admin.ventas.facturas.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function edit(Facturas $ventasFacturas)
    {
        return view('admin.ventas.facturas.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Facturas $ventasFacturas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\VentasFacturas  $ventasFacturas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Facturas $ventasFacturas)
    {
        //
    }
}
