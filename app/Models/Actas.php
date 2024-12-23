<?php

namespace App\Models;

use App;
use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use App\Observers\ActasObserver;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\Certificados\EnviarActaCliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ActasObserver::class)]
class Actas extends Model
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
            ->logOnlyDirty();
        // Chain fluent methods for configuration options
    }
    protected $table = 'actas';

    protected $casts = [
        'sello' => 'boolean',
        'fondo' => 'boolean',
        'estado' => 'boolean',
        'fecha_instalacion' => 'date:Y/m/d',
        'inicio_cobertura' => 'date:Y/m/d',
        'fin_cobertura' => 'date:Y/m/d',
        'eliminado' => 'boolean',
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

    //Relacion uno a muchos inversa

    public function ciudades()
    {
        return $this->belongsTo(Ciudades::class, 'ciudades_id')->withTrashed();
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }
    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withTrashed()->withoutGlobalScope(EmpresaScope::class);
    }

    public function getPDFData()
    {

        $plantilla = plantilla::first();
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'acta' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,

        ]);


        $pdf = PDF::loadView('pdf.acta');

        return $pdf->stream('ACTA-' . $this->vehiculo->placa . ' ' . $this->codigo . '.pdf');
        //return $pdf;
        //return view('pdf.acta');
    }

    public function getPDFDataToMail($data)
    {
        $plantilla = plantilla::first();
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'acta' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,
        ]);

        $pdf = PDF::loadView('pdf.acta');

        $this->vehiculo->cliente->notify(new EnviarActaCliente($this, $pdf, $data));
    }
}
