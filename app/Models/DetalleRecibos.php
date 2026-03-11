<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleRecibos extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalle_recibos';
    protected $casts = [
        'cantidad' => 'float',
        'imeis' => 'array',
    ];

    public function recibos(): BelongsTo
    {
        return $this->belongsTo(Recibos::class, 'recibos_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Productos::class, 'producto_id')->withTrashed();
    }
}
