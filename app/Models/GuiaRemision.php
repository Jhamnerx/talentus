<?php

namespace App\Models;

use App\Scopes\EmpresaScope;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\ModalidadTraslado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Http\Controllers\Admin\Facturacion\Api\Util;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GuiaRemision extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'guia_remision';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cliente_id' => 'integer',
        'fecha_emision' => 'date',
        'venta_id' => 'integer',
        'fecha_inicio_traslado' => 'date',
        'user_id' => 'integer',
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

    protected function dataPuerto(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }


    public function cliente(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Clientes::class);
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Ventas::class);
    }

    public function motivoTraslado(): BelongsTo
    {
        return $this->belongsTo(MotivoTraslado::class, 'motivo_traslado_id', 'codigo');
    }

    public function modalidadTransporte(): BelongsTo
    {
        return $this->belongsTo(ModalidadTransporte::class, 'modalidad_transporte_id', 'codigo');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getSerie(): BelongsTo
    {
        return $this->belongsTo(Series::class, 'serie', 'serie');
    }

    public function detalle()
    {
        return $this->hasMany(detalleGuiaRemision::class, 'guia_remision_id');
    }

    public static function createItems($guia, $items)
    {
        foreach ($items as $item) {

            $item['guia_remision_id'] = $guia->id;

            $guia->detalle()->create($item);
        }
    }

    public function dispositivos(): BelongsToMany
    {
        return $this->belongsToMany(Dispositivos::class, 'dispositivos_users', 'guia_remision_id', 'imei', 'id', 'imei')->using(DispositivosUsers::class)
            ->withPivot('user_id', 'guia_remision_id ', 'created_at')->withTimestamps();
    }

    public function sim_cards(): BelongsToMany
    {
        return $this->belongsToMany(SimCard::class, 'sim_card_users', 'guia_remision_id', 'sim_card', 'id', 'sim_card')->using(SimCardUsers::class)
            ->withPivot('user_id', 'guia_remision_id ', 'created_at')->withTimestamps();
    }

    //FUNCION QUE LLAMA A LA CLASE UTIL PARA RENDERIZAR EL PDF
    public function getPdf()
    {

        $util = Util::getInstance();

        $html = $util->getPdfGuia($this);
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
