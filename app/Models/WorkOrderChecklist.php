<?php

namespace App\Models;

use App\Enums\ChecklistResultado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderChecklist extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'resultado' => ChecklistResultado::class,
        'inspeccionado_at' => 'datetime',
    ];

    // Relaciones
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(ChecklistTemplate::class, 'checklist_template_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspeccionado_by');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(WorkOrderPhoto::class);
    }

    // Scopes
    public function scopeBefore($query)
    {
        return $query->where('fase', 'before');
    }

    public function scopeAfter($query)
    {
        return $query->where('fase', 'after');
    }

    public function scopeCompleto($query)
    {
        return $query->whereNotNull('resultado');
    }

    public function scopePendiente($query)
    {
        return $query->whereNull('resultado');
    }

    // Métodos auxiliares
    public function marcarComoOk(): void
    {
        $this->resultado = ChecklistResultado::OK;
        $this->inspeccionado_at = now();
        $this->inspeccionado_by = auth()->id();
        $this->save();
    }

    public function marcarComoObservado(string $observaciones): void
    {
        $this->resultado = ChecklistResultado::OBSERVADO;
        $this->observaciones = $observaciones;
        $this->inspeccionado_at = now();
        $this->inspeccionado_by = auth()->id();
        $this->save();
    }

    public function marcarComoNoAplica(): void
    {
        $this->resultado = ChecklistResultado::NO_APLICA;
        $this->inspeccionado_at = now();
        $this->inspeccionado_by = auth()->id();
        $this->save();
    }
}
