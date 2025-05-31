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
        // 1) Cargar relaciones y datos
        $this->load([
            'vehiculo.cliente',
            'vehiculo.dispositivoPrincipal.dispositivo.modelo',
            'ciudades'
        ]);

        $plantilla = plantilla::first();
        $fondo     = $plantilla->img_documentos;
        $sello     = $plantilla->img_firma;

        view()->share([
            'acta'      => $this,
            'plantilla' => $plantilla,
            'fondo'     => $fondo,
            'sello'     => $sello,
        ]);

        // 2) Generar el PDF desde la vista
        $pdf = PDF::loadView('pdf.acta');

        // 3) Acceder al canvas y al CPDF de dompdf
        $canvas = $pdf->getDomPDF()->get_canvas();
        $cpdf   = $canvas->get_cpdf();

        // 4) Agregar metadatos
        $cpdf->addInfo('Author',   'Talentus Technology E.I.R.L.');
        $cpdf->addInfo('Subject',  'Acta de instalación de equipo GPS');
        $cpdf->addInfo('Keywords', 'GPS,Acta,Instalación,Talentus');
        // Opcionalmente también:
        $cpdf->addInfo('Title',    'ACTA ' . $this->vehiculo->placa . ' ' . $this->codigo);
        $cpdf->addInfo('Creator',  env('APP_NAME', 'Talentus GPS'));
        // Producer normalmente ya lo pone dompdf, puedes sobreescribirlo:


        // 5) Enviar al navegador
        return $pdf->stream('ACTA-' . $this->vehiculo->placa . ' ' . $this->codigo . '.pdf');
    }
    public function getPDFDataToMail($data)
    {
        // Cargar relaciones necesarias para el PDF
        $this->load(['vehiculo.cliente', 'vehiculo.dispositivoPrincipal.dispositivo.modelo', 'ciudades']);

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
