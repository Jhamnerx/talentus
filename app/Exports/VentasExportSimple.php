<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Ventas;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class VentasExportSimple extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromQuery, WithMapping, WithHeadings, WithCustomValueBinder, ShouldAutoSize
{
    use Exportable;

    public function __construct(public $fecha_inicio, public  $fecha_fin, public $estado, public  $tipo_comprobante_id, public  $cliente_id, public  $vendedor_id)
    {
    }


    public function query()
    {
        return Ventas::query()->where('fecha_emision', '>=', $this->fecha_inicio)
            ->where('fecha_emision', '<=', $this->fecha_fin)
            // ->when($this->estado != 'Todos', function ($query) {
            //     return $query->where('estado', $this->estado);
            // })
            ->when($this->tipo_comprobante_id, function ($query) {
                return $query->where('tipo_comprobante_id', $this->tipo_comprobante_id);
            })
            ->when($this->cliente_id, function ($query) {
                return $query->where('cliente_id', $this->cliente_id);
            })
            ->when($this->vendedor_id, function ($query) {
                return $query->where('user_id', $this->vendedor_id);
            });
    }

    public function headings(): array
    {
        return [
            'FECHA EMISION',
            'COMPROBANTE',
            'CLIENTE RAZON SOCIAL',
            'CLIENTE RUC',
            'FORMA PAGO',
            'OP. GRAVADAS',
            'OP. EXONERADAS',
            'OP. INAFECTAS',
            'SUB TOTAL',
            'IGV',
            'TOTAL',
            'ESTADO',
            'ESTADO PAGO',
            'VENDEDOR',
            'SUNAT ESTADO'
        ];
    }

    public function map($venta): array
    {
        return [
            Carbon::parse($venta->fecha_emision)->format('d/m/Y'),
            $venta->serie_correlativo,
            $venta->cliente->razon_social,
            $venta->cliente->numero_documento,
            $venta->forma_pago,
            $venta->op_gravadas,
            $venta->op_exoneradas,
            $venta->op_inafectas,
            $venta->sub_total,
            $venta->igv,
            $venta->total,
            $venta->estado->name,
            $venta->pago_estado == 'UNPAID' ? 'PENDIENTE' : 'PAGADO',
            $venta->user->name,
            $venta->fe_mensaje_sunat

        ];
    }
}
