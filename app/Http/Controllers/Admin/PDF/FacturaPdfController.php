<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\Facturas;
use Illuminate\Http\Request;

class FacturaPdfController extends Controller
{
    public function __invoke(Facturas $factura)
    {

        return $factura->getPDFData();
        
    }
}
