<?php

namespace App\Models;

use App\Notifications\Ventas\EnviarFacturaCliente;
use App\Scopes\ActiveScope;
use App\Scopes\EmpresaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Barryvdh\DomPDF\Facade\Pdf;

class Facturas extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $table = 'facturas';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'numero' => 'string',
        'sequence_number' => 'integer',
        'fecha_emision' => 'date:Y/m/d',
        'fecha_vencimiento' => 'date:Y/m/d',
        'fecha_pago' => 'date:Y/m/d',
    ];

    protected static function booted()
    {
        //
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

        return plantilla::get('serie')->where('empresas_id', session('empresa'));
    }

    //relacion uno a muchos

    public function detalles()
    {
        return $this->hasMany(DetalleFacturas::class, 'facturas_id');
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
        $plantilla = plantilla::where('empresas_id', session('empresa'))->first();
        $fondo = $plantilla->img_documentos;
        $sello = $plantilla->img_firma;
        view()->share([
            'factura' => $this,
            'plantilla' => $plantilla,
        ]);

        $pdf = PDF::loadView('pdf.factura.pdf');

        if ($action == 1) {

            return $pdf->download('FACTURA ' . $this->serie . "-" . $this->numero . '.pdf');
        } else {

            return $pdf->stream('FACTURA ' . $this->serie . "-" . $this->numero . '.pdf');
        };
    }

    public function getPDFDataToMail($data)
    {

        $plantilla = plantilla::where('empresas_id', session('empresa'))->first();

        view()->share([
            'factura' => $this,
            'plantilla' => $plantilla,
        ]);

        $pdf = PDF::loadView('pdf.factura.pdf');

        $this->clientes->notify(new EnviarFacturaCliente($this, $pdf, $data));
    }
}
