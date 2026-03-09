<?php

namespace App\Livewire\Admin\Compras;

use App\Models\Compras;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ComprasFacturas;
use App\Exports\ComprasExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $estadoPago = ''; // todos, pagado, pendiente, parcial
    public $formaPago = ''; // todos, CONTADO, CREDITO

    public function render()
    {
        $query = Compras::with(['proveedor', 'tipoComprobante', 'payments'])
            ->when($this->search, function ($query) {
                $query->whereHas('proveedor', function ($q) {
                    $q->where('razon_social', 'like', '%' . $this->search . '%')
                        ->orWhere('numero_documento', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('tipoComprobante', function ($q) {
                        $q->where('descripcion', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('serie', 'like', '%' . $this->search . '%')
                    ->orWhere('correlativo', 'like', '%' . $this->search . '%')
                    ->orWhere('serie_correlativo', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha_emision', 'like', '%' . $this->search . '%')
                    ->orWhere('forma_pago', 'like', '%' . $this->search . '%')
                    ->orWhere('total', 'like', '%' . $this->search . '%');
            })
            ->when($this->formaPago, function ($query) {
                $query->where('forma_pago', $this->formaPago);
            });

        // Filtrar por estado de pago
        if ($this->estadoPago === 'pagado') {
            $query->whereHas('payments', function ($q) {
                // Solo verificar que existan pagos, la suma se hace en el modelo
            })->whereRaw('(SELECT COALESCE(SUM(monto), 0) FROM payments WHERE paymentable_type = ? AND paymentable_id = compras.id) >= compras.total', [Compras::class]);
        } elseif ($this->estadoPago === 'pendiente') {
            $query->whereDoesntHave('payments');
        } elseif ($this->estadoPago === 'parcial') {
            $query->whereHas('payments')
                ->whereRaw('(SELECT COALESCE(SUM(monto), 0) FROM payments WHERE paymentable_type = ? AND paymentable_id = compras.id) < compras.total', [Compras::class]);
        }

        $compras = $query->orderBy('fecha_emision', 'DESC')
            ->orderBy('correlativo', 'DESC')
            ->paginate(12);

        return view('livewire.admin.compras.index', compact('compras'));
    }

    /**
     * Verificar si la fecha de vencimiento está vencida
     */
    public function isFechaVencida($fecha_vencimiento)
    {
        if (!$fecha_vencimiento) {
            return false;
        }
        return now()->greaterThan($fecha_vencimiento);
    }

    /**
     * Abrir modal de gestión de pagos
     */
    public function verPagos($compraId)
    {
        $this->dispatch('open-modal-payments', compraId: $compraId);
    }

    #[On('update-table')]
    public function updateIndex()
    {
        $this->render();
    }

    public function openModalDelete(Compras $compra)
    {
        $this->dispatch('open-modal-delete', compra: $compra);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFormaPago()
    {
        $this->resetPage();
    }

    public function updatedEstadoPago()
    {
        $this->resetPage();
    }

    public function anularCompra(Compras $compra)
    {
        if ($compra->estado === 'ANULADO') {
            $this->dispatch(
                'notify-toast',
                icon: 'warning',
                title: 'COMPRA YA ANULADA',
                mensaje: 'Esta compra ya ha sido anulada anteriormente'
            );
            return;
        }

        foreach ($compra->detalle as $detalleItem) {
            if ($detalleItem->producto->stock < $detalleItem->cantidad) {
                $this->dispatch(
                    'notify-toast',
                    icon: 'error',
                    title: 'STOCK INSUFICIENTE',
                    mensaje: 'No hay suficiente stock para el producto: ' . $detalleItem->producto->nombre
                );
                return;
            }
        }

        foreach ($compra->detalle as $detalleItem) {
            $detalleItem->producto->decrement('stock', $detalleItem->cantidad);
        }

        $compra->update(['estado' => 'ANULADO']);

        $this->dispatch(
            'notify-toast',
            icon: 'error',
            title: 'COMPRA ANULADA',
            mensaje: 'Se anuló correctamente la compra'
        );
    }

    /**
     * Exportar a Excel
     */
    public function exportExcel()
    {
        $filters = [
            'search' => $this->search,
            'formaPago' => $this->formaPago,
            'estadoPago' => $this->estadoPago,
        ];

        $fileName = 'compras_' . now()->format('Y-m-d_His') . '.xlsx';

        return Excel::download(new ComprasExport($filters), $fileName);
    }

    /**
     * Exportar a PDF
     */
    public function exportPdf()
    {
        $filters = [
            'search' => $this->search,
            'formaPago' => $this->formaPago,
            'estadoPago' => $this->estadoPago,
        ];

        $query = Compras::with(['proveedor', 'tipoComprobante', 'detalle', 'payments'])
            ->orderBy('fecha_emision', 'DESC')
            ->orderBy('correlativo', 'DESC');

        // Aplicar filtros (mismo código que en render())
        if ($this->search) {
            $search = $this->search;
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

        if ($this->formaPago) {
            $query->where('forma_pago', $this->formaPago);
        }

        // Filtrar por estado de pago
        if ($this->estadoPago === 'pagado') {
            $query->whereHas('payments', function ($q) {
                // Solo verificar que existan pagos, la suma se hace en el modelo
            })->whereRaw('(SELECT COALESCE(SUM(monto), 0) FROM payments WHERE paymentable_type = ? AND paymentable_id = compras.id) >= compras.total', [Compras::class]);
        } elseif ($this->estadoPago === 'pendiente') {
            $query->whereDoesntHave('payments');
        } elseif ($this->estadoPago === 'parcial') {
            $query->whereHas('payments')
                ->whereRaw('(SELECT COALESCE(SUM(monto), 0) FROM payments WHERE paymentable_type = ? AND paymentable_id = compras.id) < compras.total', [Compras::class]);
        }

        $compras = $query->get();

        $pdf = Pdf::loadView('admin.pdf.compras-listado', [
            'compras' => $compras,
            'filters' => $filters,
        ]);

        $pdf->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'compras_' . now()->format('Y-m-d_His') . '.pdf');
    }
}
