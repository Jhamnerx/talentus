<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Activitylog\LogOptions;
use App\Models\DetalleRecibosPagos;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecibosPagosVarios extends Model
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

    public const COMPLETADO = 'COMPLETADO';
    public const BORRADOR = 'BORRADOR';

    public const PAID = 'PAID';
    public const UNPAID = 'UNPAID';


    public const PEN = 'PEN';
    public const USD = 'USD';

    protected $table = 'recibos_pagos';

    protected $casts = [
        'numero' => 'string',
        'fecha_emision' => 'date:Y/m/d',
        'fecha_pago' => 'date:Y/m/d',
    ];
    protected $guarded = ['id', 'created_at', 'updated_at'];



    //LOCAL SCOPES
    public function scopePaid($query)
    {
        return $query->where('pago_estado', '=', $this::PAID);
    }

    public function scopeUnPaid($query)
    {
        return $query->where('pago_estado', '=', $this::UNPAID);
    }

    public function scopeCompletado($query)
    {
        return $query->where('estado', '=', $this::COMPLETADO);
    }
    public function scopeBorrador($query)
    {
        return $query->where('estado', '=', $this::BORRADOR);
    }

    //GLOBAL SCOPES

    protected static function booted()
    {
        //
        static::addGlobalScope(new EmpresaScope);
    }


    public function getSerie(): BelongsTo
    {
        return $this->belongsTo(Series::class, 'serie', 'serie');
    }


    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id');
    }


    //relacion uno a muchos

    public function detalles()
    {
        return $this->hasMany(DetalleRecibosPagos::class, 'recibos_id');
    }

    public static function createItems($recibo, $reciboItems)
    {
        foreach ($reciboItems as $reciboItem) {

            $reciboItem['recibos_id'] = $recibo->id;

            $item = $recibo->detalles()->create($reciboItem);
        }
    }

    public function getPDFData($action)
    {

        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();

        view()->share([
            'recibo' => $this,
            'plantilla' => $plantilla,
        ]);

        $pdf = PDF::loadView('pdf.gerencia.recibo.pdf')->setPaper('Legal');

        if ($action == 1) {

            return $pdf->download('RECIBO ' . $this->serie . "-" . $this->numero . '.pdf');
        } else {

            return $pdf->stream('RECIBO ' . $this->serie . "-" . $this->numero . '.pdf');
        };
    }

    // public function getPDFDataToMail($data)
    // {

    //     $plantilla = plantilla::where('empresa_id', session('empresa'))->first();

    //     view()->share([
    //         'recibo' => $this,
    //         'plantilla' => $plantilla,
    //     ]);

    //     $pdf = PDF::loadView('pdf.gerencia.recibo.pdf');

    //     //$this->clientes->notify(new EnviarReciboCliente($this, $pdf, $data));
    // }
}
