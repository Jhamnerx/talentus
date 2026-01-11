<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Models\WorkOrder;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class WorkOrderPdfController extends Controller
{
    public function generate(WorkOrder $workOrder)
    {
        $workOrder->load([
            'tipo',
            'vehiculo.cliente',
            'cliente',
            'tecnico',
            'creador',
            'deviceHistory.dispositivo',
            'deviceHistory.simCard',
            'checklists.template',
            'checklists.photos',
            'photos',
            'signatures',
            'accessories.producto'
        ]);

        $pdf = Pdf::loadView('pdf.workOrder.informe', compact('workOrder'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Orden_Trabajo_' . str_pad($workOrder->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }
}
