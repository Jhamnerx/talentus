<?php

namespace App\Exports;

use App\Models\Compras;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class ComprasExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithCustomValueBinder, ShouldAutoSize
{
    use Exportable;

    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $query = Compras::with(['proveedor', 'tipoComprobante', 'detalle', 'payments'])
            ->orderBy('fecha_emision', 'DESC')
            ->orderBy('correlativo', 'DESC');

        // Aplicar filtros
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('proveedor', function ($subQ) use ($search) {
                    $subQ->where('razon_social', 'like', '%' . $search . '%')
                        ->orWhere('numero_documento', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('tipoComprobante', function ($subQ) use ($search) {
                        $subQ->where('descripcion', 'like', '%' . $search . '%');
                    })
                    ->orWhere('serie', 'like', '%' . $search . '%')
                    ->orWhere('correlativo', 'like', '%' . $search . '%')
                    ->orWhere('serie_correlativo', 'like', '%' . $search . '%')
                    ->orWhere('fecha_emision', 'like', '%' . $search . '%')
                    ->orWhere('forma_pago', 'like', '%' . $search . '%')
                    ->orWhere('total', 'like', '%' . $search . '%');
            });
        }

        if (!empty($this->filters['formaPago'])) {
            $query->where('forma_pago', $this->filters['formaPago']);
        }

        // Filtrar por estado de pago
        if (!empty($this->filters['estadoPago'])) {
            if ($this->filters['estadoPago'] === 'pagado') {
                $query->whereHas('payments', function ($q) {
                    // Solo verificar que existan pagos, la suma se hace en el modelo
                })->whereRaw('(SELECT COALESCE(SUM(monto), 0) FROM payments WHERE paymentable_type = ? AND paymentable_id = compras.id) >= compras.total', [Compras::class]);
            } elseif ($this->filters['estadoPago'] === 'pendiente') {
                $query->whereDoesntHave('payments');
            } elseif ($this->filters['estadoPago'] === 'parcial') {
                $query->whereHas('payments')
                    ->whereRaw('(SELECT COALESCE(SUM(monto), 0) FROM payments WHERE paymentable_type = ? AND paymentable_id = compras.id) < compras.total', [Compras::class]);
            }
        }

        $compras = $query->get();

        return view('exports.compras', [
            'compras' => $compras,
        ]);
    }
}
