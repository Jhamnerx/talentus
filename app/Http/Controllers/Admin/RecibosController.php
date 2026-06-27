<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recibos;

class RecibosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-recibos', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear-recibos', ['only' => ['create']]);
        $this->middleware('permission:editar-recibos', ['only' => ['edit']]);
    }


    public function index()
    {
        return view('admin.ventas.recibos.index');
    }

    public function create($periodo_ids = null)
    {
        $periodo_ids = $this->parsePeriodoIds($periodo_ids);
        $presupuesto_id = request()->query('presupuesto_id');
        return view('admin.ventas.recibos.create', compact('periodo_ids', 'presupuesto_id'));
    }

    /**
     * Normaliza el parámetro de períodos a un array de enteros.
     * Acepta tanto JSON ("[815]") como lista separada por comas ("815,816").
     *
     * @return array<int, int>
     */
    private function parsePeriodoIds(mixed $raw): array
    {
        if (empty($raw)) {
            return [];
        }

        $values = is_array($raw)
            ? $raw
            : (json_decode((string) $raw, true) ?? explode(',', (string) $raw));

        return collect($values)
            ->map(fn($id) => (int) $id)
            ->filter()
            ->values()
            ->all();
    }


    public function edit(Recibos $recibo)
    {
        return view('admin.ventas.recibos.edit', compact('recibo'));
    }
}
