<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plantilla extends Model
{
    use HasFactory;
    protected $table = 'plantilla';

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function getSerieFacturaAttribute($value)
    {
        return $value;
    }
}
