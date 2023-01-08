<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComprasFacturas extends Model
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

    protected $table = 'compras_factura';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'numero' => 'string',
        'divisa' => 'string',
        'fecha_emision' => 'date:Y/m/d',


    ];




    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    //Relacion uno a muchos inversa

    public function proveedores()
    {
        return $this->belongsTo(Proveedores::class, 'proveedores_id')->withoutGlobalScope(EliminadoScope::class);
    }

    public function detalles()
    {
        return $this->hasMany(DetalleFacturasCompras::class, 'facturas_id');
    }


    public static function createItems($factura, $items)
    {
        foreach ($items as $item) {

            $item['facturas_id'] = $factura->id;

            $factura->detalles()->create($item);
        }
    }
}
