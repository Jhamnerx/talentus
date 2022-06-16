<?php

namespace App\Models;

use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;

class Contratos extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'contratos';

    protected $casts = [
        'sello' => 'boolean',
        'fondo' => 'boolean',
        'estado' => 'boolean',
        'eliminado' => 'boolean',
    ];

    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
        static::addGlobalScope(new EliminadoScope);
    }
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withoutGlobalScope(EliminadoScope::class, ActiveScope::class);
    }


    public function ciudades()
    {
        return $this->belongsTo(Ciudades::class, 'ciudades_id')->withoutGlobalScope(EliminadoScope::class);
    }

    //relacion uno a muchos

    public function detalle()
    {
        return $this->hasMany(DetalleContratos::class, 'contratos_id');
    }


    //relacion uno a muchos

    public function vehiculos()
    {
        return $this->belongsToMany(Vehiculos::class, 'detalle_contratos');
    }

    public static function createItems($contrato, $contratoItems)
    {
        foreach ($contratoItems as $contratoItem) {

            $contratoItem['contratos_id'] = $contrato->id;

            $item = $contrato->detalle()->create($contratoItem);
        }
    }


    public function getPDFData()
    {

        $plantilla = plantilla::where('empresas_id', session('empresa'))->first();;
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'contrato' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,

        ]);

        $pdf = PDF::loadView('pdf.contrato');

        return $pdf->stream('CONTRATO-' . $this->clientes->razon_social . '.pdf');


        //return $pdf;
        //return view('pdf.acta');
    }
}
