<?php

namespace App\Http\Controllers\Admin\Finanzas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IngresosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-ingresos', ['only' => ['index']]);
        $this->middleware('permission:crear-ingresos', ['only' => ['create']]);
    }

    public function index()
    {
        return view('admin.finanzas.ingresos.index');
    }
}
