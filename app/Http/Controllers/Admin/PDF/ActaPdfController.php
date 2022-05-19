<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\Actas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ActaPdfController extends Controller
{
    public function __invoke(Actas $acta)
    {


        return $acta->getPDFData();
    }
}
