<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Productos extends Model
{
    use HasFactory;
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
    protected $table = 'productos';

    protected $guarded = ['id', 'created_at', 'updated_at'];


    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeVelocimetro($query)
    {
        return $query->whereHas('categoria', function ($query) {
            $query->where('nombre', 'like', '%VELOCIMETROS DIGITALES%');
        });
    }

    // GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    //Relacion uno a muchos inversa

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id')->withTrashed();
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_code');
    }


    //Relacion uno a muchos inversa

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    //Relacion uno A UNO POLIMORFICA

    public function image()
    {

        return $this->morphOne(Imagen::class, 'imageable');
    }


    public function detalle_facturas()
    {

        return  $this->hasMany(DetalleFacturas::class, 'producto_id');
    }
    public function detalle_recibos()
    {

        return  $this->hasMany(DetalleRecibos::class, 'producto_id');
    }
}
