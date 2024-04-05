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
    }

    public function index()
    {
        return view('admin.clientes.index');
    }


    public function exportExcel()
    {
        return Excel::download(new ClientesExport, 'clientes.xls');
    }
}
