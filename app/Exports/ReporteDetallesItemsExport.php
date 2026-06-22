<?php

namespace App\Exports;

use App\Models\DetalleRecibos;
use App\Models\VentasDetalle;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReporteDetallesItemsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function __construct(
        public readonly string $contexto,            // 'ventas' | 'recibos'
        public readonly string $fecha_inicio,
        public readonly string $fecha_fin,
        public readonly string $tipo_item,            // 'todos' | 'producto' | 'servicio'
        public readonly string $estado_doc,           // 'todos' | 'COMPLETADO' | 'BORRADOR' | 'anulado'
        public readonly mixed $cliente_id,
        public readonly ?string $tipo_comprobante_id,
    ) {}

    public function collection(): Collection
    {
        return $this->contexto === 'recibos'
            ? $this->fetchRecibos()
            : $this->fetchVentas();
    }

    public function headings(): array
    {
        if ($this->contexto === 'recibos') {
            return [
                'Fecha',
                'Documento',
                'Estado Doc',
                'Cliente',
                'RUC/DNI',
                'Producto',
                'Descripción',
                'Tipo Ítem',
                'Cantidad',
                'Precio',
                'Descuento',
                'Total Línea',
                'Divisa',
                'Estado Pago',
            ];
        }

        return [
            'Fecha',
            'Documento',
            'Tipo Comprobante',
            'Estado Doc',
            'Cliente',
            'RUC/DNI',
            'Cód. Producto',
            'Descripción',
            'Tipo Ítem',
            'Cantidad',
            'V. Unitario',
            'P. Unitario',
            'Descuento',
            'Sub Total',
            'IGV',
            'Total Línea',
            'Divisa',
            'Estado Pago',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function fetchVentas(): Collection
    {
        return VentasDetalle::query()
            ->with(['venta.cliente', 'venta.tipoComprobante', 'producto'])
            ->whereHas('venta', function ($q) {
                $q->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin]);

                match ($this->estado_doc) {
                    'COMPLETADO' => $q->where('estado', 'COMPLETADO')->whereNull('id_baja'),
                    'BORRADOR' => $q->where('estado', 'BORRADOR'),
                    'anulado' => $q->whereNotNull('id_baja'),
                    default => null,
                };

                if ($this->cliente_id) {
                    $q->where('cliente_id', $this->cliente_id);
                }

                if ($this->tipo_comprobante_id) {
                    $q->where('tipo_comprobante_id', $this->tipo_comprobante_id);
                }
            })
            ->when(
                $this->tipo_item !== 'todos',
                fn ($q) => $q->whereHas('producto', fn ($pq) => $pq->where('tipo', $this->tipo_item))
            )
            ->get()
            ->sortBy(fn ($d) => $d->venta->fecha_emision)
            ->map(function (VentasDetalle $d) {
                $venta = $d->venta;
                $isAnulada = ! is_null($venta->id_baja);

                return [
                    $venta->fecha_emision?->format('d/m/Y'),
                    $venta->serie_correlativo,
                    $venta->tipoComprobante->descripcion ?? '',
                    $isAnulada ? 'ANULADA' : $venta->estado->value,
                    $venta->cliente->razon_social ?? '',
                    $venta->cliente->numero_documento ?? '',
                    $d->codigo,
                    $d->descripcion,
                    strtoupper($d->producto->tipo ?? 'N/A'),
                    $d->cantidad,
                    $d->valor_unitario,
                    $d->precio_unitario,
                    $d->descuento,
                    $d->sub_total,
                    $d->igv,
                    $d->total,
                    strtoupper($venta->divisa ?? 'PEN'),
                    $venta->pago_estado === 'PAID' ? 'PAGADO' : 'PENDIENTE',
                ];
            })
            ->values();
    }

    private function fetchRecibos(): Collection
    {
        return DetalleRecibos::query()
            ->with(['recibos.clientes', 'producto'])
            ->whereHas('recibos', function ($q) {
                $q->whereBetween('fecha_emision', [$this->fecha_inicio, $this->fecha_fin]);

                match ($this->estado_doc) {
                    'COMPLETADO' => $q->where('estado', 'COMPLETADO'),
                    'BORRADOR' => $q->where('estado', 'BORRADOR'),
                    default => null,
                };

                if ($this->cliente_id) {
                    $q->where('clientes_id', $this->cliente_id);
                }
            })
            ->when(
                $this->tipo_item !== 'todos',
                fn ($q) => $q->whereHas('producto', fn ($pq) => $pq->where('tipo', $this->tipo_item))
            )
            ->get()
            ->sortBy(fn ($d) => $d->recibos->fecha_emision)
            ->map(function (DetalleRecibos $d) {
                $recibo = $d->recibos;

                // detalle_recibos.producto is a text column with the same name as the producto() relation;
                // Eloquent resolves attributes before relations, so getAttributes()/getRelation() must be used explicitly.
                return [
                    $recibo->fecha_emision?->format('d/m/Y'),
                    $recibo->serie . '-' . $recibo->numero,
                    $recibo->estado,
                    $recibo->clientes->razon_social ?? '',
                    $recibo->clientes->numero_documento ?? '',
                    $d->getAttributes()['producto'],
                    $d->descripcion,
                    strtoupper($d->getRelation('producto')?->tipo ?? 'N/A'),
                    $d->cantidad,
                    $d->precio,
                    $d->descuento_val,
                    $d->total,
                    strtoupper($recibo->divisa ?? 'PEN'),
                    $recibo->pago_estado === 'PAID' ? 'PAGADO' : 'PENDIENTE',
                ];
            })
            ->values();
    }
}
