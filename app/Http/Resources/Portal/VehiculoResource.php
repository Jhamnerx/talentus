<?php

namespace App\Http\Resources\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehiculoResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $acceso = $this->acceso_portal ?? ['accesible' => null, 'motivo' => null, 'plan' => null];

        return [
            'id' => $this->id,
            'placa' => $this->placa,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'color' => $this->color,
            'year' => $this->year,
            'accesible' => $acceso['accesible'],
            'motivo' => $acceso['motivo'],
            'plan' => $acceso['plan'],
            'dispositivo' => $this->whenLoaded('dispositivoPrincipal', fn () => $this->dispositivoPrincipal ? [
                'imei' => $this->dispositivoPrincipal->imei,
            ] : null),
        ];
    }
}
