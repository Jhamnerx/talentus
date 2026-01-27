<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountPayable extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $recordEvents = ['deleted', 'created', 'updated'];

    protected $table = 'accounts_payable';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha_emision' => 'date:Y-m-d',
        'fecha_vencimiento' => 'date:Y-m-d',
        'monto_total' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
        'saldo_pendiente' => 'decimal:2',
        'estado' => PaymentStatus::class,
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    protected function empresaId(): Attribute
    {
        return new Attribute(
            set: fn($empresa_id) => session('empresa'),
        );
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', PaymentStatus::PENDIENTE);
    }

    public function scopePagados($query)
    {
        return $query->where('estado', PaymentStatus::PAGADO);
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', PaymentStatus::VENCIDO);
    }

    public function scopeParciales($query)
    {
        return $query->where('estado', PaymentStatus::PARCIAL);
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedores::class, 'proveedor_id');
    }
}
