<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Endpoint para WireUI Select - Listado de empresas
     * Usado en filtros de cobros y otros módulos
     */
    public function select(Request $request)
    {
        $search = $request->get('search', '');
        $selected = $request->get('selected', []);

        $empresas = Empresa::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('razon_social', 'like', "%{$search}%")
                        ->orWhere('ruc', 'like', "%{$search}%");
                });
            })
            ->when(!empty($selected), function ($query) use ($selected) {
                $query->orWhereIn('id', $selected);
            })
            ->orderBy('razon_social', 'asc')
            ->limit(10)
            ->get(['id', 'razon_social', 'ruc']);

        return response()->json($empresas);
    }
}
