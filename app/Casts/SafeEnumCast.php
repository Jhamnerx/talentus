<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * Cast seguro para enums de respaldo string.
 * Usa tryFrom() en lugar de from(), por lo que valores inválidos en BD
 * devuelven null sin lanzar ValueError.
 *
 * Uso en $casts:
 *   'operador' => SafeEnumCast::class . ':' . TipoOperador::class,
 */
class SafeEnumCast implements CastsAttributes
{
    public function __construct(protected string $enumClass) {}

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value === null) {
            return null;
        }

        return $this->enumClass::tryFrom($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($value instanceof $this->enumClass) {
            return $value->value;
        }

        return $value;
    }
}
