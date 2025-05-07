<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificadosAntifatigaController extends Controller
{
    public function index()
    {
        return view('admin.certificados.antifatiga.index');
    }
}
