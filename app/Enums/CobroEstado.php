<?php

namespace App\Enums;

enum CobroEstado: string
{
    case ACTIVO = 'ACTIVO';
    case SUSPENDIDO = 'SUSPENDIDO';
    case CANCELADO = 'CANCELADO';
    case CORTESIA = 'CORTESIA';

    public function color(): string
    {
        return match ($this) {
            CobroEstado::ACTIVO => 'text-emerald-600',
            CobroEstado::SUSPENDIDO => 'text-orange-500',
            CobroEstado::CANCELADO => 'text-red-500',
            CobroEstado::CORTESIA => 'text-blue-500',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            CobroEstado::ACTIVO => 'bg-emerald-100 text-emerald-700',
            CobroEstado::SUSPENDIDO => 'bg-orange-100 text-orange-700',
            CobroEstado::CANCELADO => 'bg-red-100 text-red-700',
            CobroEstado::CORTESIA => 'bg-blue-100 text-blue-700',
        };
    }

    public function label(): string
    {
        return match ($this) {
            CobroEstado::ACTIVO => 'Activo',
            CobroEstado::SUSPENDIDO => 'Suspendido',
            CobroEstado::CANCELADO => 'Cancelado',
            CobroEstado::CORTESIA => 'Cortesía',
        };
    }

    public function descripcion(): string
    {
        return match ($this) {
            CobroEstado::ACTIVO => 'Se factura y alerta normalmente',
            CobroEstado::SUSPENDIDO => 'No se factura ni se alerta',
            CobroEstado::CANCELADO => 'Terminado permanentemente',
            CobroEstado::CORTESIA => 'Activo sin cobro',
        };
    }

    public function canFacturar(): bool
    {
        return match ($this) {
            CobroEstado::ACTIVO, CobroEstado::CORTESIA => true,
            CobroEstado::SUSPENDIDO, CobroEstado::CANCELADO => false,
        };
    }

    public function canAlertar(): bool
    {
        return $this === CobroEstado::ACTIVO;
    }
}
