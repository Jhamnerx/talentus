<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\CertificadosVelocimetros;
use Illuminate\Http\Request;

class CertificadoVelocimetroPdfController extends Controller
{
    public function __invoke(CertificadosVelocimetros $certificado)
    {


        return $certificado->getPDFData();
    }
}
