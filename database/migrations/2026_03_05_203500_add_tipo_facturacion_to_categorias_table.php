<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->boolean('es_equipo_gps')->default(false)->after('descripcion');
            $table->boolean('es_servicio_monitoreo')->default(false)->after('es_equipo_gps');
        });
    }

    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
            $table->dropColumn(['es_equipo_gps', 'es_servicio_monitoreo']);
        });
    }
};
