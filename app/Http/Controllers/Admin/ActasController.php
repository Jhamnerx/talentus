<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actas;
use App\Models\Ciudades;
use Illuminate\Http\Request;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class ActasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ciudades = Ciudades::active(true)->get();
        return view('admin.certificados.actas.index', compact('ciudades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.certificados.actas.create');
    }
    public function setNextSequenceNumber()
    {

        $id = IdGenerator::generate(['table' => 'actas', 'field' => 'numero', 'length' => 5, 'prefix' => ' ']);

        return trim($id);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Actas  $actas
     * @return \Illuminate\Http\Response
     */
    public function show(Actas $actas)
    {
        return view('admin.certificados.actas.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Actas  $actas
     * @return \Illuminate\Http\Response
     */
    public function edit(Actas $actas)
    {
        return view('admin.certificados.actas.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Actas  $actas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Actas $actas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Actas  $actas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Actas $acta)
    {
        $acta->delete();
        return redirect()->route('admin.certificados.actas.index')->with('eliminar', 'El Acta se elimino con exito');
    }
}
