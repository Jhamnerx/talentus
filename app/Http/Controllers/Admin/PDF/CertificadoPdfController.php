<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\Certificados;
use Illuminate\Http\Request;

class CertificadoPdfController extends Controller
{
    public function __invoke(Certificados $certificado)
    {


        return $certificado->getPDFData();
    }
}
