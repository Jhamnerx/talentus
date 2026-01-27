<?php

namespace App\Http\Controllers\Admin\Finanzas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransaccionesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-transacciones', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.finanzas.transacciones.index');
    }
}
