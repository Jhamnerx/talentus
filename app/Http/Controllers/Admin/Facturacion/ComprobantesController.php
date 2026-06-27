<?php

namespace App\Http\Controllers\Admin\Facturacion;

use App\Http\Controllers\Controller;

class ComprobantesController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-comprobantes', ['only' => ['index']]);
        $this->middleware('permission:comprobantes-emitir-factura', ['only' => ['emitirFactura']]);
        $this->middleware('permission:comprobantes-emitir-boleta', ['only' => ['emitirBoleta']]);
        $this->middleware('permission:comprobantes-emitir-nota-venta', ['only' => ['emitirNotaVenta']]);
        $this->middleware('permission:comprobantes-emitir-nota-credito', ['only' => ['emitirNotaCredito']]);
        $this->middleware('permission:comprobantes-emitir-nota-debito', ['only' => ['emitirNotaDebito']]);
    }


    public function index()
    {
        return view('admin.comprobantes.index');
    }
    public function notas()
    {
        return view('admin.comprobantes.notas-index');
    }

    public function emitirFactura($periodo_ids = null)
    {
        $periodo_ids = $this->parsePeriodoIds($periodo_ids);
        $presupuesto_id = request()->query('presupuesto_id');
        return view('admin.comprobantes.factura.create', compact('periodo_ids', 'presupuesto_id'));
    }

    public function emitirBoleta($periodo_ids = null)
    {
        $periodo_ids = $this->parsePeriodoIds($periodo_ids);
        $presupuesto_id = request()->query('presupuesto_id');
        return view('admin.comprobantes.boleta.create', compact('periodo_ids', 'presupuesto_id'));
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

    public function emitirNotaVenta()
    {
        return view('admin.comprobantes.nota-venta.create');
    }

    public function emitirNotaCredito()
    {
        return view('admin.comprobantes.nota-credito.create');
    }

    public function emitirNotaDebito()
    {
        return view('admin.comprobantes.nota-debito.create');
    }
}
