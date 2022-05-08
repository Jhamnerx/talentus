<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificadosGps;
use Illuminate\Http\Request;

class CertificadosGpsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.certificados.gps.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.certificados.gps.create');
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
     * @param  \App\Models\CertificadosGps  $certificado
     * @return \Illuminate\Http\Response
     */
    public function show(CertificadosGps $certificado)
    {
        return view('admin.certificados.gps.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CertificadosGps  $certificado
     * @return \Illuminate\Http\Response
     */
    public function edit(CertificadosGps $certificado)
    {
        return view('admin.certificados.gps.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CertificadosGps  $certificado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CertificadosGps $certificado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CertificadosGps  $certificado
     * @return \Illuminate\Http\Response
     */
    public function destroy(CertificadosGps $certificado)
    {
        //
    }
}
