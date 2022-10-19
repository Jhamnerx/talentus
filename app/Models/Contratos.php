<?php

namespace App\Models;

use App\Notifications\Ventas\EnviarContratoCliente;
use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contratos extends Model
{
    use HasFactory, SoftDeletes;
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
        //
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

    public function cobros()
    {
        return $this->hasOne(Cobros::class, 'contratos_id');
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

        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();;
        $fondo = $plantilla->fondo_contrato;
        $sello = $plantilla->img_firma;
        view()->share([
            'contrato' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,

        ]);

        $pdf = PDF::loadView('pdf.contrato.pdf');

        return $pdf->stream('CONTRATO-' . $this->clientes->razon_social . '.pdf');

        // return view('pdf.contrato.pdf');
    }

    public function getPDFDataToMail($data)
    {

        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();

        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'contrato' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,

        ]);

        $pdf = PDF::loadView('pdf.contrato.pdf');

        $this->clientes->notify(new EnviarContratoCliente($this, $pdf, $data));
    }
}
