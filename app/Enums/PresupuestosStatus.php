<?php

namespace App\Enums;

enum PresupuestosStatus: string
{

    case PENDIENTE = "0";
    case ACEPTADA = "1";
    case RECHAZADA =  "2";

    public function color(): string
    {
        return match ($this) {
            PresupuestosStatus::PENDIENTE => 'orange',
            PresupuestosStatus::ACEPTADA => 'emerald',
            PresupuestosStatus::RECHAZADA => 'rose',
        };
    }
}
