<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Spatie\Activitylog\LogOptions;
use App\Observers\ClientesObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ClientesObserver::class)]
class Clientes extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use LogsActivity;
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'clientes';
    // SCOPE DE EMPRESA


    protected $casts = [
        'id' => 'integer',
        'deleted_at' => 'date',
    ];

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }

    // Scope local de activo
    public function scopeTipoDoc($query, $tipo)
    {
        return $query->where('tipo_documento_id', $tipo);
    }
    //relacion uno a muchos

    public function presupuestos()
    {
        return $this->hasMany(Presupuestos::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion uno a muchos
    public function ventas()
    {
        return $this->hasMany(Ventas::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion uno a muchos
    public function recibos()
    {
        return $this->hasMany(Recibos::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }


    //relacion uno a muchos
    public function contratos(): HasMany
    {
        return $this->hasMany(Contratos::class, 'clientes_id')->withoutGlobalScope(EmpresaScope::class);
    }


    //relacion uno a muchos
    public function flotas()
    {
        return $this->hasMany(Flotas::class, 'clientes_id');
    }


    public function vehiculos(): HasMany
    {
        return $this->hasMany(Vehiculos::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function rubro()
    {
        return $this->belongsTo(RubroCliente::class, 'rubro_id');
    }

    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }


    /**
     * Nota: a diferencia de vehiculos() (que usa withTrashed()), estas
     * relaciones hasManyThrough excluyen automáticamente los documentos de
     * vehículos dados de baja (Laravel aplica vehiculos.deleted_at is null
     * al JOIN intermedio). Limitación conocida y aceptada: hoy no hay
     * vehículos eliminados con documentos asociados en el sistema.
     */
    public function certificados(): HasManyThrough
    {
        return $this->hasManyThrough(Certificados::class, Vehiculos::class, 'clientes_id', 'vehiculos_id');
    }

    public function actas(): HasManyThrough
    {
        return $this->hasManyThrough(Actas::class, Vehiculos::class, 'clientes_id', 'vehiculos_id');
    }

    public function certVelocimetros(): HasManyThrough
    {
        return $this->hasManyThrough(CertificadosVelocimetros::class, Vehiculos::class, 'clientes_id', 'vehiculos_id');
    }


    //relacion uno a muchos contactos

    public function contactos()
    {
        return $this->hasMany(Contactos::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion uno a muchos

    public function cobros()
    {
        return $this->hasMany(Cobros::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function tareas()
    {

        return $this->hasMany(Tareas::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function tipoDocumento(): HasOne
    {
        return $this->hasOne(TipoDocumento::class, 'codigo', 'tipo_documento_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'customer_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function clienteUsers(): HasMany
    {
        return $this->hasMany(ClienteUser::class, 'cliente_id');
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function chsHistorico(): HasMany
    {
        return $this->hasMany(ChsHistorico::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(WorkOrder::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function whatsappConversaciones(): HasMany
    {
        return $this->hasMany(\App\Models\WhatsFleep\WhatsappConversation::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }
}
