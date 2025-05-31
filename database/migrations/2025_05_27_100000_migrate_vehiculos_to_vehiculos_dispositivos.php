<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Poblar la tabla vehiculos_dispositivos con los datos actuales de los vehículos
        $vehiculos = DB::table('vehiculos')->get();

        foreach ($vehiculos as $vehiculo) {
            // Solo migrar si tiene un IMEI o dispositivo asociado
            if ($vehiculo->dispositivo_imei || $vehiculo->dispositivos_id) {
                DB::table('vehiculos_dispositivos')->insert([
                    'vehiculo_id' => $vehiculo->id,
                    'imei' => $vehiculo->dispositivo_imei,
                    'dispositivo_id' => $vehiculo->dispositivos_id,
                    'fecha_instalacion' => $vehiculo->fecha_instalacion ?? $vehiculo->created_at,
                    'is_principal' => true, // Marcamos como dispositivo principal
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina los registros migrados (opcional)
        // DB::table('vehiculos_dispositivos')->truncate();
    }
};
