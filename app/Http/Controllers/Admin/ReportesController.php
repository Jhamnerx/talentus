<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reportes;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function index()
    {
        return view('admin.vehiculos.reportes.index');
    }

    public function show(Reportes $reporte)
    {
        return view('admin.vehiculos.reportes.show', compact('reporte'));
    }
}
