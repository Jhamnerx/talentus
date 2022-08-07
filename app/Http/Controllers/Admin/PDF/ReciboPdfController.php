<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\Recibos;
use Illuminate\Http\Request;

class ReciboPdfController extends Controller
{
    public function __invoke(Recibos $recibo)
    {

        return $recibo->getPDFData();
        
    }
}
