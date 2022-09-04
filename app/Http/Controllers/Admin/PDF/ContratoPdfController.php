<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\Contratos;
use Illuminate\Http\Request;

class ContratoPdfController extends Controller
{
    public function __invoke(Contratos $contrato)
    {


        return $contrato->getPDFData();
    }

    public function sendToMail(Contratos $contrato, $data)
    {
       // dd($this)
        return $contrato->getPDFDataToMail($data);
        
    }
}
