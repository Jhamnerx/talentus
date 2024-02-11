<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehiculos extends Model
{
    use HasFactory;
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
    protected $table = 'vehiculos';

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    protected function placa(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => strtoupper($value),
        );
    }
    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }

    public function scopeWhereCompany($query)
    {
        return $query->where('vehiculos.empresa_id', session('empresa'));
    }

    // Scope local de activo
    public function order($query, $order)
    {
        return $query->orderBy($order, 'desc');
    }

    //Relacion uno a muchos inversa
    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    //relacion uno a muchos a modelos
    public function sim_card()
    {
        return $this->belongsTo(SimCard::class, 'sim_card_id');
    }

    //relacion uno a muchos a dispositivos
    public function dispositivos()
    {
        return $this->belongsTo(Dispositivos::class);
    }

    //relacion uno a muchos a reportes
    public function reportes()
    {
        return $this->hasMany(Reportes::class, 'vehiculos_id');
    }

    //relacion uno a muchos a actas
    public function actas()
    {
        return $this->hasMany(Actas::class, 'vehiculos_id');
    }

    //relacion uno a muchos a actas
    public function certificados()
    {
        return $this->hasMany(Certificados::class, 'vehiculos_id');
    }

    //relacion uno a muchos a actas
    public function cert_velocimetros()
    {
        return $this->hasMany(CertificadosVelocimetros::class, 'vehiculos_id');
    }

    //Relacion muchos a ,muchos
    public function detalle_contrato()
    {
        return $this->hasMany(DetalleContratos::class, 'vehiculos_id')->withTrashed();
    }


    //Relacion muchos a ,muchos
    public function contratos()
    {
        return $this->belongsToMany(Contratos::class);
    }

    //relacion uno a muchos
    public function cobros()
    {
        return $this->hasMany(Cobros::class, 'vehiculos_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function flotas()
    {
        return $this->belongsToMany(Flotas::class, 'vehiculos_flotas', 'vehiculos_id', 'flotas_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function tareas()
    {

        return $this->hasMany(Tareas::class, 'vehiculo_id')->withoutGlobalScope(EmpresaScope::class);
    }


    public function mantenimientos()
    {
        return $this->hasMany(Mantenimiento::class, 'vehiculo_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function numero()
    {
        return $this->hasOne(Lineas::class, 'numero', 'numero')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }
}
