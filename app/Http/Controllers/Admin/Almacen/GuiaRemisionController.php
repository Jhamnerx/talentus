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

    public function setNextSequenceNumber()
    {

        $id = IdGenerator::generate(['table' => 'guia_remision', 'field' => 'serie_numero', 'length' => 5, 'prefix' => 'T', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true]);
        return trim($id);
    }
    public function create()
    {

        return view('admin.almacen.guias.create');
    }


    public function show(GuiaRemision $guia)
    {
        return view('admin.almacen.guias.show', compact('guia'));
    }

    public function edit(GuiaRemision $guia)
    {
        return view('admin.almacen.guias.edit', compact('guia'));
    }
}
