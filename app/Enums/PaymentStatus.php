<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDIENTE = 'PENDIENTE';
    case PAGADO = 'PAGADO';
    case VENCIDO = 'VENCIDO';
    case PARCIAL = 'PARCIAL';

    public function color(): string
    {
        return match ($this) {
            self::PENDIENTE => 'text-amber-600',
            self::PAGADO => 'text-emerald-600',
            self::VENCIDO => 'text-rose-600',
            self::PARCIAL => 'text-blue-600',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            self::PENDIENTE => 'bg-amber-100 text-amber-800',
            self::PAGADO => 'bg-emerald-100 text-emerald-800',
            self::VENCIDO => 'bg-rose-100 text-rose-800',
            self::PARCIAL => 'bg-blue-100 text-blue-800',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::PENDIENTE => 'Pendiente',
            self::PAGADO => 'Pagado',
            self::VENCIDO => 'Vencido',
            self::PARCIAL => 'Parcial',
        };
    }
}
