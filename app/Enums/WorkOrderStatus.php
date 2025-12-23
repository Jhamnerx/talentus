<?php

namespace App\Enums;

enum WorkOrderStatus: string
{
    case PENDIENTE = "pendiente";
    case EN_PROCESO = "en_proceso";
    case FINALIZADO = "finalizado";
    case CANCELADO = "cancelado";

    public function color(): string
    {
        return match ($this) {
            WorkOrderStatus::PENDIENTE => 'text-amber-500',
            WorkOrderStatus::EN_PROCESO => 'text-blue-500',
            WorkOrderStatus::FINALIZADO => 'text-emerald-500',
            WorkOrderStatus::CANCELADO => 'text-rose-500',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            WorkOrderStatus::PENDIENTE => 'bg-amber-100 text-amber-700',
            WorkOrderStatus::EN_PROCESO => 'bg-blue-100 text-blue-700',
            WorkOrderStatus::FINALIZADO => 'bg-emerald-100 text-emerald-700',
            WorkOrderStatus::CANCELADO => 'bg-rose-100 text-rose-700',
        };
    }

    public function label(): string
    {
        return match ($this) {
            WorkOrderStatus::PENDIENTE => 'Pendiente',
            WorkOrderStatus::EN_PROCESO => 'En Proceso',
            WorkOrderStatus::FINALIZADO => 'Finalizado',
            WorkOrderStatus::CANCELADO => 'Cancelado',
        };
    }

    public function canEdit(): bool
    {
        return match ($this) {
            WorkOrderStatus::PENDIENTE, WorkOrderStatus::EN_PROCESO => true,
            WorkOrderStatus::FINALIZADO, WorkOrderStatus::CANCELADO => false,
        };
    }
}
