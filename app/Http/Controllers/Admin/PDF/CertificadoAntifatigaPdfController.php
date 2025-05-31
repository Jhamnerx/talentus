<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Models\CertificadosAntifatiga;
use App\Models\plantilla;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadoAntifatigaPdfController extends Controller
{
    public function __invoke(CertificadosAntifatiga $certificado, $vehiculo)
    {
        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;

        view()->share([
            'certificado' => $certificado,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,
        ]);

        $pdf = PDF::loadView('pdf.certificado-antifatiga');

        return $pdf->stream('CERTIFICADO ANTIFATIGA-' . $certificado->vehiculo->placa . '.pdf');
    }
}
