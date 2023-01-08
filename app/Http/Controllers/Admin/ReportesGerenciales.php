<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportesGerenciales extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin.reportes.index', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.gerencia.reportes.index');
    }
}
