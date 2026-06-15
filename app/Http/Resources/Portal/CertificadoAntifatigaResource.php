<?php

namespace App\Http\Resources\Portal;

use App\Http\Resources\Portal\Concerns\HasPortalPdfUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificadoAntifatigaResource extends JsonResource
{
    use HasPortalPdfUrl;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fecha_emision' => $this->fecha_emision,
            'fecha_instalacion' => $this->fecha_instalacion,
            'inicio_cobertura' => $this->inicio_cobertura,
            'fin_cobertura' => $this->fin_cobertura,
            'imei_personalizado' => $this->imei_personalizado,
            'vehiculo' => $this->whenLoaded('vehiculo', fn () => [
                'id' => $this->vehiculo?->id,
                'placa' => $this->vehiculo?->placa,
            ]),
            'pdf_url' => $this->pdfUrl('certificado-antifatiga', $this->id),
        ];
    }
}
