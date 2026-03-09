<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cambios_lineas', function (Blueprint $table) {
            $table->string('vehiculo_placa')->nullable()->after('fecha_suspencion_fin');
            $table->string('old_vehiculo_placa')->nullable()->after('vehiculo_placa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cambios_lineas', function (Blueprint $table) {
            $table->dropColumn(['vehiculo_placa', 'old_vehiculo_placa']);
        });
    }
};
