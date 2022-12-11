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


    public function show(GuiaRemision $guiaRemision)
    {
        return view('admin.almacen.guias.show');
    }

    public function edit(GuiaRemision $guiaRemision)
    {
        return view('admin.almacen.guias.edit');
    }
}
