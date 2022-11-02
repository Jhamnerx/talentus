<?php

namespace App\Models;

use App\Models\Empresa;
use App\Models\Productos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'empresa_id'];

    protected $primaryKey = 'codigo';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;


    public function productos()
    {
        return $this->hasMany(Productos::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function scopeWhereCompany($query)
    {
        $query->where('empresa_id', request()->header('company'));
    }

    public function scopeWhereUnit($query, $unit_id)
    {
        $query->orWhere('id', $unit_id);
    }

    public function scopeWhereSearch($query, $search)
    {
        return $query->where('name', 'LIKE', '%' . $search . '%');
    }
}
