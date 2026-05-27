<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_order_types', function (Blueprint $table) {
            $table->string('tipo_equipo')->nullable()->after('muestra_alertas')
                ->comment('gps | sensor_adas | velocimetro | null = cualquier equipo');
            $table->boolean('requiere_modelo_dispositivo')->default(false)->after('tipo_equipo')
                ->comment('Solicitar modelo del dispositivo al crear la orden');
            $table->string('operador_sim')->nullable()->after('requiere_modelo_dispositivo')
                ->comment('Operador SIM predeterminado: Claro, Movistar, Entel, Bitel');
            $table->boolean('requiere_alertas')->default(false)->after('operador_sim')
                ->comment('Las alertas son obligatorias en este tipo de orden');
        });
    }

    public function down(): void
    {
        Schema::table('work_order_types', function (Blueprint $table) {
            $table->dropColumn(['tipo_equipo', 'requiere_modelo_dispositivo', 'operador_sim', 'requiere_alertas']);
        });
    }
};
