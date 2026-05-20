<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrderItem extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'orden' => 'integer',
    ];

    // Tipos de trabajo disponibles
    const TIPOS_TRABAJO = [
        'instalacion'   => 'Instalación',
        'mantenimiento' => 'Mantenimiento',
        'cambio_chip'   => 'Cambio de chip',
        'retiro'        => 'Retiro de equipo',
        'otro'          => 'Otro',
    ];

    // Estados disponibles
    const ESTADOS = [
        'pendiente'   => 'Pendiente',
        'completado'  => 'Completado',
        'omitido'     => 'Omitido',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function vehiculo(): BelongsTo
    {
        return $this->belongsTo(Vehiculos::class)
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class)
            ->withoutGlobalScope(EmpresaScope::class);
    }

    public function tipo(): BelongsTo
    {
        return $this->belongsTo(WorkOrderType::class, 'work_order_type_id');
    }

    public function esPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    public function esCompletado(): bool
    {
        return $this->estado === 'completado';
    }

    public function esOmitido(): bool
    {
        return $this->estado === 'omitido';
    }

    public function labelTipoTrabajo(): string
    {
        return $this->tipo?->nombre ?? self::TIPOS_TRABAJO[$this->tipo_trabajo] ?? ucfirst((string) $this->tipo_trabajo);
    }
}
