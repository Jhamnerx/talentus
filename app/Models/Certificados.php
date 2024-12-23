<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Activitylog\LogOptions;
use App\Observers\CertificadosObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Notifications\Certificados\EnviarCertificadoCliente;

#[ObservedBy(CertificadosObserver::class)]
class Certificados extends Model
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
    protected $table = 'certificados';

    protected $casts = [
        'sello' => 'boolean',
        'fondo' => 'boolean',
        'estado' => 'boolean',
        'eliminado' => 'boolean',
        'year' => 'string',
        'accesorios' => AsCollection::class,
        'fecha_instalacion' => 'date:Y/m/d',
        'fin_cobertura' => 'date:Y/m/d',
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
        return $this->belongsTo(Ciudades::class, 'ciudades_id');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withoutGlobalScope(EmpresaScope::class);
    }
    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withoutGlobalScope(EmpresaScope::class);
    }

    public function getPDFData()
    {
        $plantilla = plantilla::first();
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;

        view()->share([
            'certificado' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,

        ]);

        $pdf = PDF::loadView('pdf.certificado');

        return $pdf->stream('CERTIFICADO-' . $this->vehiculo->placa . ' ' . $this->codigo . '.pdf');
        //return $pdf;
        //return view('pdf.acta');
    }

    public function getPDFDataToMail($data)
    {
        $plantilla = plantilla::first();
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;

        view()->share([
            'certificado' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,
        ]);


        $pdf = PDF::loadView('pdf.certificado');

        $this->vehiculo->cliente->notify(new EnviarCertificadoCliente($this, $pdf, $data));
    }
}
