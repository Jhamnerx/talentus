<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recibos;

class RecibosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-recibos', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear-recibos', ['only' => ['create']]);
        $this->middleware('permission:editar-recibos', ['only' => ['edit']]);
    }


    public function index()
    {
        return view('admin.ventas.recibos.index');
    }

    public function create($periodo_ids = null)
    {
        $periodo_ids = $periodo_ids ? json_decode($periodo_ids, true) : [];
        return view('admin.ventas.recibos.create', compact('periodo_ids'));
    }


    public function edit(Recibos $recibo)
    {
        return view('admin.ventas.recibos.edit', compact('recibo'));
    }
}
