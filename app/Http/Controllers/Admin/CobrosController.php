<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Cobros;
use Illuminate\Http\Request;

class CobrosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin.cobros.index', ['only' => ['index']]);
        $this->middleware('permission:admin.cobros.create', ['only' => ['create']]);
        $this->middleware('permission:admin.cobros.edit', ['only' => ['edit']]);
    }


    public function index()
    {
        return view('admin.cobros.index');
    }


    public function create()
    {
        return view('admin.cobros.create');
    }


    public function show(Cobros $cobro)
    {
        return view('admin.cobros.show', compact('cobro'));
    }


    public function edit(Cobros $cobro)
    {
        return view('admin.cobros.edit', compact('cobro'));
    }
}
