<?php

declare(strict_types=1);

namespace App\Enums;

enum TipoOperador: string
{
    case M2M   = 'M2M';
    case CLARO = 'CLARO';
    case CUY   = 'CUY';
    case IOT   = 'IOT';

    /**
     * Indica si el número de línea está vinculado físicamente al chip
     * y NO puede reasignarse a otro SIM card.
     * M2M, CUY, IOT: el número viene fijo desde el proveedor.
     * CLARO: el chip físico puede recibir distintos números.
     */
    public function esNumeroFijo(): bool
    {
        return match ($this) {
            self::M2M, self::CUY, self::IOT => true,
            self::CLARO                     => false,
        };
    }

    /**
     * Las líneas suspendidas se reactivan automáticamente tras el período (solo CLARO).
     */
    public function tieneAutoReactivacion(): bool
    {
        return $this === self::CLARO;
    }

    /**
     * Indica si la línea puede darse de baja definitiva desde el panel.
     */
    public function permiteGestionDesdePanel(): bool
    {
        return $this === self::CLARO;
    }

    public function label(): string
    {
        return match ($this) {
            self::M2M   => 'M2M — Número fijo al chip',
            self::CLARO => 'Claro — Número flexible (auto-reactivación 60 días)',
            self::CUY   => 'CUY — Número fijo al chip',
            self::IOT   => 'IOT — Número fijo al chip',
        };
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::M2M   => 'blue',
            self::CLARO => 'purple',
            self::CUY   => 'green',
            self::IOT   => 'orange',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}
