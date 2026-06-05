<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CobrosController extends Controller
{
    function __construct() {}


    public function index()
    {
        return view('admin.cobros.index');
    }

    public function proyeccion()
    {
        return view('admin.cobros.proyeccion');
    }
}
