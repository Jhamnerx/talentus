<?php

namespace App\Models;

use App\Enums\WorkOrderStatus;
use App\Scopes\EmpresaScope;
use App\Observers\WorkOrderObserver;
use App\Models\Presupuestos;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(WorkOrderObserver::class)]
class WorkOrder extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'presupuesto_id'   => 'integer',
        'estado' => WorkOrderStatus::class,
        'fecha_programada' => 'datetime',
        'fecha_inicio' => 'datetime',
        'fecha_finalizacion' => 'datetime',
        'fecha_cerrado' => 'datetime',
        'tipo_data' => 'array',
        'metadata' => 'array',
        'bloqueado' => 'boolean',
        'wa_message_id' => 'string',
        'wa_group_id' => 'string',
        'ubicacion_lat' => 'float',
        'ubicacion_lng' => 'float',
        'tecnico_lat' => 'float',
        'tecnico_lng' => 'float',
        'tecnico_last_seen' => 'datetime',
        'verified_at' => 'datetime',
        'es_proyecto' => 'boolean',
        'calificacion_cliente' => 'integer',
        'calificado_at' => 'datetime',
    ];

    // Global Scope - Multi-empresa
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);

        static::creating(function (self $order) {
            if (empty($order->verification_hash)) {
                $order->verification_hash = \Illuminate\Support\Str::random(32);
            }
        });
    }

    // Relaciones
    public function tipo(): BelongsTo
    {
        return $this->belongsTo(WorkOrderType::class, 'work_order_type_id');
    }

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculo_id')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tecnico_id')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class)
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function mantenimiento(): BelongsTo
    {
        return $this->belongsTo(Mantenimiento::class)
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function presupuesto(): BelongsTo
    {
        return $this->belongsTo(Presupuestos::class, 'presupuesto_id')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function deviceHistory(): HasMany
    {
        return $this->hasMany(DeviceHistory::class);
    }

    public function checklists(): HasMany
    {
        return $this->hasMany(WorkOrderChecklist::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(WorkOrderPhoto::class);
    }

    public function signatures(): HasMany
    {
        return $this->hasMany(WorkOrderSignature::class);
    }

    public function accessories(): HasMany
    {
        return $this->hasMany(WorkOrderAccessory::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(WorkOrderItem::class)->orderBy('orden')->orderBy('id');
    }

    // Scopes
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    public function scopePendientes($query)
    {
        return $query->where('estado', WorkOrderStatus::PENDIENTE);
    }

    public function scopeEnProceso($query)
    {
        return $query->where('estado', WorkOrderStatus::EN_PROCESO);
    }

    public function scopeFinalizadas($query)
    {
        return $query->where('estado', WorkOrderStatus::FINALIZADO);
    }

    public function scopeTecnico($query, $tecnicoId)
    {
        return $query->where('tecnico_id', $tecnicoId);
    }

    // URL pública de verificación en talentus-web
    public function verificationUrl(): string
    {
        $base = config('app.talentus_web_url', 'https://talentus.pe');
        return rtrim($base, '/') . '/verificar-orden/' . $this->verification_hash;
    }

    // Métodos de negocio
    public function iniciar(): void
    {
        if ($this->estado !== WorkOrderStatus::PENDIENTE) {
            throw new \Exception('Solo se pueden iniciar órdenes pendientes');
        }

        $this->estado = WorkOrderStatus::EN_PROCESO;
        $this->fecha_inicio = now();
        $this->save();
    }

    public function finalizar(): void
    {
        if ($this->estado !== WorkOrderStatus::EN_PROCESO) {
            throw new \Exception('Solo se pueden finalizar órdenes en proceso');
        }

        // Validar que tenga firma de conformidad
        if (!$this->signatures()->where('tipo', 'conformidad')->exists()) {
            throw new \Exception('Se requiere la firma de conformidad del cliente');
        }

        $this->estado = WorkOrderStatus::FINALIZADO;
        $this->fecha_finalizacion = now();
        $this->save();

        // Marcar el mantenimiento vinculado como completado
        if ($this->mantenimiento_id) {
            $this->mantenimiento()->update(['estado' => 'COMPLETADA']);
        }
    }

    public function cerrar(): void
    {
        if ($this->estado !== WorkOrderStatus::FINALIZADO) {
            throw new \Exception('Solo se pueden cerrar órdenes finalizadas');
        }

        $this->bloqueado = true;
        $this->fecha_cerrado = now();
        $this->save();
    }

    public function cancelar(string $motivo): void
    {
        if ($this->bloqueado) {
            throw new \Exception('No se puede cancelar una orden bloqueada');
        }

        $this->estado = WorkOrderStatus::CANCELADO;
        $this->motivo_cancelacion = $motivo;
        $this->bloqueado = true;
        $this->save();
    }

    public function puedeEditar(): bool
    {
        return !$this->bloqueado && $this->estado->canEdit();
    }
}
