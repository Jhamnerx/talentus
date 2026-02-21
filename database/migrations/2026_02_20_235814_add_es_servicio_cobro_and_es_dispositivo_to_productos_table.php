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
        Schema::table('productos', function (Blueprint $table) {
            $table->boolean('es_servicio_cobro')->default(false)->after('tipo')->comment('Indica si es un servicio para facturar cobros de mensualidades');
            $table->boolean('es_dispositivo')->default(false)->after('es_servicio_cobro')->comment('Indica si el producto es un dispositivo que requiere modelo asociado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn(['es_servicio_cobro', 'es_dispositivo']);
        });
    }
};
