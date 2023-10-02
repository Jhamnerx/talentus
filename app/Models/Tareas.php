<?php

namespace App\Models;

use App\Enums\TareasStatus;
use App\Scopes\EmpresaScope;
use App\Scopes\OnlyTareas;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Barryvdh\DomPDF\Facade\Pdf;

class Tareas extends Model
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
    protected $table = 'tareas';

    protected $casts = [

        'estado' => TareasStatus::class,
        'fecha_hora' => 'datetime',
        'fecha_termino' => 'datetime',
        'fecha_validacion' => 'datetime',
        'respuesta' => 'boolean',
    ];


    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
        static::addGlobalScope(new OnlyTareas);
    }

    //relacion con tipo de tareas

    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }


    public function tipo_tarea()
    {
        return $this->belongsTo(tipoTareas::class, 'tipo_tarea_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id')->withoutGlobalScope(EmpresaScope::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(User::class, 'tecnico_id')->withoutGlobalScope(EmpresaScope::class);
    }

    //Relacion uno A UNO POLIMORFICA IMAGEN
    public function image()
    {
        return $this->morphOne(Imagen::class, 'imageable')->withoutGlobalScope(EmpresaScope::class);
    }


    public function mantenimiento()
    {
        return $this->belongsTo(Mantenimiento::class, 'mantenimiento_id');
    }


    public function informe()
    {
        return $this->hasOne(InformeTareas::class, 'tarea_id')->withoutGlobalScope(EmpresaScope::class);
    }


    public function getPDFData()
    {
        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();
        $fondo = $plantilla->fondo_contrato;
        $sello = $plantilla->img_firma;
        view()->share([
            'tarea' => $this,
            'fondo' => $fondo,
            'plantilla' => $plantilla,
        ]);

        $pdf = PDF::loadView('pdf.reportes.tarea');
        //return view('pdf.reportes.tarea');
        return $pdf->stream('REPORTE TAREA ' . $this->token . '.pdf');
    }
}
