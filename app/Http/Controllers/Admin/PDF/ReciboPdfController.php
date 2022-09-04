<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\Recibos;
use Illuminate\Http\Request;

class ReciboPdfController extends Controller
{
    public function __invoke(Recibos $recibo, $action = null)
    {

        return $recibo->getPDFData($action);
        
    }

    public function sendToMail(Recibos $recibo, $data)
    {
       // dd($this)
        return $recibo->getPDFDataToMail($data);
        
    }
}
