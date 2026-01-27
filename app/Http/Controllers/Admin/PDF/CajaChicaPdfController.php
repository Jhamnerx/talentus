<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Models\Cash;
use App\Models\CashDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\CashExport;
use App\Exports\CashProductExport;
use App\Exports\CashPaymentExport;
use Maatwebsite\Excel\Facades\Excel;

class CajaChicaPdfController extends Controller
{
    /**
     * REPORTE 1: PDF A4 - Reporte principal con todos los documentos
     */
    public function reportA4(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        $caja->load(['cashDocuments.getDocumento', 'cashDocuments.getTipoDocumento', 'user']);
        $totales = $caja->calcularTotales();

        $pdf = Pdf::loadView('pdf.caja-chica.report-a4', [
            'caja' => $caja,
            'totales' => $totales,
        ]);

        return $pdf->stream("Reporte_Caja_{$caja->nombre}_{$caja->fecha_apertura}.pdf");
    }

    /**
     * REPORTE 2: PDF Ticket (80mm) - Versión ticket térmica
     */
    public function reportTicket(Cash $caja, $width = '80')
    {
        $this->authorize('ver-caja-chica');

        $caja->load(['cashDocuments.getDocumento', 'user']);
        $totales = $caja->calcularTotales();

        $pdf = Pdf::loadView('pdf.caja-chica.report-ticket', [
            'caja' => $caja,
            'totales' => $totales,
            'width' => $width,
        ])->setPaper([0, 0, ($width == '58' ? 165 : 226), 841], 'portrait');

        return $pdf->stream("Ticket_Caja_{$caja->id}.pdf");
    }

    /**
     * REPORTE 3: PDF Ticket Resumen - Versión resumida sin detalle
     */
    public function reportTicketResumen(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        $caja->load(['user']);
        $totales = $caja->calcularTotales();

        $pdf = Pdf::loadView('pdf.caja-chica.report-ticket-resumen', [
            'caja' => $caja,
            'totales' => $totales,
        ])->setPaper([0, 0, 226, 600], 'portrait');

        return $pdf->stream("Ticket_Resumen_{$caja->id}.pdf");
    }

    /**
     * REPORTE 4: Simple A4 - Versión simplificada
     */
    public function reportSimpleA4(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        $caja->load(['cashDocuments.getDocumento', 'user']);
        $totales = $caja->calcularTotales();

        $pdf = Pdf::loadView('pdf.caja-chica.report-simple-a4', [
            'caja' => $caja,
            'totales' => $totales,
        ]);

        return $pdf->stream("Reporte_Simple_{$caja->nombre}.pdf");
    }

    /**
     * REPORTE 5: Excel - Detalle completo de caja
     */
    public function reportExcel(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        return Excel::download(
            new CashExport($caja),
            "Reporte_Caja_{$caja->nombre}_{$caja->fecha_apertura}.xlsx"
        );
    }

    /**
     * REPORTE 6: Resumen Operaciones Diarias
     */
    public function reportSummaryDailyOperations(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        $caja->load(['cashDocuments.getDocumento', 'user']);
        $totales = $caja->calcularTotales();

        $pdf = Pdf::loadView('pdf.caja-chica.report-daily-operations', [
            'caja' => $caja,
            'totales' => $totales,
        ]);

        return $pdf->stream("Resumen_Operaciones_{$caja->fecha_apertura}.pdf");
    }

    /**
     * REPORTE EFECTIVO 1: Excel - Ingresos en efectivo
     */
    public function reportCashPaymentExcel(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        return Excel::download(
            new CashPaymentExport($caja),
            "Reporte_Efectivo_{$caja->nombre}_{$caja->fecha_apertura}.xlsx"
        );
    }

    /**
     * REPORTE EFECTIVO 2: PDF - Ingresos y Egresos
     */
    public function reportIncomeEgress(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        $caja->load(['cashDocuments.getDocumento', 'user']);
        $totales = $caja->calcularTotales();

        $pdf = Pdf::loadView('pdf.caja-chica.report-income-egress', [
            'caja' => $caja,
            'totales' => $totales,
        ]);

        return $pdf->stream("Ingresos_Egresos_{$caja->fecha_apertura}.pdf");
    }

    /**
     * REPORTE EFECTIVO 3: PDF - Pagos asociados a caja
     */
    public function reportPaymentsAssociated(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        $caja->load(['cashDocumentPayments.payment', 'user']);

        $pdf = Pdf::loadView('pdf.caja-chica.report-payments-associated', [
            'caja' => $caja,
        ]);

        return $pdf->stream("Pagos_Asociados_{$caja->fecha_apertura}.pdf");
    }

    /**
     * REPORTE PRODUCTOS 1: PDF - Punto de venta
     */
    public function reportProductsPdf(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        $productos = $this->getProductsData($caja);

        $pdf = Pdf::loadView('pdf.caja-chica.report-products', [
            'caja' => $caja,
            'productos' => $productos,
            'total_productos' => $productos->sum('total'),
        ]);

        return $pdf->stream("Productos_{$caja->fecha_apertura}.pdf");
    }

    /**
     * REPORTE PRODUCTOS 2: Excel - Punto de venta
     */
    public function reportProductsExcel(Cash $caja)
    {
        $this->authorize('ver-caja-chica');

        return Excel::download(
            new CashProductExport($caja),
            "Productos_{$caja->nombre}_{$caja->fecha_apertura}.xlsx"
        );
    }

    /**
     * REPORTE GENERAL: Consolidado del día
     */
    public function reportGeneral(Request $request)
    {
        $this->authorize('ver-caja-chica');

        $fecha = $request->get('fecha', now()->format('Y-m-d'));

        $cajas = Cash::with(['user', 'cashDocuments'])
            ->whereDate('fecha_apertura', $fecha)
            ->get();

        $totalGeneral = [
            'saldo_inicial' => $cajas->sum('saldo_inicial'),
            'ingresos' => 0,
            'egresos' => 0,
            'saldo_final' => $cajas->sum('saldo_actual'),
            'documentos' => $cajas->sum(fn($c) => $c->cashDocuments->count()),
        ];

        foreach ($cajas as $caja) {
            $totales = $caja->calcularTotales();
            $totalGeneral['ingresos'] += $totales['ingresos'];
            $totalGeneral['egresos'] += $totales['egresos'];
        }

        $pdf = Pdf::loadView('pdf.caja-chica.report-general', [
            'cajas' => $cajas,
            'fecha' => $fecha,
            'totalGeneral' => $totalGeneral,
        ]);

        return $pdf->stream("Reporte_General_{$fecha}.pdf");
    }

    /**
     * Helper: Obtener datos de productos
     */
    private function getProductsData(Cash $caja)
    {
        $productos = collect();

        $caja->load(['cashDocuments.getDocumento.items.producto']);

        foreach ($caja->cashDocuments as $documento) {
            if ($documento->getDocumento && method_exists($documento->getDocumento, 'items')) {
                foreach ($documento->getDocumento->items as $item) {
                    $productos->push([
                        'nombre' => $item->producto->nombre ?? $item->descripcion,
                        'cantidad' => $item->cantidad,
                        'precio' => $item->precio_unitario,
                        'total' => $item->total,
                        'documento' => $documento->serie_numero ?? '-',
                    ]);
                }
            }
        }

        return $productos;
    }
}
