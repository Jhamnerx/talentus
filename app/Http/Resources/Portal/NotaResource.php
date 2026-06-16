<?php

namespace App\Http\Resources\Portal;

use App\Http\Resources\Portal\Concerns\HasPortalPdfUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Notas de crédito (07) y débito (08) — modelo Comprobantes.
 */
class NotaResource extends JsonResource
{
    use HasPortalPdfUrl;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo' => $this->tipo_comprobante_id === '07' ? 'credito' : 'debito',
            'tipo_comprobante_id' => $this->tipo_comprobante_id,
            'serie_correlativo' => $this->serie_correlativo,
            'fecha_emision' => $this->fecha_emision,
            'divisa' => $this->divisa,
            'sub_total' => $this->sub_total,
            'igv' => $this->igv,
            'total' => $this->total,
            'estado' => $this->estado instanceof \BackedEnum ? $this->estado->value : $this->estado,
            'fe_estado' => $this->fe_estado,
            'documento_afectado' => $this->serie_correlativo_ref,
            'motivo' => $this->sustento_texto,
            'pdf_url' => $this->pdfUrl($this->tipo_comprobante_id === '07' ? 'nota-credito' : 'nota-debito', $this->id),
        ];
    }
}
