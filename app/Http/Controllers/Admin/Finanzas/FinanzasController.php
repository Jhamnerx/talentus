<?php

namespace App\Http\Controllers\Admin\Finanzas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinanzasController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:finanzas-caja-chica', ['only' => ['cajaChica']]);
        // $this->middleware('permission:finanzas-movimientos', ['only' => ['movimientos']]);
        // $this->middleware('permission:finanzas-transacciones', ['only' => ['transacciones']]);
        // $this->middleware('permission:finanzas-cuentas-cobrar', ['only' => ['cuentasCobrar']]);
        // $this->middleware('permission:finanzas-cuentas-pagar', ['only' => ['cuentasPagar']]);
        // $this->middleware('permission:finanzas-balance', ['only' => ['balance']]);
    }

    public function cajaChica()
    {
        return view('admin.finanzas.caja-chica.index');
    }

    public function movimientos()
    {
        return view('admin.finanzas.movimientos.index');
    }

    public function transacciones()
    {
        return view('admin.finanzas.transacciones.index');
    }

    public function cuentasCobrar()
    {
        return view('admin.finanzas.cuentas-cobrar.index');
    }

    public function cuentasPagar()
    {
        return view('admin.finanzas.cuentas-pagar.index');
    }

    public function balance()
    {
        return view('admin.finanzas.balance.index');
    }
}
