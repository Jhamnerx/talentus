<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\DispatcherObserver;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy(DispatcherObserver::class)]
class Dispatcher extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected static function booted(): void
    {
        static::addGlobalScope(new EmpresaScope);
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
