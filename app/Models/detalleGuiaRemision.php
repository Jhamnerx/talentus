<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class detalleGuiaRemision extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'detalle_guia_remision';

    protected $casts = [
        'cantidad' => 'float',
    ];
    //Relacion uno a muchos inversa
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
    public function guias()
    {
        return $this->belongsTo(GuiaRemision::class, 'guia_remision_id');
    }
}
