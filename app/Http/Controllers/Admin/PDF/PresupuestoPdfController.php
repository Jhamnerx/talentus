<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\Presupuestos;
use Illuminate\Http\Request;

class PresupuestoPdfController extends Controller
{
    public function __invoke(Presupuestos $presupuesto, $action = null)
    {

        return $presupuesto->getPDFData($action);
        
    }
    public function sendToMail(Presupuestos $presupuesto, $data)
    {
       // dd($this)
        return $presupuesto->getPDFDataToMail($data);
        
    }
}
