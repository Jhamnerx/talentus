<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\RecibosPagosVarios;
use Illuminate\Http\Request;

class ReciboPagoPdfController extends Controller
{
    public function __invoke(RecibosPagosVarios $recibo, $action = null)
    {

        return $recibo->getPDFData($action);
    }

    public function sendToMail(RecibosPagosVarios $recibo, $data)
    {
        // dd($this)
        return $recibo->getPDFDataToMail($data);
    }
}
