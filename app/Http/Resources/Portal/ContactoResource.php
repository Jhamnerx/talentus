<?php

namespace App\Http\Resources\Portal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactoResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'cargo' => $this->cargo,
            'numero_documento' => $this->numero_documento,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'birthday' => optional($this->birthday)->format('Y-m-d'),
            'is_gerente' => (bool) $this->is_gerente,
            'is_cobros' => (bool) $this->is_cobros,
            'descripcion' => $this->descripcion,
            'nota' => $this->nota,
        ];
    }
}
