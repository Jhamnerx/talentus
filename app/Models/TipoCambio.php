<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TipoCambio extends Model
{
    protected $table = 'tipo_cambios';

    protected $fillable = [
        'fecha',
        'compra',
        'venta',
        'fuente',
    ];

    protected $casts = [
        'fecha' => 'date',
        'compra' => 'decimal:3',
        'venta' => 'decimal:3',
    ];

    /**
     * Busca el tipo de cambio por fecha
     * 
     * @param string|null $fecha Fecha en formato Y-m-d (null = hoy)
     * @return self|null
     */
    public static function porFecha(?string $fecha = null): ?self
    {
        $fecha = $fecha ?? Carbon::today()->format('Y-m-d');
        return self::where('fecha', $fecha)->first();
    }

    /**
     * Crea o actualiza un registro de tipo de cambio
     * 
     * @param array $data Datos con fecha, compra, venta
     * @return self
     */
    public static function guardar(array $data): self
    {
        return self::updateOrCreate(
            ['fecha' => $data['fecha']],
            [
                'compra' => $data['compra'],
                'venta' => $data['venta'],
                'fuente' => $data['fuente'] ?? 'factiliza',
            ]
        );
    }
}
