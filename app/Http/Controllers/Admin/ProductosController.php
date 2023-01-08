<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductosRequest;
use App\Models\Categoria;
use App\Models\Productos;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductosController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:crear-producto', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-producto', ['only' => ['edit', 'update']]);
        $this->middleware('permission:ver-producto', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.almacen.productos.index');
    }

    public function create()
    {
        $categorias = Categoria::active(true)->pluck('nombre', 'id');
        $units = Unit::pluck('name', 'codigo');
        return view('admin.almacen.productos.create', compact('categorias', 'units'));
    }

    public function store(ProductosRequest $request)
    {

        $producto = Productos::create($request->all());

        if ($request->file('file')) {

            $url = Storage::put('productos', $request->file('file'));

            $producto->image()->create([
                'url' => $url
            ]);
        };

        return redirect()->route('admin.almacen.productos.index')->with('store', 'El producto se guardo con exito');;
    }


    public function edit(Productos $producto)
    {
        $categorias = Categoria::active(true)->pluck('nombre', 'id');
        $units = Unit::pluck('name', 'codigo');
        return view('admin.almacen.productos.edit', compact('producto', 'categorias', 'units'));
    }


    public function update(Request $request, Productos $producto)
    {
        $producto->update($request->all());
        return redirect()->route('admin.almacen.productos.index')->with('update', 'el producto se actualizo con exito');
    }
}
