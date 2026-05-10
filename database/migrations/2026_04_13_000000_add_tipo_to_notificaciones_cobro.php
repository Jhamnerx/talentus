<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notificaciones_cobro', function (Blueprint $table) {
            // INICIAL: generada al crear/editar el cobro (cubre el período activo del detalle)
            // RENOVACION: generada por el job diario (cubre el período SIGUIENTE)
            $table->enum('tipo', ['INICIAL', 'RENOVACION'])
                ->default('INICIAL')
                ->after('estado');
        });

        // Backfill: la primera notificacion por detalle_cobro_id es INICIAL (fue creada en Save/Edit),
        // todas las siguientes son RENOVACION (generadas por el job diario).
        // Este heurístico es robusto porque no depende de fecha_vencimiento del detalle,
        // que ya pudo haber sido avanzada por pagos previos.
        DB::statement("
            UPDATE notificaciones_cobro AS nc
            INNER JOIN (
                SELECT detalle_cobro_id, MIN(id) AS primer_id
                FROM notificaciones_cobro
                WHERE deleted_at IS NULL
                GROUP BY detalle_cobro_id
            ) AS primeras ON primeras.detalle_cobro_id = nc.detalle_cobro_id
            SET nc.tipo = 'RENOVACION'
            WHERE nc.deleted_at IS NULL
              AND nc.id != primeras.primer_id
        ");
    }

    public function down(): void
    {
        Schema::table('notificaciones_cobro', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
};
