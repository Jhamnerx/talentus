<?php

namespace App\Enums;

enum LineasStatus: string
{

    case ACTIVA = "1";
    case SUSPENDIDA =  "2";

    public function color(): string
    {
        return match ($this) {
            LineasStatus::ACTIVA => 'emerald',
            LineasStatus::SUSPENDIDA => 'emerald',
        };
    }
}
