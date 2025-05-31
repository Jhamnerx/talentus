<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CertificadosAntifatiga extends Model
{
    use SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'certificados_antifatiga';

    protected $casts = [
        'sello' => 'boolean',
        'fondo' => 'boolean',
        'estado' => 'boolean',
        'cambiar_imei' => 'boolean',

    ];

    protected function cliente(): Attribute
    {

        return Attribute::make(
            get: fn($cliente) => json_decode($cliente, true),
            set: fn($cliente) => json_encode($cliente),
        );
    }
    //Relacion uno a muchos inversa
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculo_id')->withoutGlobalScope(EliminadoScope::class)->withTrashed();
    }

    public function ciudades()
    {
        return $this->belongsTo(Ciudades::class, 'ciudades_id')->withoutGlobalScope(EliminadoScope::class)->withTrashed();
    }

    public function dispositivo()
    {
        return $this->belongsTo(Dispositivos::class, 'dispositivo_id')->withoutGlobalScope(EliminadoScope::class)->withTrashed();
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

        $pdf = PDF::loadView('pdf.certificado-antifatiga');

        return $pdf->stream('CERTIFICADO ANTIFATIGA-' . $this->vehiculo->placa . ' ' . $this->codigo . '.pdf');
    }
}
