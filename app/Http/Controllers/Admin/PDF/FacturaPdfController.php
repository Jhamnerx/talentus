<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\Facturas;
use Illuminate\Http\Request;

class FacturaPdfController extends Controller
{
    public function __invoke(Facturas $factura, $action = null)
    {

        return $factura->getPDFData($action);
        
    }

    public function sendToMail(Facturas $factura, $data)
    {
       // dd($this)
        return $factura->getPDFDataToMail($data);
        
    }
}
