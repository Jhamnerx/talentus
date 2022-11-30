<?php

namespace App\Models;

use App\Notifications\Ventas\EnviarReciboCliente;
use App\Scopes\EliminadoScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;

class Recibos extends Model
{
    use HasFactory;

    public const COMPLETADO = 'COMPLETADO';
    public const BORRADOR = 'BORRADOR';

    public const PAID = 'PAID';
    public const UNPAID = 'UNPAID';


    public const PEN = 'PEN';
    public const USD = 'USD';

    protected $table = 'recibos';

    protected $casts = [
        'numero' => 'string',
        'sequence_number' => 'integer',
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
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id');
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuestos::class, 'presupuestos_id');
    }

    //relacion uno a muchos

    public function detalles()
    {
        return $this->hasMany(DetalleRecibos::class, 'recibos_id');
    }

    public function payments()
    {

        return $this->morphMany(Payments::class, 'paymentable');
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
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'recibo' => $this,
            'plantilla' => $plantilla,
        ]);

        $pdf = PDF::loadView('pdf.recibo.pdf');

        if ($action == 1) {

            return $pdf->download('RECIBO ' . $this->serie . "-" . $this->numero . '.pdf');
        } else {
            // return view('pdf.factura.pdf');

            return $pdf->stream('RECIBO ' . $this->serie . "-" . $this->numero . '.pdf');
        };


        // return view('pdf.presupuesto.pdf');
    }

    public function getPDFDataToMail($data)
    {

        $plantilla = plantilla::where('empresa_id', session('empresa'))->first();

        view()->share([
            'recibo' => $this,
            'plantilla' => $plantilla,
        ]);

        $pdf = PDF::loadView('pdf.recibo.pdf');

        $this->clientes->notify(new EnviarReciboCliente($this, $pdf, $data));
    }
}
