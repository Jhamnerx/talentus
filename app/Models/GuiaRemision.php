<?php

namespace App\Models;

use App\Enums\ModalidadTraslado;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuiaRemision extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guia_remision';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'fecha_emision' => 'date:Y/m/d',
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


    public static function createItems($guia, $items)
    {
        foreach ($items as $item) {

            $item['guia_remision_id'] = $guia->id;

            $guia->detalles()->create($item);
        }
    }
}
