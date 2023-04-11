<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\CertificadosVelocimetrosFactory;
use App\Notifications\Certificados\EnviarCertificadoVelocimetroCliente;

class CertificadosVelocimetros extends Model
{
    //Definir Factory

    protected static function newFactory()
    {
        return CertificadosVelocimetrosFactory::new();
    }

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
    protected $table = 'certificados_velocimetros';

    protected $casts = [
        'sello' => 'boolean',
        'fondo' => 'boolean',
        'estado' => 'boolean',
    ];

    //Relacion uno a muchos inversa
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withoutGlobalScope(EliminadoScope::class)->withTrashed();
    }
    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withoutGlobalScope(EliminadoScope::class)->withTrashed();
    }
    public function ciudades()
    {
        return $this->belongsTo(Ciudades::class, 'ciudades_id')->withoutGlobalScope(EliminadoScope::class);
    }

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    public function getPDFData()
    {

        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();;
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'certificado' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,

        ]);

        $pdf = PDF::loadView('pdf.certificado-velocimetro');

        return $pdf->stream('CERTIFICADO VELOCIMETRO-' . $this->vehiculo->placa . ' ' . $this->codigo . '.pdf');
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


        $pdf = PDF::loadView('pdf.certificado-velocimetro');

        $this->vehiculo->cliente->notify(new EnviarCertificadoVelocimetroCliente($this, $pdf, $data));
    }
}
