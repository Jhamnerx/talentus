<?php

namespace App\Http\Controllers\Admin\Almacen;

use App\Http\Controllers\Controller;
use App\Models\GuiaRemision;
use App\Http\Requests\StoreGuiaRemisionRequest;
use App\Http\Requests\UpdateGuiaRemisionRequest;
use App\Models\MotivosTraslado;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class GuiaRemisionController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-guias', ['only' => ['index']]);
        $this->middleware('permission:crear-guias', ['only' => ['create']]);
        $this->middleware('permission:editar-guias', ['only' => ['edit']]);
        $this->middleware('permission:detalle-guias', ['only' => ['show']]);
    }

    public function index()
    {
        return view('admin.almacen.guias.index');
    }


    public function create()
    {

        return view('admin.almacen.guias.create');
    }


    public function edit(GuiaRemision $guia)
    {
        if ($guia->fe_estado != '0') {

            return redirect()->route('admin.almacen.guias.index')->with('info', 'No se puede editar una guia de remision que ya ha sido aceptada');
        } else {
            return view('admin.almacen.guias.edit', compact('guia'));
        }
    }
}
