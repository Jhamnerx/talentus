<?php

namespace App\Http\Controllers\Admin\Finanzas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovimientosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-movimientos', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.finanzas.movimientos.index');
    }
}
