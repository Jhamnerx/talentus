<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            // Vincula la OT con el presupuesto/cotización que la originó
            // Permite calcular: OT al primer envío, comprobantes 24h, ventas con adelanto
            $table->foreignId('presupuesto_id')
                ->nullable()
                ->after('mantenimiento_id')
                ->constrained('presupuestos')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropForeign(['presupuesto_id']);
            $table->dropColumn('presupuesto_id');
        });
    }
};
