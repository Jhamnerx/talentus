<?php

namespace App\Http\Controllers\Admin\PDF;

use App\Models\WorkOrder;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use setasign\Fpdi\Fpdi;

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
            'mantenimiento',
            'deviceHistory.dispositivo',
            'deviceHistory.simCard',
            'checklists.template',
            'checklists.photos',
            'photos',
            'signatures',
            'accessories.producto'
        ]);

        $tieneDetalle = $workOrder->checklists->count() > 0
            || $workOrder->deviceHistory->count() > 0
            || $workOrder->accessories->count() > 0
            || $workOrder->signatures->count() > 0
            || $workOrder->observaciones_inicial
            || $workOrder->observaciones_tecnico
            || $workOrder->observaciones_final;

        // PDF 1: portada con imagen de fondo
        $pdf1 = Pdf::loadView('pdf.workOrder.informe', compact('workOrder'))
            ->setPaper('a4', 'portrait');
        $pdf1Content = $pdf1->output();

        // Si no hay contenido de detalle, devolver solo la portada
        if (! $tieneDetalle) {
            return response($pdf1Content, 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Orden_Trabajo_' . str_pad($workOrder->id, 5, '0', STR_PAD_LEFT) . '.pdf"',
            ]);
        }

        // PDF 2: detalle (timeline, checklist, firmas, etc.)
        $pdf2 = Pdf::loadView('pdf.workOrder.detalle', compact('workOrder'))
            ->setPaper('a4', 'portrait');
        $pdf2Content = $pdf2->output();

        // Guardar ambos en archivos temporales
        $tmpDir  = sys_get_temp_dir();
        $tmpPdf1 = $tmpDir . '/wo_portada_' . $workOrder->id . '_' . time() . '.pdf';
        $tmpPdf2 = $tmpDir . '/wo_detalle_' . $workOrder->id . '_' . time() . '.pdf';

        file_put_contents($tmpPdf1, $pdf1Content);
        file_put_contents($tmpPdf2, $pdf2Content);

        // Fusionar con FPDI
        $woCode = 'WO-' . str_pad($workOrder->id, 5, '0', STR_PAD_LEFT);
        $fpdi = new Fpdi();
        $fpdi->SetAutoPageBreak(false);
        $fpdi->SetTitle('Orden de Trabajo ' . $woCode);
        $fpdi->SetAuthor(config('app.name'));

        // Importar páginas del PDF1 (portada)
        $count1 = $fpdi->setSourceFile($tmpPdf1);
        for ($i = 1; $i <= $count1; $i++) {
            $tpl = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($tpl);
            $fpdi->AddPage($size['orientation'] ?? 'P', [$size['width'], $size['height']]);
            $fpdi->useTemplate($tpl);
        }

        // Importar páginas del PDF2 (detalle)
        $count2 = $fpdi->setSourceFile($tmpPdf2);
        for ($i = 1; $i <= $count2; $i++) {
            $tpl = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($tpl);
            $fpdi->AddPage($size['orientation'] ?? 'P', [$size['width'], $size['height']]);
            $fpdi->useTemplate($tpl);
        }

        $merged = $fpdi->Output('', 'S');

        // Limpiar temporales
        @unlink($tmpPdf1);
        @unlink($tmpPdf2);

        $filename = 'Orden_Trabajo_' . str_pad($workOrder->id, 5, '0', STR_PAD_LEFT) . '.pdf';

        return response($merged, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}
