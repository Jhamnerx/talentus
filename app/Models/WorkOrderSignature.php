<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class WorkOrderSignature extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'firmado_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relaciones
    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function tecnico(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tecnico_id');
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

    public function scopeRecepcion($query)
    {
        return $query->where('tipo', 'recepcion');
    }

    public function scopeConformidad($query)
    {
        return $query->where('tipo', 'conformidad');
    }

    // Métodos auxiliares
    public function verificarIntegridad(): bool
    {
        if (!$this->hash) {
            return false;
        }

        $contenido = Storage::disk($this->disk)->get($this->path);
        return hash('sha256', $contenido) === $this->hash;
    }

    public function generarHash(): void
    {
        $contenido = Storage::disk($this->disk)->get($this->path);
        $this->hash = hash('sha256', $contenido);
        $this->save();
    }

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

        static::created(function ($signature) {
            // Generar hash automáticamente al crear
            if (!$signature->hash) {
                $signature->generarHash();
            }
        });

        static::deleting(function ($signature) {
            $signature->eliminarArchivo();
        });
    }
}
