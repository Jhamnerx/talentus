<?php

namespace App\Http\Controllers\Admin;

use App\Models\Compras;
use App\Models\plantilla;
use Illuminate\Http\Request;
use App\Models\ComprasFacturas;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComprasFacturasRequest;

class ComprasController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-compras_facturas', ['only' => ['index']]);
        $this->middleware('permission:crear-compras_facturas', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-compras_facturas', ['only' => ['edit', 'update']]);
    }

    public function index()
    {
        return view('admin.compras.index');
    }

    public function create()
    {
        return view('admin.compras.create');
    }
    public function editar($id)
    {
        $compra = Compras::findOrFail($id);
        return view('admin.compras.edit', compact('compra'));
    }
}
