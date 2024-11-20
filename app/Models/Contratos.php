<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Activitylog\LogOptions;
use App\Observers\ContratosObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\Ventas\EnviarContratoCliente;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(ContratosObserver::class)]
class Contratos extends Model
{
    use HasFactory, SoftDeletes;
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
    protected $table = 'contratos';

    protected $casts = [
        'sello' => 'boolean',
        'fondo' => 'boolean',
        'estado' => 'boolean',
        'fecha' => 'date:Y/m/d',
        'fecha_emision' => 'date:Y/m/d',
        'eliminado' => 'boolean',
    ];


    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }
    //Relacion uno a muchos inversa

    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id');
    }


    public function ciudades()
    {
        return $this->belongsTo(Ciudades::class, 'ciudades_id');
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



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function createItems($contrato, $contratoItems)
    {
        foreach ($contratoItems as $contratoItem) {

            $contratoItem['contratos_id'] = $contrato->id;

            $item = $contrato->detalle()->create($contratoItem);
        }
    }

    public function periodo()
    {
        return $this->fecha_emision->subDay(2)->diffInMonths($this->fecha);
    }

    public function getPDFData()
    {

        $plantilla = plantilla::first();
        $fondo = $plantilla->fondo_contrato;
        $sello = $plantilla->img_firma;
        view()->share([
            'contrato' => $this,
            'plantilla' => $plantilla,
            'fondo' => $fondo,
            'sello' => $sello,

        ]);

        $pdf = PDF::loadView('pdf.contrato.pdf');

        return $pdf->stream('CONTRATO-' . $this->cliente->razon_social . '.pdf');

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

        $this->cliente->notify(new EnviarContratoCliente($this, $pdf, $data));
    }
}
