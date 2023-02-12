<?php

namespace App\Models;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\mantenimientoStatus;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mantenimiento extends Model
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
    protected $table = 'mantenimientos';

    protected $casts = [
        'fecha_hora_mantenimiento' => 'date',
        'estado' => mantenimientoStatus::class,
    ];

    // pdf informe
    public function getPDFData()
    {

        $plantilla = plantilla::first();
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'mantenimiento' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'fecha' => Carbon::now(),
            'sello' => $sello,
        ]);

        $customPaper = array(0, 0, 792.00, 1224.00);

        $pdf = PDF::loadView('pdf.mantenimiento.informe')->setPaper('a4', 'landscape');
        //return view('pdf.mantenimiento.informe');

        return $pdf->stream('MANTENIMIENTO-' . $this->vehiculo->placa . ' ' . $this->numero . '.pdf');
    }

    //Relacion uno a muchos inversa
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculo_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tarea()
    {
        return $this->hasOne(Tareas::class, 'mantenimiento_id')->withoutGlobalScope(EmpresaScope::class);
    }
}
