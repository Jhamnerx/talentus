<?php

namespace App\Models;

use App\Enums\VentasStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\Controllers\Admin\Facturacion\Api\Util;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Comprobantes extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'comprobantes';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fecha_emision' => 'date:Y-m-d',
        'tipo_cambio' => 'decimal:2',
        'op_gravadas' => 'decimal:2',
        'op_exoneradas' => 'decimal:2',
        'op_inafectas' => 'decimal:2',
        'op_gratuitas' => 'decimal:2',
        'descuento' => 'decimal:2',
        'igv' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'total' => 'decimal:2',
        'cliente_id' => 'integer',
        'sustento_id' => 'integer',
        'sustento_id' => 'string',
        'serie_correlativo' => 'string',
        'user_id' => 'integer',
        'fe_estado' => 'string',
        'estado' => VentasStatus::class,
        'invoice_id' => 'integer',
        'detalle_cuotas' => AsCollection::class,
        'nota' => AsCollection::class,
    ];

    protected function nota(): Attribute
    {
        return new Attribute(
            get: fn ($nota) => json_decode($nota, true),
            set: fn ($nota) => json_encode($nota),
        );
    }

    protected function clase(): Attribute
    {
        return new Attribute(
            get: fn ($nota) => unserialize($nota),
            set: fn ($nota) => serialize($nota),
        );
    }


    public function getSerie(): BelongsTo
    {
        return $this->belongsTo(Series::class, 'serie', 'serie');
    }

    public function venta(): HasOne
    {
        return $this->hasOne(Ventas::class, 'id', 'invoice_id');
    }

    public function notaCreditoDetalles(): HasMany
    {
        return $this->hasMany(NotaCreditoDetalle::class);
    }

    public function tipoComprobante(): BelongsTo
    {
        return $this->belongsTo(\App\Models\TipoComprobantes::class, 'tipo_comprobante_id', 'codigo');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Clientes::class);
    }

    public function sustento(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Sustentos::class);
    }

    public function comprobante(): BelongsTo
    {
        return $this->belongsTo(Ventas::class, 'serie_correlativo_ref', 'serie_correlativo');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }



    //CREAR ITEM DETALLE VENTA
    public static function createItems(Comprobantes $comprobante, $comprobanteItems, $decrease_stock = false)
    {

        foreach ($comprobanteItems as $comprobanteItem) {

            $comprobanteItem['comprobante_id'] = $comprobante->id;

            $item = $comprobante->ventaDetalles()->create($comprobanteItem);

            if ($decrease_stock && $comprobanteItem['tipo'] == 'producto') {

                $item->producto->decrement('stock', $comprobanteItem['cantidad']);
            }
        }

        return $comprobante->ventaDetalles;
    }



    //FUNCION QUE LLAMA A LA CLASE UTIL PARA RENDERIZAR EL PDF
    public function getPdf()
    {

        $util = Util::getInstance();

        $html = $util->getPdfNota($this);
        //return $html;
        $pdf = Pdf::loadHTML($html);
        return $pdf->stream('venta-' . $this->serie_correlativo . '.pdf');
    }

    public function downloadXml()
    {

        $util = Util::getInstance();

        return $util->downloadXml($this);
    }
}
