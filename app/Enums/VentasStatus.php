<?php

namespace App\Enums;

enum VentasStatus: string
{

    case COMPLETADO = "COMPLETADO";
    case BORRADOR = "BORRADOR";

    public function color(): string
    {
        return match ($this) {
            VentasStatus::COMPLETADO => 'text-emerald-500',
            VentasStatus::BORRADOR => 'text-slate-500',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            VentasStatus::COMPLETADO => 'bg-emerald-100 text-emerald-600',
            VentasStatus::BORRADOR => 'bg-slate-100 text-slate-500',
        };
    }
}
