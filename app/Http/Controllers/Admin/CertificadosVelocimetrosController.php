<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificadosVelocimentros;
use App\Models\CertificadosVelocimetros;
use Illuminate\Http\Request;

class CertificadosVelocimetrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.certificados.velocimetros.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('admin.certificados.velocimetros.create');
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
     * @param  \App\Models\CertificadosVelocimentros  $certificado
     * @return \Illuminate\Http\Response
     */
    public function show(CertificadosVelocimetros $certificado)
    {
        return view('admin.certificados.velocimetros.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CertificadosVelocimentros  $certificado
     * @return \Illuminate\Http\Response
     */
    public function edit(CertificadosVelocimetros $certificado)
    {
        //return view('admin.certificados.velocimetros.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CertificadosVelocimentros  $certificado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CertificadosVelocimetros $certificado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CertificadosVelocimentros  $certificado
     * @return \Illuminate\Http\Response
     */
    public function destroy(CertificadosVelocimetros $certificado)
    {
        $certificado->delete();
        return redirect()->route('admin.certificados.velocimetros.index')->with('eliminar', 'El Certificado se elimino con exito');
    }
}
