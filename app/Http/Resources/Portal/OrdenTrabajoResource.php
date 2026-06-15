<?php

namespace App\Http\Resources\Portal;

use App\Http\Resources\Portal\Concerns\HasPortalPdfUrl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdenTrabajoResource extends JsonResource
{
    use HasPortalPdfUrl;

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'estado' => $this->estado instanceof \BackedEnum ? $this->estado->value : $this->estado,
            'fecha_programada' => $this->fecha_programada,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_finalizacion' => $this->fecha_finalizacion,
            'observaciones_final' => $this->observaciones_final,
            'tipo' => $this->whenLoaded('tipo', fn () => [
                'id' => $this->tipo?->id,
                'nombre' => $this->tipo?->nombre,
            ]),
            'vehiculo' => $this->whenLoaded('vehiculo', fn () => [
                'id' => $this->vehiculo?->id,
                'placa' => $this->vehiculo?->placa,
            ]),
            'pdf_url' => $this->pdfUrl('orden-trabajo', $this->id),
        ];
    }
}
