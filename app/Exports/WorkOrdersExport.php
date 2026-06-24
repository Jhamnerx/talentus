<?php

namespace App\Exports;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class WorkOrdersExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromView, WithCustomValueBinder, ShouldAutoSize, WithStyles, ShouldQueue, WithDrawings
{
    use Exportable;

    protected $tecnico_id, $fecha_inicial, $fecha_final, $estado;

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo Talentus');
        $drawing->setPath(public_path('/images/logo-excel.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B1');

        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 14]],
            6 => ['font' => ['bold' => true, 'size' => 14]],
            7 => ['font' => ['bold' => true], 'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]]
        ];
    }

    public function __construct($tecnico_id, $fecha_inicial, $fecha_final, $estado)
    {
        $this->tecnico_id = $tecnico_id;
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
        $this->estado = $estado;
    }

    public function sumTotalCostWorkOrders($workOrders, $estado = null)
    {
        $filtered = $workOrders;

        // Si se especifica un estado, filtrar por ese estado
        if ($estado) {
            $filtered = $workOrders->filter(fn($orden) => $orden->estado->value === $estado);
        }

        return $filtered->sum(function ($orden) {
            $costo_base = floatval($orden->tipo_data['costo_base'] ?? 0);
            $costo_accesorios = $orden->accessories->sum('subtotal');
            return $costo_base + $costo_accesorios;
        });
    }

    public function view(): View
    {
        $workOrders = WorkOrder::query()
            ->whereRaw(
                "(work_orders.fecha_programada >= ? AND work_orders.fecha_programada <= ?)",
                [
                    $this->fecha_inicial . " 00:00:00",
                    $this->fecha_final . " 23:59:59"
                ]
            )
            ->when($this->tecnico_id !== 'todos', fn($q) => $q->where('work_orders.tecnico_id', $this->tecnico_id))
            ->when($this->estado, fn($q) => $q->where('work_orders.estado', $this->estado))
            ->with(['vehiculo', 'tipo', 'cliente', 'tecnico', 'creador', 'accessories', 'deviceHistory'])
            ->orderBy('estado')
            ->orderBy('fecha_programada')
            ->get();

        // Agrupar por estado
        $workOrdersGrouped = $workOrders->groupBy(fn($orden) => $orden->estado->value);

        // Calcular totales por estado
        $totalesPorEstado = [];
        foreach ($workOrdersGrouped as $estado => $ordenes) {
            $totalesPorEstado[$estado] = $this->sumTotalCostWorkOrders($ordenes);
        }

        // Total general solo de finalizadas
        $totalCostoFinalizadas = $this->sumTotalCostWorkOrders($workOrders, 'finalizado');

        $tecnico = $this->tecnico_id !== 'todos' ? User::find($this->tecnico_id) : null;

        return view('exports.work-orders', [
            'workOrdersGrouped' => $workOrdersGrouped,
            'workOrders' => $workOrders,
            'tecnico' => $tecnico,
            'total_costo_finalizadas' => $totalCostoFinalizadas,
            'totales_por_estado' => $totalesPorEstado,
            'fechas' => [
                'fecha_inicial' => $this->fecha_inicial,
                'fecha_final' => $this->fecha_final,
            ],
            'estado' => $this->estado
        ]);
    }
}
