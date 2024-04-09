<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Clientes extends Model
{
    use HasFactory;
    use Notifiable;
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
    protected $table = 'clientes';
    // SCOPE DE EMPRESA


    protected $casts = [
        'id' => 'integer',
        'deleted_at' => 'date',
    ];

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }

    // Scope local de activo
    public function scopeTipoDoc($query, $tipo)
    {
        return $query->where('tipo_documento_id', $tipo);
    }
    //relacion uno a muchos

    public function presupuestos()
    {
        return $this->hasMany(Presupuestos::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion uno a muchos
    public function facturas()
    {
        return $this->hasMany(Facturas::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion uno a muchos
    public function recibos()
    {
        return $this->hasMany(Recibos::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
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


    public function vehiculos(): HasMany
    {
        return $this->hasMany(Vehiculos::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }


    //Relacion uno a muchos inversa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }


    public function certificados()
    {
        return $this->hasMany(Certificados::class, 'certificados_id');
    }


    //relacion uno a muchos contactos

    public function contactos()
    {
        return $this->hasMany(Contactos::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion uno a muchos

    public function cobros()
    {
        return $this->hasMany(Cobros::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function tareas()
    {

        return $this->hasMany(Tareas::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function tipoDocumento(): HasOne
    {
        return $this->hasOne(TipoDocumento::class, 'codigo', 'tipo_documento_id');
    }
}
