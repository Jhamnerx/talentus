<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DispositivosExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\DispositivosRequest;
use App\Models\Dispositivos;
use App\Models\ModelosDispositivo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GpsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-dispositivo', ['only' => ['index']]);
        $this->middleware('permission:crear-dispositivo', ['only' => ['create']]);
        $this->middleware('permission:editar-dispositivo', ['only' => ['edit']]);
        $this->middleware('permission:ver.modelos-dispositivo', ['only' => ['showModels']]);
        $this->middleware('permission:exportar-dispositivo', ['only' => ['exportExcel']]);
    }

    public function index()
    {
        return view('admin.almacen.dispositivos.index');
    }
    public function showModels()
    {
        return view('admin.almacen.dispositivos.modelos-index');
    }

    public function exportExcel()
    {
        return Excel::download(new DispositivosExport, 'dispositivos.xls');

        redirect()->route('admin.dispositivos.index');
    }
}
