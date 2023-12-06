<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lineas;
use App\Models\SimCard;
use Illuminate\Http\Request;
use App\Exports\LineasExport;
use App\Models\CambiosLineas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SimCardController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-sim_card', ['only' => ['index', 'disponibles']]);
        $this->middleware('permission:crear-sim_card', ['only' => ['create']]);
        $this->middleware('permission:editar-sim_card', ['only' => ['edit']]);
    }


    public function index()
    {
        return view('admin.almacen.sim-card.index');
    }

    // public function exportExcel()
    // {
    //     return Excel::download(new LineasExport, 'sim_cards.xls');
    // }

    public function asign(Request $request)
    {
        return view('admin.almacen.sim-card.asign');
    }
}
