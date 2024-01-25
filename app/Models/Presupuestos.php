<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\PresupuestosStatus;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Notifications\Ventas\EnviarPresupuestoCliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Presupuestos extends Model
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

    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'presupuestos';

    protected $casts = [
        'fecha' => 'date:Y/m/d',
        'fecha_caducidad' => 'date:Y/m/d',
        'estado' => PresupuestosStatus::class,
    ];

    /**
     * Scope para traer activos y no
     *
     * eliminados
     */
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }


    // Scope local de estado
    public function scopeEstado($query, string $status)
    {
        return $query->where('estado', $status);
    }
    public function scopePendiente($query)
    {
        return $query->where('estado', '0');
    }
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id');
    }

    //relacion uno a muchos

    public function detalles()
    {
        return $this->hasMany(DetallePresupuestos::class, 'presupuestos_id');
    }


    public static function createItems($presupuesto, $items)
    {

        foreach ($items as $item) {

            $item['presupuestos_id'] = $presupuesto->id;

            $item = $presupuesto->detalles()->create($item);
        }
    }

    public function getPDFData($action)
    {

        $plantilla = plantilla::first();
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'presupuesto' => $this,
            'plantilla' => $plantilla,
        ]);

        $pdf = PDF::loadView('pdf.presupuesto.pdf')->setPaper('Legal');

        if ($action == 1) {

            return $pdf->download('PRE-' . $this->numero . '.pdf');
        } else {
            return $pdf->stream('PRE-' . $this->numero . '.pdf');
        };
    }
    public function getPDFDataToMail($data)
    {

        $plantilla = plantilla::first();
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;

        view()->share([
            'presupuesto' => $this,
            'plantilla' => $plantilla,
        ]);

        $pdf = PDF::loadView('pdf.presupuesto.pdf')->setPaper('Legal');

        //$this->clientes->notify(new EnviarPresupuestoCliente($this, $pdf, $data));
        $this->clientes->notify(new EnviarPresupuestoCliente($this, $pdf, $data));
    }


    public function factura()
    {
        return $this->hasOne(Facturas::class, 'presupuestos_id');
    }
    public function recibo()
    {
        return $this->hasOne(Recibos::class, 'presupuestos_id');
    }

    public function getSerie(): BelongsTo
    {
        return $this->belongsTo(Series::class, 'serie', 'serie');
    }

    public function tipoComprobante(): BelongsTo
    {
        return $this->belongsTo(\App\Models\TipoComprobantes::class, 'tipo_comprobante_id', 'codigo');
    }
}
