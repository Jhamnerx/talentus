<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Http\Controllers\Controller;
use App\Models\Actas;
use Illuminate\Http\Request;

class ActaPdfController extends Controller
{
    public function __invoke(Request $request, Actas $acta)
    {
        if ($request->has('preview')) {
            return $acta->getPDFData();
        }

        return $acta->getGeneratedPDFOrStream('acta');
    }
}
