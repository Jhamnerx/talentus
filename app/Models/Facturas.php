<?php

namespace App\Models;

use App\Notifications\Ventas\EnviarFacturaCliente;
use App\Scopes\ActiveScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Support\Facades\Auth;

class Facturas extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const COMPLETADO = 'COMPLETADO';
    public const BORRADOR = 'BORRADOR';

    public const PAID = 'PAID';
    public const UNPAID = 'UNPAID';


    public const PEN = 'PEN';
    public const USD = 'USD';



    protected $table = 'facturas';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'numero' => 'string',
        'sequence_number' => 'integer',
        'fecha_emision' => 'date:Y/m/d',
        'fecha_vencimiento' => 'date:Y/m/d',
        'fecha_pago' => 'date:Y/m/d',
        'detalle_cuotas' => AsCollection::class,
    ];

    protected $attributes = [
        'empresa_id' => "session('empresa')",
        'user_id' => " Auth::user()->id",
    ];



    // protected function detalleCuotas(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => json_decode($value, true),
    //         set: fn ($value) => json_encode($value),
    //     );
    // }

    protected function empresaId(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => session('empresa'),
        );
    }
    protected function userId(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Auth::user()->id,
        );
    }

    //LOCAL SCOPES
    public function scopePaid($query)
    {
        return $query->where('pago_estado', '=', Facturas::PAID);
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

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withTrashed();
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuestos::class, 'presupuestos_id')->withTrashed();
    }

    public function getSerie()
    {
        return plantilla::get('serie')->where('empresa_id', session('empresa'));
    }

    //relacion uno a muchos

    public function detalles()
    {
        return $this->hasMany(DetalleFacturas::class, 'facturas_id');
    }

    public function guia()
    {
        return $this->hasMany(GuiaRemision::class, 'factura_id');
    }
    public function payments()
    {

        return $this->morphMany(Payments::class, 'paymentable');
    }



    public static function createItems($factura, $facturaItems)
    {
        foreach ($facturaItems as $facturaItem) {

            $facturaItem['facturas_id'] = $factura->id;

            $item = $factura->detalles()->create($facturaItem);
        }
    }
    public function getPDFData($action)
    {
        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'factura' => $this,
            'plantilla' => $plantilla,
        ]);

        $pdf = PDF::loadView('pdf.factura.pdf')->setPaper('Legal');

        if ($action == 1) {

            return $pdf->download('FACTURA ' . $this->serie . "-" . $this->numero . '.pdf');
        } else {

            return $pdf->stream('FACTURA ' . $this->serie . "-" . $this->numero . '.pdf');
        };
    }

    public function getPDFDataToMail($data)
    {

        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();

        view()->share([
            'factura' => $this,
            'plantilla' => $plantilla,
        ]);

        $pdf = PDF::loadView('pdf.factura.pdf')->setPaper('Legal');

        $this->clientes->notify(new EnviarFacturaCliente($this, $pdf, $data));
    }
}
