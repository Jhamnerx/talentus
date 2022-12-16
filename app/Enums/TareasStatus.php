<?php

namespace App\Enums;

enum TareasStatus: string
{

    case UNREAD = "UNREAD";
    case COMPLETE = "COMPLETE";
    case PENDIENT = "PENDIENT";
    case CANCELED = "CANCELED";

    public function color(): string
    {
        return match ($this) {
            TareasStatus::UNREAD => 'sky',
            TareasStatus::COMPLETE => 'emerald',
            TareasStatus::PENDIENT => 'orange',
            TareasStatus::CANCELED => 'rose',
        };
    }

    public function name(): string
    {
        return match ($this) {
            TareasStatus::UNREAD => 'SIN LEER',
            TareasStatus::COMPLETE => 'COMPLETADO',
            TareasStatus::PENDIENT => 'PENDIENTE',
            TareasStatus::CANCELED => 'CANCELADA',
        };
    }
}
