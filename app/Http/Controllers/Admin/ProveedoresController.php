<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProveedoresExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProveedoresRequest;
use App\Models\Proveedores;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.proveedores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProveedoresRequest $request)
    {
        Proveedores::create($request->all());
        return redirect()->route('admin.proveedores.index')->with('store', 'El Proveedor se guardo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function show(Proveedores $proveedores)
    {
        return view('admin.proveedores.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function edit(Proveedores $proveedor)
    {
        return view('admin.proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function update(ProveedoresRequest $request, Proveedores $proveedor)
    {

        $proveedor->update($request->all());
        return redirect()->route('admin.proveedores.index')->with('update', 'El Proveedor se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proveedores  $proveedores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proveedores $proveedores)
    {
        //
    }

    public function exportExcel()
    {
        return Excel::download(new ProveedoresExport, 'proveedores.xls');

        redirect()->route('admin.proveedores.index');
    }
}
