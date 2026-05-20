<?php

namespace App\Exports;

use App\Models\Cobros;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class CobrosExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /** Ãndices (1-based) de filas de cabecera de grupo (cliente). */
    protected array $groupHeaderRows = [];

    public function __construct(
        protected ?string $search            = null,
        protected         $estado            = null,
        protected ?int    $clienteId         = null,
        protected ?string $filtroFecha       = null,
        protected ?string $filtroVencimiento = null,
    ) {}

    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

    public function collection(): Collection
    {
        $hoy = Carbon::now();

        $cobros = Cobros::query()
            ->with(['vehiculo', 'clientes', 'plan'])
            ->when($this->clienteId, fn($q) => $q->where('clientes_id', $this->clienteId))
            ->when($this->search, function ($q) {
                $q->where(function ($inner) {
                    $inner->whereHas('clientes', fn($c) => $c->where('razon_social', 'like', '%' . $this->search . '%'))
                        ->orWhereHas('vehiculo', fn($v) => $v->where('placa', 'like', '%' . $this->search . '%'));
                });
            })
            ->when($this->estado !== null, fn($q) => $q->where('estado', $this->estado))
            ->when($this->filtroFecha === 'registrados_7dias', fn($q) => $q->whereBetween('created_at', [$hoy->copy()->subDays(7), $hoy]))
            ->when($this->filtroFecha === 'registrados_mes',   fn($q) => $q->whereBetween('created_at', [$hoy->copy()->startOfMonth(), $hoy]))
            ->when($this->filtroVencimiento === 'vencen_7dias',    fn($q) => $q->where('estado', 'ACTIVO')->whereBetween('fecha_vencimiento', [$hoy->copy()->startOfDay(), $hoy->copy()->addDays(7)->endOfDay()]))
            ->when($this->filtroVencimiento === 'vencen_fin_mes',  fn($q) => $q->where('estado', 'ACTIVO')->whereBetween('fecha_vencimiento', [$hoy->copy()->startOfDay(), $hoy->copy()->endOfMonth()->endOfDay()]))
            ->when($this->filtroVencimiento === 'vencen_proximo_mes', fn($q) => $q->where('estado', 'ACTIVO')->whereBetween('fecha_vencimiento', [$hoy->copy()->startOfDay(), $hoy->copy()->addMonth()->endOfDay()]))
            ->when($this->filtroVencimiento === 'vencidos',    fn($q) => $q->where('estado', 'ACTIVO')->where('fecha_vencimiento', '<', $hoy->copy()->startOfDay()))
            ->orderBy('clientes_id', 'asc')
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();

        // â”€â”€ Agrupar por cliente y construir filas planas â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
        $grouped = $cobros->groupBy(fn($c) => $c->clientes?->razon_social ?? 'Sin cliente');

        $rows     = collect();
        $rowIndex = 2; // la fila 1 es el encabezado de columnas

        foreach ($grouped as $clienteName => $items) {
            // â”€â”€ Fila de cabecera de grupo â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            $this->groupHeaderRows[] = $rowIndex++;
            $rows->push([
                strtoupper($clienteName),
                $items->count() . ' vehÃ­culo(s)',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ]);

            // â”€â”€ Filas de datos â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
            foreach ($items as $cobro) {
                $rows->push($this->mapCobro($cobro));
                $rowIndex++;
            }
        }

        return $rows;
    }

    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

    public function headings(): array
    {
        return [
            'CLIENTE',
            'PLACA',
            'PLAN',
            'PERÃODO',
            'TIPO COMPROBANTE',
            'MONTO PLAN',
            'DESCUENTO',
            'DIVISA',
            'FECHA INICIO',
            'FECHA VENCIMIENTO',
            'DÃAS RESTANTES',
            'ESTADO',
        ];
    }

    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet   = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastCol = 'L'; // 12 columnas

                // â”€â”€ Cabecera de columnas (fila 1) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
                $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(22);

                // â”€â”€ Cabeceras de grupo (filas de cliente) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
                foreach ($this->groupHeaderRows as $row) {
                    $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 10],
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1D4ED8']],
                    ]);
                    $sheet->getRowDimension($row)->setRowHeight(18);
                }

                // â”€â”€ Filas de datos: bandas alternas â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
                $groupRowSet = array_flip($this->groupHeaderRows);
                for ($r = 2; $r <= $lastRow; $r++) {
                    if (isset($groupRowSet[$r])) {
                        continue;
                    }
                    $color = ($r % 2 === 0) ? 'F9FAFB' : 'FFFFFF';
                    $sheet->getStyle("A{$r}:{$lastCol}{$r}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color]],
                    ]);
                }

                // â”€â”€ Bordes de tabla â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color'       => ['rgb' => 'E5E7EB'],
                        ],
                    ],
                ]);

                // â”€â”€ Congelar primera fila â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
                $sheet->freezePane('A2');
            },
        ];
    }

    // â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€

    private function mapCobro(Cobros $cobro): array
    {
        $fechaVenc     = $cobro->fecha_vencimiento;
        $diasRestantes = '';

        if ($fechaVenc) {
            $dias          = (int) Carbon::now()->startOfDay()->diffInDays($fechaVenc, false);
            $diasRestantes = $dias >= 0 ? $dias : 'Vencido (' . abs($dias) . 'd)';
        }

        return [
            $cobro->clientes?->razon_social                                             ?? 'â€”',
            $cobro->vehiculo?->placa                                                    ?? 'â€”',
            $cobro->plan_nombre                                                         ?? 'â€”',
            $cobro->periodo                                                             ?? 'â€”',
            $cobro->tipo_pago                                                           ?? 'â€”',
            $cobro->monto !== null ? number_format((float) $cobro->monto, 2, '.', '')  : 'â€”',
            $cobro->descuento !== null ? number_format((float) $cobro->descuento, 2, '.', '') : '0.00',
            $cobro->divisa                                                              ?? 'â€”',
            $cobro->fecha_inicio?->format('d/m/Y')                                     ?? 'â€”',
            $cobro->fecha_vencimiento?->format('d/m/Y')                                ?? 'â€”',
            $diasRestantes,
            $cobro->estado?->value                                                      ?? 'â€”',
        ];
    }
}
