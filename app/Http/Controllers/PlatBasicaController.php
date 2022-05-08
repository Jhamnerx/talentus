<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlatBasicaController extends Controller
{
    public function index()
    {
        return view('plataformas.basica');
    }
}
