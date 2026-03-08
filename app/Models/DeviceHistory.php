<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\DeviceHistoryObserver;

#[ObservedBy(DeviceHistoryObserver::class)]
class DeviceHistory extends Model
{
    use HasFactory;

    protected $table = 'device_history';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha_instalacion' => 'datetime',
        'fecha_retiro' => 'datetime',
        'metadata' => 'array',
    ];

    // Relaciones
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculos::class)
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function dispositivo(): BelongsTo
    {
        return $this->belongsTo(Dispositivos::class, 'dispositivo_id')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function simCard(): BelongsTo
    {
        return $this->belongsTo(SimCard::class, 'sim_card_id')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function dispositivoAnterior(): BelongsTo
    {
        return $this->belongsTo(Dispositivos::class, 'dispositivo_anterior_id')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function simCardAnterior(): BelongsTo
    {
        return $this->belongsTo(SimCard::class, 'sim_card_anterior_id')
            ->withoutGlobalScope(EmpresaScope::class);
    }

    // Scopes
    public function scopeVehiculo($query, $vehiculoId)
    {
        return $query->where('vehiculo_id', $vehiculoId);
    }

    public function scopeInstalaciones($query)
    {
        return $query->whereIn('accion_imei', ['instalado', 'reemplazado'])
            ->orWhereIn('accion_sim', ['instalado', 'reemplazado']);
    }

    public function scopeRetiros($query)
    {
        return $query->where('accion_imei', 'retirado')
            ->orWhere('accion_sim', 'retirado');
    }
}
