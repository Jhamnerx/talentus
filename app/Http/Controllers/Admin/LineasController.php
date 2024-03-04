<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LineasExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\LineasRequest;
use App\Models\CambiosLineas;
use App\Models\Lineas;
use App\Models\SimCard;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LineasController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-sim_card', ['only' => ['index', 'disponibles']]);
        $this->middleware('permission:crear-sim_card', ['only' => ['create']]);
        $this->middleware('permission:editar-sim_card', ['only' => ['edit']]);
    }


    public function index()
    {
        return view('admin.almacen.lineas.index');
    }



    public function asign(Request $request)
    {
        return view('admin.almacen.lineas.asign');
    }

    public function exportExcel()
    {
        return Excel::download(new LineasExport, 'lineas.xls');
    }
}
