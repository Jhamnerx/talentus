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
        $this->middleware('permission:ver-cliente-360', ['only' => ['show360']]);
    }

    public function index()
    {
        return view('admin.clientes.index');
    }

    public function show360(Clientes $cliente)
    {
        return view('admin.clientes.show360', ['cliente' => $cliente]);
    }


    public function exportExcel()
    {
        return Excel::download(new ClientesExport, 'clientes.xls');
    }
}
