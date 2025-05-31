<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Scopes\EmpresaScope;
use App\Scopes\EliminadoScope;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\PresupuestosStatus;
use Spatie\Activitylog\LogOptions;
use App\Observers\PresupuestosObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Notifications\Ventas\EnviarPresupuestoCliente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(PresupuestosObserver::class)]
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
        'clientes_id' => 'integer',
        'fecha' => 'date:Y/m/d',
        'fecha_caducidad' => 'date:Y/m/d',
        'tipo_cambio' => 'decimal:2',
        'metodo_pago_id' => 'string',
        'op_gravadas' => 'decimal:2',
        'op_exoneradas' => 'decimal:2',
        'op_inafectas' => 'decimal:2',
        'op_gratuitas' => 'decimal:2',
        'igv_op' => 'decimal:2',
        'descuento' => 'decimal:2',

        'op_gravadas_soles' => 'decimal:2',
        'op_exoneradas_soles' => 'decimal:2',
        'op_inafectas_soles' => 'decimal:2',
        'op_gratuitas_soles' => 'decimal:2',
        'descuento_soles' => 'decimal:2',

        'descuento_factor' => 'decimal:5',
        'icbper' => 'decimal:2',
        'igv' => 'decimal:2',
        'igv_soles' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'sub_total_soles' => 'decimal:2',
        'total' => 'decimal:2',
        'total_soles' => 'decimal:2',
        'user_id' => 'integer',
        'viewed' => 'boolean',
        'sent' => 'boolean',
        'vence_cuotas' => 'integer',
        'detalle_cuotas' => AsCollection::class,
        'estado' => PresupuestosStatus::class,
        'terminos' => AsCollection::class,
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


    public static function createItems(Presupuestos $presupuesto, $items)
    {


        foreach ($items as $item) {

            $item['presupuestos_id'] = $presupuesto->id;

            $item = $presupuesto->detalles()->create($item);
        }


        return $presupuesto->detalles;
    }

    public function getPDFData($action)
    {

        $plantilla = plantilla::first();

        view()->share([
            'presupuesto' => $this,
            'plantilla' => $plantilla,
        ]);


        //return view('pdf.presupuesto.pdf-new');
        //ANTIGUA VERSION CON NUMERO
        if ($this->numero) {

            $pdf = PDF::loadView('pdf.presupuesto.pdf')->setPaper('Legal')->setOption(['isHtml5ParserEnabled' => false]);
            if ($action == 1) {

                return $pdf->download('PRE-' . $this->numero . '.pdf');
            } else {
                return $pdf->stream('PRE-' . $this->numero . '.pdf');
            };
        }
        //NUEVA VERSION CON DATOS ADICIONALES
        else {

            $pdf = PDF::loadView('pdf.presupuesto.pdf-new')->setPaper('Legal');

            if ($action == 1) {

                return $pdf->download($this->serie_correlativo . '.pdf');
            } else {
                return $pdf->stream($this->serie_correlativo . '.pdf');
            };
        }
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

        if ($this->numero) {
            $pdf = PDF::loadHTML(view('pdf.presupuesto.pdf'))->setPaper('Legal');
        } else {

            $pdf = PDF::loadHTML(view('pdf.presupuesto.pdf-new'))->setPaper('Legal');
        }

        $this->clientes->notify(new EnviarPresupuestoCliente($this, $pdf, $data));
    }


    public function factura()
    {
        return $this->hasOne(Facturas::class, 'presupuestos_id');
    }

    public function invoice()
    {
        return $this->hasOne(Ventas::class, 'presupuestos_id');
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
