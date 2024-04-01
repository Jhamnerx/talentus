<?php

namespace App\Models;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Http\Controllers\Admin\Facturacion\Api\Util;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EnvioResumen extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $table = 'envio_resumen';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    protected function clase(): Attribute
    {
        return new Attribute(
            get: fn ($nota) => unserialize($nota),
            set: fn ($nota) => serialize($nota),
        );
    }

    public function envioResumenDetalles(): HasMany
    {
        return $this->hasMany(EnvioResumenDetalle::class);
    }

    public function ventas(): HasOne
    {
        return $this->hasOne(Ventas::class, 'id_baja');
    }

    //FUNCION QUE LLAMA A LA CLASE UTIL PARA RENDERIZAR EL PDF
    public function getPdf()
    {

        $util = Util::getInstance();

        $html = $util->getPdfInvoice($this);
        $pdf = Pdf::loadHTML($html);
        return $pdf->stream($this->nombre_xml . '.pdf');
    }

    public function downloadXml()
    {

        $util = Util::getInstance();

        return $util->downloadXml($this);
    }
    public function downloadCdr()
    {

        $util = Util::getInstance();

        return $util->downloadCdr($this);
    }
}
