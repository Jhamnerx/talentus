<?php

namespace App\Models;

use App\Enums\VentasStatus;
use App\Http\Controllers\Admin\Facturacion\Api\Util;
use App\Models\GuiaRemision;
use App\Scopes\EmpresaScope;
use App\Models\VentasDetalle;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\EnvioResumenDetalle;
use Illuminate\Database\Eloquent\Model;
use Luecano\NumeroALetras\NumeroALetras;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ventas extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'ventas';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cliente_id' => 'integer',
        'fecha_emision' => 'date:Y-m-d',
        'fecha_hora_emision' => 'datetime',
        'fecha_vencimiento' => 'date',
        'tipo_cambio' => 'decimal:2',
        'metodo_pago_id' => 'string',
        'op_gravadas' => 'decimal:2',
        'op_exoneradas' => 'decimal:2',
        'op_inafectas' => 'decimal:2',
        'op_gratuitas' => 'decimal:2',
        'igv_op' => 'decimal:2',
        'descuento' => 'decimal:2',
        'descuento_factor' => 'decimal:5',
        'icbper' => 'decimal:2',
        'igv' => 'decimal:2',
        'sub_total' => 'decimal:2',
        'adelanto' => 'decimal:2',
        'total' => 'decimal:2',
        'user_id' => 'integer',
        'fe_estado' => 'string',
        'nota_credito_id' => 'integer',
        'nota_debito_id' => 'integer',
        'bienes_selva' => 'boolean',
        'servicios_selva' => 'boolean',
        'viewed' => 'boolean',
        'sent' => 'boolean',
        'estado' => VentasStatus::class,
        'detalle_cuotas' => AsCollection::class,
        'nota' => AsCollection::class,
    ];

    //GLOBAL SCOPE EMPRESA
    protected static function booted()
    {
        static::addGlobalScope(new EmpresaScope);
    }

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

    public function ventaDetalles(): HasMany
    {
        return $this->hasMany(VentasDetalle::class);
    }

    public function guiaRemisions(): HasMany
    {
        return $this->hasMany(GuiaRemision::class);
    }

    public function envioResumenDetalles(): HasMany
    {
        return $this->hasMany(EnvioResumenDetalle::class);
    }

    public function tipoComprobante(): BelongsTo
    {
        return $this->belongsTo(\App\Models\TipoComprobantes::class, 'tipo_comprobante_id', 'codigo');
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Clientes::class);
    }

    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id', 'codigo');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notaCredito(): BelongsTo
    {
        return $this->belongsTo(NotaCredito::class);
    }

    public function notaDebito(): BelongsTo
    {
        return $this->belongsTo(NotaDebito::class);
    }

    public function getSerie(): BelongsTo
    {
        return $this->belongsTo(Series::class, 'serie', 'serie');
    }
    //CREAR ITEM DETALLE VENTA

    public static function createItems(Ventas $venta, $ventaItems, $decrease_stock = false)
    {

        foreach ($ventaItems as $ventaItem) {

            $ventaItem['ventas_id'] = $venta->id;

            $item = $venta->ventaDetalles()->create($ventaItem);

            if ($decrease_stock && $ventaItem['tipo'] == 'producto') {

                $item->producto->decrement('stock', $ventaItem['cantidad']);
            }
        }

        return $venta->ventaDetalles;
    }

    //FUNCION QUE LLAMA A LA CLASE UTIL PARA RENDERIZAR EL PDF
    public function getPdf()
    {

        $util = Util::getInstance();

        $html = $util->getPdf($this);
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
