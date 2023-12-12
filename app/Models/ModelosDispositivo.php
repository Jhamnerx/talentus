<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelosDispositivo extends Model
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

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'modelos_dispositivos';

    protected $appends = ['porcentaje'];

    protected $casts = [
        'caracteristicas' => AsCollection::class,
    ];

    protected function porcentaje(): Attribute
    {

        $total = (int) $this->dispositivo()->empresa()->get()->count();
        $vendidos = (int) $this->dispositivo()->vendido()->empresa()->get()->count();

        if ($vendidos == 0) {
            $porcentaje = 0;
        } else {
            $porcentaje = number_format(($vendidos / $total) * 100, 2);
        }



        return new Attribute(
            get: fn () => $porcentaje,
        );
    }

    //relacion uno a muchos
    public function dispositivo()
    {
        return $this->hasMany(Dispositivos::class, 'modelo_id');
    }
    //Relacion uno A UNO POLIMORFICA

    public function image()
    {

        return $this->morphOne(Imagen::class, 'imageable');
    }
    public function vehiculos()
    {
        return $this->hasMany(Vehiculos::class, 'modelos_dispositivos_id');
    }
}
