<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Models\Ciudades;
use App\Models\Certificados;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class CertificadoPdfController extends Controller
{
    public function __invoke(Certificados $certificado)
    {
        $ciudad = Ciudades::find($certificado->ciudades_id);
        $certificado->fecha =
            $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;
        $certificado->save();
        return $certificado->getPDFData();
    }

    public function sendToMail(Certificados $certificado, $data)
    {

        return $certificado->getPDFDataToMail($data);
    }
}
