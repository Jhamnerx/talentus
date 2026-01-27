<?php

namespace App\Http\Controllers\Admin\Finanzas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-balance', ['only' => ['index']]);
    }

    public function index()
    {
        return view('admin.finanzas.balance.index');
    }
}
