<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Enums\ModalidadTraslado;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuiaRemision extends Model
{
    use HasFactory, SoftDeletes;
    use LogsActivity;
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
    protected $table = 'guia_remision';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha_emision' => 'date:Y/m/d',
        'fecha_inicio_traslado' => 'date:Y/m/d',
        'modalidad_traslado' => ModalidadTraslado::class,
    ];
    //GLOBAL SCOPE EMPRESA
    // protected static function booted()
    // {
    //     static::addGlobalScope(new EmpresaScope);
    // }

    //relacion uno a muchos

    public function detalles()
    {
        return $this->hasMany(detalleGuiaRemision::class, 'guia_remision_id');
    }

    public function motivo()
    {
        return $this->hasOne(MotivosTraslado::class, 'codigo', 'motivo_traslado');
    }

    public function dispositivos()
    {
        return $this->belongsToMany(Dispositivos::class, 'dispositivos_users', 'guia_remision_id', 'imei', null, 'imei')->withoutGlobalScope(EmpresaScope::class);
    }

    //Relacion uno a muchos inversa

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function factura()
    {
        return $this->belongsTo(Facturas::class, 'factura_id');
    }

    public static function createItems($guia, $items)
    {
        foreach ($items as $item) {

            $item['guia_remision_id'] = $guia->id;

            $guia->detalles()->create($item);
        }
    }
}
