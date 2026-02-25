<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Hace el campo 'plan' nullable para permitir la coexistencia de ambos sistemas:
     * - Sistema LEGACY: plan_id = NULL, campo 'plan' tiene valor (texto o numérico)
     * - Sistema NUEVO: plan_id tiene valor, campo 'plan' = NULL
     * 
     * Esto mejora la lógica de detección en los accessors del modelo DetalleCobros:
     * - plan_nombre: Si 'plan' es NULL → usa plan_id relación
     * - monto_calculado: Si 'plan' es NULL → calcula desde plan_id
     */
    public function up(): void
    {
        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->string('plan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalles_cobros', function (Blueprint $table) {
            // Restaurar a NOT NULL (requiere valor por defecto o datos válidos)
            $table->string('plan')->nullable(false)->change();
        });
    }
};
