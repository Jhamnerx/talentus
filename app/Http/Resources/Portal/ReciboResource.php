<?php

namespace App\Http\Resources\Portal;

use App\Http\Resources\Portal\Concerns\HasPortalPdfUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReciboResource extends JsonResource
{
    use HasPortalPdfUrl;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'serie' => $this->serie,
            'numero' => $this->numero,
            'serie_numero' => $this->serie_numero,
            'fecha_emision' => $this->fecha_emision,
            'fecha_pago' => $this->fecha_pago,
            'divisa' => $this->divisa,
            'total' => $this->total,
            'estado' => $this->estado,
            'pago_estado' => $this->pago_estado,
            'tipo_venta' => $this->tipo_venta,
            'pdf_url' => $this->pdfUrl('recibo', $this->id),
        ];
    }
}
