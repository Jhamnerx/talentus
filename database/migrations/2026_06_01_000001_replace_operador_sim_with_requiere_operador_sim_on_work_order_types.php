<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_order_types', function (Blueprint $table) {
            $table->boolean('requiere_operador_sim')->default(false)->after('operador_sim')
                ->comment('El técnico debe especificar el operador SIM al crear la orden');
        });

        // Migrar datos: si tenía un operador predeterminado, asumir que requería uno
        \DB::table('work_order_types')
            ->whereNotNull('operador_sim')
            ->where('operador_sim', '!=', '')
            ->update(['requiere_operador_sim' => true]);

        Schema::table('work_order_types', function (Blueprint $table) {
            $table->dropColumn('operador_sim');
        });
    }

    public function down(): void
    {
        Schema::table('work_order_types', function (Blueprint $table) {
            $table->string('operador_sim')->nullable()->after('requiere_modelo_dispositivo')
                ->comment('Operador SIM predeterminado (revertido)');
            $table->dropColumn('requiere_operador_sim');
        });
    }
};
