<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Database\Factories\CertificadosVelocimetrosFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificadosVelocimetros extends Model
{
    //Definir Factory

    protected static function newFactory()
    {
        return CertificadosVelocimetrosFactory::new();
    }

    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'certificados_velocimetros';

    //Relacion uno a muchos inversa


    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withoutGlobalScope(EliminadoScope::class);
    }
    public function ciudades()
    {
        return $this->belongsTo(Ciudades::class, 'ciudades_id')->withoutGlobalScope(EliminadoScope::class);
    }

    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
    protected static function booted()
    {
        static::addGlobalScope(new EliminadoScope);
        static::addGlobalScope(new EmpresaScope);
    }


    public function getPDFData()
    {

        $plantilla = plantilla::find(session('empresa'));
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'certificado' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,

        ]);

        $pdf = PDF::loadView('pdf.certificado-velocimetro');

        return $pdf->stream('CERTIFICADO VELOCIMETRO-' . $this->vehiculos->placa . ' ' . $this->codigo . '.pdf');


        //return $pdf;
        //return view('pdf.acta');
    }
}
