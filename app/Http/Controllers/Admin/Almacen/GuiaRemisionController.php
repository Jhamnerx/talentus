<?php

namespace App\Http\Controllers\Admin\Almacen;

use App\Http\Controllers\Controller;
use App\Models\GuiaRemision;
use App\Http\Requests\StoreGuiaRemisionRequest;
use App\Http\Requests\UpdateGuiaRemisionRequest;
use App\Models\MotivosTraslado;

class GuiaRemisionController extends Controller
{

    public function index()
    {
        return view('admin.almacen.guias.index');
    }


    public function create()
    {

        return view('admin.almacen.guias.create');
    }


    public function store(StoreGuiaRemisionRequest $request)
    {
        //
    }

    public function show(GuiaRemision $guiaRemision)
    {
        return view('admin.almacen.guias.show');
    }

    public function edit(GuiaRemision $guiaRemision)
    {
        return view('admin.almacen.guias.edit');
    }


    public function update(UpdateGuiaRemisionRequest $request, GuiaRemision $guiaRemision)
    {
        //
    }


    public function destroy(GuiaRemision $guiaRemision)
    {
        //
    }
}
