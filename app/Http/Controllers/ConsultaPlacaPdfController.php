<?php

namespace App\Http\Controllers;

use App\Models\Actas;
use Illuminate\Http\Request;

class ConsultaPlacaPdfController extends Controller
{
    public function mostrarActaPdf($actaId)
    {
        try {
            $acta = Actas::findOrFail($actaId);

            // Usar el método getPDFData() que ya retorna el PDF renderizado con DomPDF
            return $acta->getPDFData();
        } catch (\Exception $e) {
            abort(404, 'Acta no encontrada');
        }
    }
}
