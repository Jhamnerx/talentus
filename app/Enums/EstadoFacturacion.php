<?php

namespace App\Enums;

enum EstadoFacturacion: string
{
    case SIN_FACTURAR = 'SIN_FACTURAR';
    case FACTURADO = 'FACTURADO';
    case PAGADO = 'PAGADO';

    public function color(): string
    {
        return match ($this) {
            self::SIN_FACTURAR => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            self::FACTURADO => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
            self::PAGADO => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            self::SIN_FACTURAR => 'border-gray-500 dark:border-gray-600',
            self::FACTURADO => 'border-amber-500 dark:border-amber-600',
            self::PAGADO => 'border-emerald-500 dark:border-emerald-600',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::SIN_FACTURAR => '📋',
            self::FACTURADO => '📄',
            self::PAGADO => '✅',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::SIN_FACTURAR => 'Sin Facturar',
            self::FACTURADO => 'Facturado',
            self::PAGADO => 'Pagado',
        };
    }
}
