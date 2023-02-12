<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Models\Actas;
use App\Models\Ciudades;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class ActaPdfController extends Controller
{
    public function __invoke(Actas $acta)
    {
        $ciudad = Ciudades::find($acta->ciudades_id);
        $acta->fecha =
            $fecha = $ciudad->nombre . ", " . today()->day . " de " . Str::ucfirst(today()->monthName) . " del " . today()->year;
        $acta->save();
        return $acta->getPDFData();
    }
    public function sendToMail(Actas $acta, $data)
    {

        return $acta->getPDFDataToMail($data);
    }
}
