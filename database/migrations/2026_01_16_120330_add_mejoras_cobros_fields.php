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
        Schema::table('cobros', function (Blueprint $table) {
            $table->string('estado_cobro')->default('ACTIVO')->after('estado')
                ->comment('ACTIVO, SUSPENDIDO, CANCELADO, CORTESIA');
            $table->boolean('auto_renovar')->default(true)->after('estado_cobro')
                ->comment('Renovar automáticamente al pagar');
            $table->string('grupo_facturacion')->nullable()->after('auto_renovar')
                ->comment('Agrupar vehículos que se facturan juntos');
        });

        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->string('estado_detalle')->default('ACTIVO')->after('estado')
                ->comment('ACTIVO, SUSPENDIDO, CANCELADO, CORTESIA');
            $table->string('grupo_facturacion')->nullable()->after('estado_detalle')
                ->comment('Agrupar vehículos en una misma factura');
            $table->unsignedBigInteger('factura_id')->nullable()->after('grupo_facturacion')
                ->comment('ID de la factura/recibo generado');
            $table->date('fecha_facturado')->nullable()->after('factura_id')
                ->comment('Fecha en que se facturó este detalle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cobros', function (Blueprint $table) {
            $table->dropColumn(['estado_cobro', 'auto_renovar', 'grupo_facturacion']);
        });

        Schema::table('detalles_cobros', function (Blueprint $table) {
            $table->dropColumn(['estado_detalle', 'grupo_facturacion', 'factura_id', 'fecha_facturado']);
        });
    }
};
