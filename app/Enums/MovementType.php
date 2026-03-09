<?php

namespace App\Enums;

enum MovementType: string
{
    case INGRESO = 'INGRESO';
    case EGRESO = 'EGRESO';

    public function color(): string
    {
        return match ($this) {
            self::INGRESO => 'text-emerald-600',
            self::EGRESO => 'text-rose-600',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            self::INGRESO => 'bg-emerald-100 text-emerald-800',
            self::EGRESO => 'bg-rose-100 text-rose-800',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::INGRESO => 'Ingreso',
            self::EGRESO => 'Egreso',
        };
    }
}
