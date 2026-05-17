<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Limpieza completa para empezar desde cero.
     *
     * Tablas truncadas:
     *   - old_sim_card_linea       (historial de SIMs anteriores)
     *   - cambios_lineas           (historial de cambios de líneas)
     *   - sim_card_users           (asignaciones de SIM a usuarios)
     *   - lineas                   (líneas telefónicas)
     *   - sim_card                 (tarjetas SIM)
     *   - vehiculos_dispositivos   (asociaciones GPS ↔ vehículo)
     *
     * Columnas eliminadas de vehiculos:
     *   - dispositivo_imei         (sustituida por vehiculos_dispositivos)
     *   - old_imei                 (ya no necesaria)
     *
     * Columnas limpiadas en vehiculos:
     *   - sim_card_id  → null
     *   - numero       → null
     *   - old_numero   → null
     *   - old_sim_card → null
     */
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Vaciar tablas de líneas y SIM
        DB::table('old_sim_card_linea')->truncate();
        DB::table('cambios_lineas')->truncate();
        DB::table('sim_card_users')->truncate();
        // DB::table('lineas')->truncate();
        // DB::table('sim_card')->truncate();

        // Vaciar asociaciones GPS ↔ vehículo
        DB::table('vehiculos_dispositivos')->truncate();

        // Limpiar campos SIM en vehículos
        DB::table('vehiculos')->update([
            'sim_card_id'  => null,
            'numero'       => null,
            'old_numero'   => null,
            'old_sim_card' => null,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Eliminar columnas obsoletas de vehiculos
        Schema::table('vehiculos', function (Blueprint $table) {
            if (Schema::hasColumn('vehiculos', 'dispositivo_imei')) {
                $table->dropColumn('dispositivo_imei');
            }
            if (Schema::hasColumn('vehiculos', 'old_imei')) {
                $table->dropColumn('old_imei');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->string('dispositivo_imei')->nullable()->after('serie');
            $table->string('old_imei')->nullable()->after('dispositivo_imei');
        });
    }
};
