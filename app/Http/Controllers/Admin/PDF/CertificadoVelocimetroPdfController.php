<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Models\Ciudades;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\CertificadosVelocimetros;

class CertificadoVelocimetroPdfController extends Controller
{
    public function __invoke(CertificadosVelocimetros $certificado)
    {
        $ciudad = Ciudades::find($certificado->ciudades_id);
        $certificado->fecha = $ciudad->nombre . " a los " . today()->day . " del mes de " . Str::ucfirst(today()->monthName) . " del " . today()->year;
        $certificado->save();

        return $certificado->getPDFData();
    }

    public function sendToMail(CertificadosVelocimetros $certificado, $data)
    {

        return $certificado->getPDFDataToMail($data);
    }
}
