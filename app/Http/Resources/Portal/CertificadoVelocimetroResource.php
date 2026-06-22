<?php

namespace App\Http\Resources\Portal;

use App\Http\Resources\Portal\Concerns\HasPortalPdfUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificadoVelocimetroResource extends JsonResource
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
            'velocimetro_modelo' => $this->velocimetro_modelo,
            'vehiculo' => $this->whenLoaded('vehiculo', fn () => [
                'id' => $this->vehiculo?->id,
                'placa' => $this->vehiculo?->placa,
            ]),
            'pdf_url' => $this->pdfUrl('certificado-velocimetro', $this->id),
        ];
    }
}
