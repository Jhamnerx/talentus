<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportes extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'reportes';

    //relacion uno a muchos

    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withoutGlobalScope(EliminadoScope::class);
    }


    //relacion uno a muchos

    public function detalle()
    {
        return $this->hasMany(DetalleReportes::class, 'reportes_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
    protected static function booted()
    {
        static::addGlobalScope(new EliminadoScope);
        static::addGlobalScope(new EmpresaScope);
    }
}
