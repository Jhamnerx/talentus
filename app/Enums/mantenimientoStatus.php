<?php

namespace App\Enums;

enum mantenimientoStatus: string
{

    case PENDIENTE = "PENDIENTE";
    case COMPLETADA = "COMPLETADA";
    case CANCELADO =  "CANCELADO";

    public function color(): string
    {
        return match ($this) {
            mantenimientoStatus::PENDIENTE => 'orange',
            mantenimientoStatus::COMPLETADA => 'emerald',
            mantenimientoStatus::CANCELADO => 'rose',
        };
    }
}
