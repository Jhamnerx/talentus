<?php

namespace App\Http\Resources\Portal;

use App\Http\Resources\Portal\Concerns\HasPortalPdfUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificadoGpsResource extends JsonResource
{
    use HasPortalPdfUrl;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'codigo' => $this->codigo,
            'fecha' => $this->fecha,
            'fecha_instalacion' => $this->fecha_instalacion,
            'fin_cobertura' => $this->fin_cobertura,
            'vehiculo' => $this->whenLoaded('vehiculo', fn () => [
                'id' => $this->vehiculo?->id,
                'placa' => $this->vehiculo?->placa,
            ]),
            'pdf_url' => $this->pdfUrl('certificado-gps', $this->id),
        ];
    }
}
