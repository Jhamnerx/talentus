<?php

namespace App\Enums;

enum ChecklistResultado: string
{
    case OK = "ok";
    case OBSERVADO = "observado";
    case NO_APLICA = "no_aplica";

    public function color(): string
    {
        return match ($this) {
            ChecklistResultado::OK => 'text-emerald-500',
            ChecklistResultado::OBSERVADO => 'text-amber-500',
            ChecklistResultado::NO_APLICA => 'text-gray-400',
        };
    }

    public function statusColor(): string
    {
        return match ($this) {
            ChecklistResultado::OK => 'bg-emerald-100 text-emerald-700',
            ChecklistResultado::OBSERVADO => 'bg-amber-100 text-amber-700',
            ChecklistResultado::NO_APLICA => 'bg-gray-100 text-gray-500',
        };
    }

    public function label(): string
    {
        return match ($this) {
            ChecklistResultado::OK => 'OK',
            ChecklistResultado::OBSERVADO => 'Observado',
            ChecklistResultado::NO_APLICA => 'No Aplica',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            ChecklistResultado::OK => 'check-circle',
            ChecklistResultado::OBSERVADO => 'exclamation-triangle',
            ChecklistResultado::NO_APLICA => 'minus-circle',
        };
    }
}
