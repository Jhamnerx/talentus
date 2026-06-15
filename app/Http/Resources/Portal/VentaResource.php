<?php

namespace App\Http\Resources\Portal;

use App\Http\Resources\Portal\Concerns\HasPortalPdfUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Boletas, facturas y notas de venta (modelo Ventas).
 */
class VentaResource extends JsonResource
{
    use HasPortalPdfUrl;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo_comprobante_id' => $this->tipo_comprobante_id,
            'serie_correlativo' => $this->serie_correlativo,
            'fecha_emision' => $this->fecha_emision,
            'divisa' => $this->divisa,
            'sub_total' => $this->sub_total,
            'igv' => $this->igv,
            'total' => $this->total,
            'estado' => $this->estado instanceof \BackedEnum ? $this->estado->value : $this->estado,
            'pago_estado' => $this->pago_estado,
            'fe_estado' => $this->fe_estado,
            'anulado' => ! is_null($this->id_baja),
            'comunicacion_baja' => $this->id_baja ? [
                'id' => $this->id_baja,
                'nombre_xml' => $this->relationLoaded('envioResumen') ? optional($this->envioResumen)->nombre_xml : null,
                'pdf_url' => $this->pdfUrl('comunicacion-baja', $this->id_baja),
            ] : null,
            'pdf_url' => $this->pdfUrl('comprobante', $this->id),
        ];
    }
}
