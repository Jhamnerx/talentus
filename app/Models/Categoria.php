<?php

namespace App\Models;


use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    protected static $recordEvents = ['deleted', 'created', 'updated'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['deleted_at']);
        // Chain fluent methods for configuration options
    }

    protected $table = 'categorias';

    //GLOBAL SCOPE EMPRESA
    // protected static function booted()
    // {
    //     static::addGlobalScope(new EmpresaScope);
    // }

    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }

    //relacion uno a muchos

    public function productos()
    {
        return $this->hasMany(Productos::class, 'categoria_id');
    }

    public function changes()
    {

        return $this->morphMany(ChangesModels::class, 'changes');
    }

    public function cambios()
    {
        return $this->hasMany(ChangesModels::class, 'change_id');
    }

    public function getKey()
    {
        return $this->id;
    }
}
