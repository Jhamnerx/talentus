<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ProductosController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:ver-producto', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.almacen.productos.index', ['tipo' => 'producto']);
    }

    public function servicios()
    {
        return view('admin.almacen.servicios.index', ['tipo' => 'servicio']);
    }
}
