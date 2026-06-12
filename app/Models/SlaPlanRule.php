<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlaPlanRule extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'tr_hours'           => 'decimal:3',
            'ts_remote_hours'    => 'decimal:3',
            'tr_business_hours'  => 'boolean',
            'ts_business_hours'  => 'boolean',
        ];
    }

    public static function forPlan(string $planType, string $priority): ?self
    {
        return static::where('plan_type', $planType)->where('priority', $priority)->first();
    }

    public static function planTypes(): array
    {
        return ['basico', 'estandar', 'premium', 'mininter'];
    }

    public static function planLabel(string $planType): string
    {
        return match ($planType) {
            'basico'   => 'Básico — Control Mínimo',
            'estandar' => 'Estándar — Gestión Operativa',
            'premium'  => 'Premium — Grandes Flotas',
            'mininter' => 'MININTER / SIPCOP-M',
            default    => ucfirst($planType),
        };
    }
}
