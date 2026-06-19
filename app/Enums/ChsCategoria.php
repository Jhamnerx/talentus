<?php

namespace App\Enums;

enum ChsCategoria: string
{
    case EXCELENTE = 'excelente';
    case BUENO = 'bueno';
    case EN_RIESGO = 'en_riesgo';
    case CRITICO = 'critico';

    public function label(): string
    {
        return match ($this) {
            self::EXCELENTE => 'Excelente',
            self::BUENO => 'Bueno',
            self::EN_RIESGO => 'En riesgo',
            self::CRITICO => 'Crítico',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::EXCELENTE => 'text-emerald-600',
            self::BUENO => 'text-blue-600',
            self::EN_RIESGO => 'text-amber-600',
            self::CRITICO => 'text-rose-600',
        };
    }

    public function bgColor(): string
    {
        return match ($this) {
            self::EXCELENTE => 'bg-emerald-100 text-emerald-700',
            self::BUENO => 'bg-blue-100 text-blue-700',
            self::EN_RIESGO => 'bg-amber-100 text-amber-700',
            self::CRITICO => 'bg-rose-100 text-rose-700',
        };
    }

    public function barColor(): string
    {
        return match ($this) {
            self::EXCELENTE => 'bg-emerald-500',
            self::BUENO => 'bg-blue-500',
            self::EN_RIESGO => 'bg-amber-500',
            self::CRITICO => 'bg-rose-500',
        };
    }

    public static function paraScore(int $score): self
    {
        return match (true) {
            $score >= 80 => self::EXCELENTE,
            $score >= 60 => self::BUENO,
            $score >= 40 => self::EN_RIESGO,
            default => self::CRITICO,
        };
    }
}
