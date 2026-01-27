<?php

namespace App\Exports;

use App\Models\CashMovement;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransaccionesExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $from;
    protected $to;
    protected $tipo;
    protected $cashId;
    protected $search;

    public function __construct($from = null, $to = null, $tipo = null, $cashId = null, $search = '')
    {
        $this->from = $from;
        $this->to = $to;
        $this->tipo = $tipo;
        $this->cashId = $cashId;
        $this->search = $search;
    }

    public function query()
    {
        $query = CashMovement::query()->with(['cash', 'cliente', 'user']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('numero', 'like', '%' . $this->search . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->tipo) {
            $query->where('tipo', $this->tipo);
        }

        if ($this->cashId) {
            $query->where('cash_id', $this->cashId);
        }

        if ($this->from && $this->to) {
            $query->whereBetween('fecha', [$this->from, $this->to]);
        }

        return $query->orderBy('fecha', 'desc');
    }

    public function headings(): array
    {
        return [
            'N°',
            'Caja',
            'Tipo',
            'Fecha',
            'Comprobante',
            'N° Comprobante',
            'Cliente',
            'Descripción',
            'Método',
            'Monto',
            'Moneda',
            'Usuario',
            'Fecha Registro',
        ];
    }

    public function map($movement): array
    {
        return [
            $movement->numero,
            $movement->cash->nombre,
            $movement->tipo->label(),
            $movement->fecha->format('d/m/Y'),
            $movement->tipo_comprobante ?? '-',
            $movement->numero_comprobante ?? '-',
            $movement->cliente ? $movement->cliente->nombre_completo : '-',
            $movement->descripcion,
            $movement->metodo_ingreso ?? '-',
            number_format($movement->monto, 2),
            $movement->moneda,
            $movement->user->name,
            $movement->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
