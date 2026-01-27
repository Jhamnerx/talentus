<?php

namespace App\Http\Controllers\Admin\Finanzas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-pagos', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.finanzas.pagos.index');
    }
}
