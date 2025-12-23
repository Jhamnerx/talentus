<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class WorkOrderPhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'size' => 'integer',
    ];

    // Relaciones
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function checklist(): BelongsTo
    {
        return $this->belongsTo(WorkOrderChecklist::class, 'work_order_checklist_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function getFullPathAttribute(): string
    {
        return Storage::disk($this->disk)->path($this->path);
    }

    // Scopes
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeFase($query, $fase)
    {
        return $query->where('fase', $fase);
    }

    // Métodos auxiliares
    public function eliminarArchivo(): void
    {
        if (Storage::disk($this->disk)->exists($this->path)) {
            Storage::disk($this->disk)->delete($this->path);
        }
    }

    // Event hooks
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($photo) {
            $photo->eliminarArchivo();
        });
    }
}
