<?php

namespace App\Models;

use App\Models\Admin\Recordatorios;
use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reportes extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'reportes';


    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    //relacion uno a muchos

    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withTrashed();
    }


    //relacion uno a muchos

    public function detalle()
    {
        return $this->hasMany(DetalleReportes::class, 'reportes_id');
    }

    public function recordatorios()
    {
        return $this->hasMany(Recordatorios::class, 'reportes_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
}
