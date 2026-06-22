<?php

namespace App\Http\Resources\Portal;

use App\Http\Resources\Portal\Concerns\HasPortalPdfUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresupuestoResource extends JsonResource
{
    use HasPortalPdfUrl;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'serie_correlativo' => $this->serie_correlativo,
            'numero' => $this->numero,
            'fecha' => $this->fecha,
            'fecha_caducidad' => $this->fecha_caducidad,
            'total' => $this->total,
            'total_soles' => $this->total_soles,
            'estado' => $this->estado instanceof \BackedEnum ? $this->estado->value : $this->estado,
            'pdf_url' => $this->pdfUrl('presupuesto', $this->id),
        ];
    }
}
