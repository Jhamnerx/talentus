<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivos extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'dispositivos';


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }
    //Relacion uno a muchos inversa

    public function modelo()
    {
        return $this->belongsTo(ModelosDispositivo::class, 'modelo_id');
    }
    public function vehiculos()
    {
        return $this->hasOne(Vehiculos::class)->withoutGlobalScope(EliminadoScope::class)->withoutGlobalScope(EliminadoScope::class);
    }
    public function certificados()
    {
        return $this->hasMany(Certificados::class, 'dispositivos_id');
    }
}
