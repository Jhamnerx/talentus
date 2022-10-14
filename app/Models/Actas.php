<?php

namespace App\Models;

use App;
use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actas extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    use HasFactory;
    use SoftDeletes;

    protected $table = 'actas';



    /**
     * The attributes that should be cast.
     *
     * @var boolean
     */
    protected $casts = [
        'sello' => 'boolean',
        'fondo' => 'boolean',
        'estado' => 'boolean',
        'inicio_cobertura' => 'date:Y/m/d',
        'fin_cobertura' => 'date:Y/m/d',
        'eliminado' => 'boolean',
    ];

    // Scope local de activo
    public function scopeActive($query, $status)
    {
        return $query->where('is_active', $status);
    }

    //Relacion uno a muchos inversa

    public function ciudades()
    {
        return $this->belongsTo(Ciudades::class, 'ciudades_id')->withoutGlobalScope(EliminadoScope::class);
    }

    public function vehiculos()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculos_id')->withoutGlobalScope(EliminadoScope::class);
    }
    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
    protected static function booted()
    {
        static::addGlobalScope(new EliminadoScope);
        //
    }


    public function getPDFData()
    {

        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();;
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'acta' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,

        ]);

        $pdf = PDF::loadView('pdf.acta');

        return $pdf->stream('ACTA-' . $this->vehiculos->placa . ' ' . $this->codigo . '.pdf');


        //return $pdf;
        //return view('pdf.acta');
    }
}
