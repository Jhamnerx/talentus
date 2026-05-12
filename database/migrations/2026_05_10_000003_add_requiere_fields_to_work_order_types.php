<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_order_types', function (Blueprint $table) {
            $table->boolean('muestra_sector')->default(true)->after('es_mantenimiento_programado');
            $table->boolean('muestra_plan')->default(true)->after('muestra_sector');
            $table->boolean('muestra_accesorios_instalar')->default(true)->after('muestra_plan');
        });
    }

    public function down(): void
    {
        Schema::table('work_order_types', function (Blueprint $table) {
            $table->dropColumn(['muestra_sector', 'muestra_plan', 'muestra_accesorios_instalar']);
        });
    }
};
