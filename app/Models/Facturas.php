<?php

namespace App\Models;

use App\Scopes\ActiveScope;

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

    
    //Relacion uno a muchos inversa

    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'clientes_id')->withoutGlobalScope(EliminadoScope::class, ActiveScope::class);
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuestos::class, 'presupuestos_id');
    }

    public function getSerie(){

        return plantilla::get('serie')->where('empresas_id', session('empresa'));

    }

    //relacion uno a muchos

    public function detalles()
    {
        return $this->hasMany(DetalleFacturas::class, 'facturas_id');
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
        
        if($action == 1){

            return $pdf->download('FACTURA ' . $this->serie."-".$this->numero.'.pdf');
        }else{
           // return view('pdf.factura.pdf');
           
            return $pdf->stream('FACTURA ' . $this->serie."-".$this->numero.'.pdf');

        };


       // return view('pdf.presupuesto.pdf');
    }

}