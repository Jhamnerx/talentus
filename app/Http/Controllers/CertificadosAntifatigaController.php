<?php

namespace App\Http\Controllers;

use App\Models\CertificadosAntifatiga;
use App\Models\Plantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadosAntifatigaController extends Controller
{
    public function index()
    {
        return view('admin.certificados.antifatiga.index');
    }

    public function pdf(CertificadosAntifatiga $certificado)
    {
        $plantilla = Plantilla::where('empresa_id', session('empresa'))->first();
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
