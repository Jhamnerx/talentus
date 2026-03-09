<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_order_types', function (Blueprint $table) {
            $table->boolean('es_mantenimiento_programado')
                ->default(false)
                ->after('active')
                ->comment('Indica si este tipo se usa para mantenimientos programados');
        });
    }

    public function down(): void
    {
        Schema::table('work_order_types', function (Blueprint $table) {
            $table->dropColumn('es_mantenimiento_programado');
        });
    }
};
