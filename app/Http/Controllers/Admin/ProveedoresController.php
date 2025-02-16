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

    function __construct()
    {
        $this->middleware('permission:ver-proveedor', ['only' => ['index']]);
        $this->middleware('permission:crear-proveedor', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-proveedor', ['only' => ['edit', 'update']]);
        $this->middleware('permission:exportar-proveedor', ['only' => ['exportExcel']]);
    }

    public function index()
    {
        return view('admin.proveedores.index');
    }

    public function exportExcel()
    {
        return Excel::download(new ProveedoresExport, 'proveedores.xls');

        redirect()->route('admin.proveedores.index');
    }
}
