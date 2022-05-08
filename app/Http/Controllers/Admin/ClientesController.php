<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClientesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientesRequest;
use App\Models\Clientes;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.clientes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientesRequest $request)
    {
        //dd($request);
        Clientes::create($request->all());
        return redirect()->route('admin.clientes.index')->with('store', 'El cliente se guardo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Clientes $clientes)
    {
        return view('admin.clientes.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(ClientesRequest $request, Clientes $cliente)
    {
        //dd($cliente);

        $cliente->update($request->all());
        return redirect()->route('admin.clientes.index')->with('update', 'El cliente se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clientes $clientes)
    {
        //
    }

    public function exportExcel()
    {
        return Excel::download(new ClientesExport, 'clientes.xls');

        redirect()->route('admin.clientes.index');
    }
}
