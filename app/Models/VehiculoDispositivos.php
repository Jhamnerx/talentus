<?php

namespace App\Models;

use App\Models\Vehiculos;
use Illuminate\Database\Eloquent\Model;

class VehiculoDispositivos extends Model
{

    protected $table = 'vehiculos_dispositivos';

    protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'fecha_instalacion' => 'datetime',
        'fecha_desinstalacion' => 'datetime',
        'is_principal' => 'boolean', // Nuevo campo para marcar el principal
    ];

    // protected $fillable = [
    //     'vehiculo_id',
    //     'imei',
    //     'dispositivo_id',
    //     'fecha_instalacion',
    //     'fecha_desinstalacion',
    //     'hash',
    //     'created_at',
    //     'updated_at',
    //     'is_principal', // Nuevo campo para marcar el principal
    // ];

    /**
     * Verifica si un dispositivo está disponible para asignación
     * 
     * @param int $dispositivo_id ID del dispositivo a verificar
     * @param int|null $vehiculo_id ID del vehículo actual (para excluirlo en caso de edición)
     * @return array [bool $disponible, ?Vehiculos $vehiculo_asignado, string $mensaje]
     */
    public static function dispositivoDisponible($dispositivo_id, $vehiculo_id = null)
    {
        $query = self::where('dispositivo_id', $dispositivo_id)
            ->whereNull('fecha_desinstalacion');

        if ($vehiculo_id) {
            $query->where('vehiculo_id', '!=', $vehiculo_id);
        }

        $asignacion = $query->first();

        if (!$asignacion) {
            return [true, null, '']; // Está disponible
        }

        $vehiculo = Vehiculos::find($asignacion->vehiculo_id);
        return [
            false,
            $vehiculo,
            'El dispositivo ya está asignado a otro vehículo'
        ]; // No está disponible, devuelve el vehículo asignado
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculos::class, 'vehiculo_id');
    }

    public function dispositivo()
    {
        return $this->belongsTo(Dispositivos::class, 'dispositivo_id');
    }
}
