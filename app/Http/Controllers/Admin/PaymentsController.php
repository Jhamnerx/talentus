<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use Illuminate\Http\Request;
use jhamnerx\LaravelIdGenerator\IdGenerator;

class PaymentsController extends Controller
{

    public function index()
    {
        return view('admin.payments.index');
    }


    public function setNextSequenceNumber()
    {
        $id = IdGenerator::generate(['table' => 'payments', 'field' => 'numero', 'length' => 8, 'prefix' => 'PAY-', 'where' => ['empresa_id' => session('empresa')], 'reset_on_prefix_change' => true]);
        return trim($id);
    }
}
