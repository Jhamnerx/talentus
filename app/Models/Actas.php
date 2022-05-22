<?php

namespace App\Models;

use App;
use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class Actas extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    use HasFactory;

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
        static::addGlobalScope(new EmpresaScope);
    }


    public function getPDFData()
    {



        // dd($this);

        $plantilla = plantilla::find(session('empresa'));
        view()->share([
            'acta' => $this,
            'plantilla' => $plantilla,

        ]);

        $pdf = PDF::loadView('pdf.acta');
        return $pdf->stream('ACTA-' . $this->vehiculos->placa . ' ' . $this->codigo);
        //return $pdf;
        //  return view('pdf.acta');

    }
}
