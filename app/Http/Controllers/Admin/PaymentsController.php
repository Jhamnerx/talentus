<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class PaymentsController extends Controller
{
    function __construct() {}

    public function index()
    {
        return view('admin.payments.index');
    }

    public function metodosPago()
    {
        return view('admin.payments.metodos-pago');
    }

    public function setNextSequenceNumber()
    {
        $id = IdGenerator::generate(['table' => 'payments', 'field' => 'numero', 'length' => 8, 'prefix' => 'PAY-', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true]);
        return trim($id);
    }
}
