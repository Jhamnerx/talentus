<?php

namespace App\Http\Controllers\Admin\Finanzas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CuentasPagarController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cuentas-pagar', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.finanzas.cuentas-pagar.index');
    }
}
