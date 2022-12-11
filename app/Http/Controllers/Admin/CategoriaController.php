<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    function __construct()
    {
        //$this->middleware('permission:ver-categorias | crear-categoria | editar-categoria | eliminar-categoria', ['only' => ['index']]);
        $this->middleware('permission:crear-categoria', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-categoria', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-categoria', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categorias = Categoria::all();
        return view('admin.almacen.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.almacen.categorias.create');
    }
    public function store(CategoriaRequest $request)
    {

        $categoria = Categoria::create($request->all());
        return redirect()->route('admin.almacen.categorias.index')->with('store', 'La categoria se guardo con exito');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.almacen.categorias.edit', compact('categoria'));
    }


    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update($request->all());
        return redirect()->route('admin.almacen.categorias.index')->with('update', 'La categoria se actualizo con exito');
    }
}
