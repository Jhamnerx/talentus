<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ClientesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientesRequest;
use App\Models\Clientes;
use App\Models\Flotas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ClientesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cliente', ['only' => ['index']]);
        $this->middleware('permission:crear-cliente', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-cliente', ['only' => ['edit', 'update']]);
        $this->middleware('permission:exportar-cliente', ['only' => ['exportExcel']]);
    }

    public function index()
    {
        return view('admin.clientes.index');
    }

    public function create()
    {
        return view('admin.clientes.create');
    }

    public function store(ClientesRequest $request)
    {
        $cliente = Clientes::create($request->all());
        if ($request->flota) {
            Flotas::create([
                'nombre' => $cliente->razon_social,
                'clientes_id' => $cliente->id,
                'empresa_id' => session('empresa'),
            ]);
        }
        return redirect()->route('admin.clientes.index')->with('store', 'El cliente se guardo con exito');
    }

    public function show(Clientes $cliente)
    {
        return view('admin.clientes.show', compact('cliente'));
    }

    public function edit(Clientes $cliente)
    {
        return view('admin.clientes.edit', compact('cliente'));
    }

    public function update(ClientesRequest $request, Clientes $cliente)
    {
        $cliente->update($request->all());
        return redirect()->route('admin.clientes.index')->with('update', 'El cliente se actualizo con exito');
    }

    public function exportExcel()
    {
        return Excel::download(new ClientesExport, 'clientes.xls');
    }
}
