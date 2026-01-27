<?php

namespace App\Http\Controllers\Admin\Finanzas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CajaChicaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-caja-chica', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.finanzas.caja-chica.index');
    }
}
