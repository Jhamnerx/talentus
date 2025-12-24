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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('imei', 15)->nullable()->after('motivo_cancelacion')->comment('IMEI del dispositivo GPS instalado (15 dígitos)');
            $table->string('iccid', 20)->nullable()->after('imei')->comment('ICCID de la tarjeta SIM (19-20 dígitos)');
            $table->string('modelo_dispositivo', 100)->nullable()->after('iccid')->comment('Modelo del dispositivo GPS instalado');
            $table->string('ubicacion_dispositivo')->nullable()->after('modelo_dispositivo')->comment('Ubicación física del dispositivo en el vehículo');
            $table->datetime('fecha_termino')->nullable()->after('fecha_finalizacion')->comment('Fecha y hora real de terminación del trabajo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn([
                'imei',
                'iccid',
                'modelo_dispositivo',
                'ubicacion_dispositivo',
                'fecha_termino',
            ]);
        });
    }
};
