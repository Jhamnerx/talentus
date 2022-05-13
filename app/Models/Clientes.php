<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'clientes';
    // SCOPE DE EMPRESA


    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
        static::addGlobalScope(new EliminadoScope);
        //static::addGlobalScope(new ActiveScope);
    }


    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }
    //relacion uno a muchos

    public function presupuestos()
    {
        return $this->hasMany(Presupuestos::class, 'clientes_id');
    }

    //relacion uno a muchos

    public function ventas()
    {
        return $this->hasMany(VentasFacturas::class, 'clientes_id');
    }
    //relacion uno a muchos

    public function recibos()
    {
        return $this->hasMany(Recibos::class, 'clientes_id');
    }
    //relacion uno a muchos

    public function contratos()
    {
        return $this->hasMany(Contratos::class, 'clientes_id');
    }

    //relacion uno a muchos

    public function flotas()
    {
        return $this->hasMany(Flotas::class, 'clientes_id');
    }
    //Relacion uno a muchos inversa

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id')->withoutGlobalScope(EliminadoScope::class);
    }


    public function certificados()
    {
        return $this->hasMany(Certificados::class, 'certificados_id');
    }
}
